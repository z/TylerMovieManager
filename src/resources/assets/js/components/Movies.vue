<style scoped>

</style>

<template>
    <div>
        <div>
            <div class="row">
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <div class="input-group">
                                <input v-model="query" type="text" class="form-control" placeholder="Search">
                                <div class="input-group-btn">
                                    <button class="btn btn-dark" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="filter-options col-md-8 col-sm-12">
                            <div class="form-inline">

                                <label class="col-md-1 control-label inline-label" for="title">Sort: </label>
                                <select id="sorting" class="form-control" v-model.number="sorting_selected">
                                    <option v-for="sorting_option in sorting_options" v-bind:value="sorting_option.value" type="number">
                                        {{ sorting_option.text }}
                                    </option>
                                </select>

                                <select id="ordering" class="form-control" v-model.number="sort_order">
                                    <option v-for="sorting_direction in sorting_directions" v-bind:value="sorting_direction.value" type="number">
                                        {{ sorting_direction.text }}
                                    </option>
                                </select>

                                <select id="" class="form-control" v-model.number="rating_selected">
                                    <option v-for="rating_option in rating_options" v-bind:value="rating_option.value" type="number">
                                        {{ rating_option.text }}
                                    </option>
                                </select>

                                <div class="checkbox">
                                    <input id="3" value="3" v-model.number="selected_formats" class="checkbox-custom" name="checkbox-group" type="checkbox">
                                    <label for="3" class="checkbox-custom-label">Streaming</label>
                                </div>
                                <div class="checkbox">
                                    <input id="2" value="2" v-model.number="selected_formats" class="checkbox-custom" name="checkbox-group" type="checkbox">
                                    <label for="2" class="checkbox-custom-label">DVD</label>
                                </div>
                                <div class="checkbox">
                                    <input id="1" value="1" v-model.number="selected_formats" class="checkbox-custom" name="checkbox-group" type="checkbox">
                                    <label for="1" class="checkbox-custom-label">VHS</label>
                                </div>


                            </div>
                        </div><!-- .filter-options -->

                        <div class="col-md-1 col-sm-12">
                            <button class="btn btn-success pull-right" @click="showModal = true">Add Movie</button>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div id="movie-collection">
                    <div v-for="(movie, index) in computedList" v-if="movies.length > 0">
                        <movie-item v-bind:movie="movie" v-bind:bus="bus" v-on:removeMovie="movies.splice(index, 1)"></movie-item>
                    </div>
                    <div v-else>
                        Log in to see your movie collection.
                    </div>
                </div>
            </div>
        </div>

        <transition name="modal" v-if="showModal" @close="showModal = false">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">
                        <div class="card">
                            <div class="card-new">
                                <button type="button" class="close light" data-dismiss="modal" aria-label="Close" @click="showModal = false"><span aria-hidden="true">×</span></button>

                                <form class="form-horizontal">
                                    <fieldset>

                                        <legend>Add</legend>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="title">Title</label>
                                            <div class="col-md-7">
                                                <input id="title" name="title" type="text" placeholder="Movie Title" class="form-control input-md" v-model="newMovie.title">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="format">Format</label>
                                            <div class="col-md-4">
                                                <select id="format" name="format" class="form-control" v-model.number="newMovie.format_id">
                                                    <option value="1">VHS</option>
                                                    <option value="2">DVD</option>
                                                    <option value="3">Streaming</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="length">Length</label>
                                            <div class="col-md-3">
                                                <input id="length" name="length" type="text" placeholder="90" class="form-control input-md" v-model.number="newMovie.length">
                                            </div>
                                            <label class="col-md-1 control-label" for="year">Year</label>
                                            <div class="col-md-3">
                                                <input id="year" name="year" type="text" placeholder="2016" class="form-control input-md" v-model.number="newMovie.year">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Rating</label>
                                            <div class="col-md-8">
                                                <star-rating :value="newMovie.rating" :bus="bus" v-model.number="newMovie.rating"class="pull-left"></star-rating>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-7 col-md-offset-3">
                                                <button class="btn btn-success" v-on:click.prevent="addMovie">Save</button>
                                                <button class="btn btn-danger" v-on:click.prevent @click="showModal = false">Cancel</button>
                                            </div>
                                        </div>

                                    </fieldset>
                                </form>
                            </div><!-- card reveal -->
                        </div>
                    </div>
                </div>
            </div>
        </transition>
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

    var bus = new Vue();

    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                bus: bus,
                showModal: false,
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
                newMovie: {},
                token: GLOBAL.token,
            };
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            var vm = this;
            vm.prepareComponent();
            vm.bus.$on('cancelAdd', function(movie) {
                vm.newMovie = {};
                vm.showModal = false;
                return;
            })
            vm.bus.$on('movieRated', function(data) {
                vm.newMovie['rating'] = data['rating'];
                return;
            })
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
                axios.get('/token/movies/?api_token=' + this.token)
                        .then(response => {
                            var movies = response.data;
                            for (var i = 0; i < movies.length; i++) {
                                var movie = movies[i];
                                movie['image'] = '';
                            }
                            this.movies = movies;
                        });
            },

            addMovie() {

                var vm = this;

                var formats = {
                    1: 'VHS',
                    2: 'DVD',
                    3: 'Streaming',
                };

                var movie = {
                    'title': vm.newMovie.title,
                    'format': formats[vm.newMovie.format_id],
                    'year': vm.newMovie.year,
                    'length': vm.newMovie.length,
                    'rating': vm.newMovie.rating,
                }

                axios.post('/token/movies?api_token=' + vm.token, movie)
                        .then(response => {
                            // check response and handle error

                            vm.newMovie['image'] = 'http://lorempixel.com/555/312/people/' + (
Math.ceil(Math.random() * 10) % 10);

                            this.movies.push(vm.newMovie);

                            vm.newMovie = {};
                            vm.showModal = false;
                        })
            }
        },
    }


</script>
