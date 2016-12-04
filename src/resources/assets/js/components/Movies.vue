<style scoped>

</style>

<template>
    <div>
        <div v-if="movies.length > 0">
            <div class="row">
                <div class="col-md-12">
                    <input type="checkbox" id="1" value="1" v-model.number="selected_formats"> VHS
                    <input type="checkbox" id="2" value="2" v-model.number="selected_formats"> DVD
                    <input type="checkbox" id="3" value="3" v-model.number="selected_formats"> Streaming
                    <span>|</span>
                    Sort:
                    <select v-model.number="sorting_selected">
                        <option v-for="sorting_option in sorting_options" v-bind:value="sorting_option.value" type="number">
                            {{ sorting_option.text }}
                        </option>
                    </select>
                    <select v-model.number="sort_order">
                        <option v-for="sorting_direction in sorting_directions" v-bind:value="sorting_direction.value" type="number">
                            {{ sorting_direction.text }}
                        </option>
                    </select>
                    <span>|</span>
                    <span>
                        Rating:
                        <select v-model.number="rating_selected">
                            <option v-for="rating_option in rating_options" v-bind:value="rating_option.value" type="number">
                                {{ rating_option.text }}
                            </option>
                        </select>
                    </span>
                    <input v-model="query" class="pull-right">
                </div>
            </div>
            <div class="row">
                <div id="movie-collection">
                    <div v-for="movie in computedList">
                        <movie v-bind:movie="movie"></movie>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            Log in to see your movie collection.
        </div>
    </div>

</template>

<script>

    // http://stackoverflow.com/a/8175221
    function sortByKey(array, key) {
        return array.sort(function(a, b) {
            var x = a[key]; var y = b[key];
            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
        });
    }

    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                query: '',
                selected_formats: [1,2,3],
                rating_selected: 0,
                rating_options: [
                  { text: 'All', value: false },
                  { text: '1', value: 1 },
                  { text: '2', value: 2 },
                  { text: '3', value: 3 },
                  { text: '4', value: 4 },
                  { text: '5', value: 5 },
                ],
                sorting_selected: 'title',
                sorting_options: [
                  { text: 'Alphabetical', value: 'title' },
                  { text: 'Rating', value: 'rating' },
                  { text: 'Length', value: 'length' },
                ],
                sorting_directions: [
                  { text: 'ASC', value: 'ASC' },
                  { text: 'DESC', value: 'DESC' },
                ],
                sort_order: 'ASC',
                movies: [],
                show: false,
                token: GLOBAL.token,
            };
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
        },

        computed: {
            computedList: function () {
                var vm = this;

                var data = this.movies.filter(function (movie) {
                   return movie.title.toLowerCase().indexOf(vm.query.toLowerCase()) !== -1
                })

                if (vm.selected_formats) {
                    data = data.filter(function (movie) {
                        return vm.selected_formats.indexOf(parseInt(movie.format_id)) > -1
                    });
                }

                if (vm.rating_selected) {
                    data = data.filter(function (movie) {
                        return movie.rating == vm.rating_selected;
                    });
                }

                data = sortByKey(data, vm.sorting_selected)

                if (vm.sort_order == 'DESC') {
                    data.reverse()
                }

                return data;
            }
        },

        methods: {
            /**
             * Prepare the component (Vue 2.x).
             */
            prepareComponent() {
                this.getMovies();
            },

            /**
             * Get all of the authorized tokens for the user.
             */
            getMovies() {
                this.$http.get('/token/movies/?api_token=' + this.token)
                        .then(response => {
                            var movies = response.data;
                            for (var i = 0; i < movies.length; i++) {
                                var movie = movies[i];
                                var image = 'http://lorempixel.com/750/250/sports/' + movie.id;
                                movie['image'] = image;
                            }
                            this.movies = movies;
                        });
            }
        }
    }


</script>
