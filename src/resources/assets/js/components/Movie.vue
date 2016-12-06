<style scoped>

</style>

<template>
    <div class="col-md-6" v-if="movie.length > 0 && visible">
        <div class="card">
            <div class="card-image">
                <img class="img-responsive" :src="movie.image">
            </div><!-- card image -->

            <div class="card-content">
                <span class="card-title">{{ the_movie.title }}</span>
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-custom dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" @click="edit = !edit" v-on:click.prevent>Edit <i class="fa fa-pencil pull-right fa-custom"></i></a></li>
                        <li><a href="#" v-on:click.prevent="deleteMovie">Delete <i class="fa fa-trash pull-right fa-custom"></i></a></li>
                    </ul>
                </div>
                <h4 class="pull-right">{{ the_movie.year }}</h4>
            </div><!-- card content -->
            <div class="card-action">
                <a href="#" @click="details = !details" v-on:click.prevent>DETAILS</a>
                <span><em>{{ the_movie.format }}</em></span>
                <span class="pull-right">
                    <span class="btn-custom"><i class="fa fa-clock-o"></i> {{ the_movie.duration }}</span>
                    <span class="btn-custom"><i class="fa fa-star"></i> {{ the_movie.rating }}</span>
                </span>
            </div><!-- card actions -->
            <transition name="custom-slide-transition"
                        enter-active-class="animated flipInX"
                        leave-active-class="animated flipOutX"
            >
                <div class="card-reveal" v-if="details">
                    <span class="card-title">{{ the_movie.title }}</span> <button type="button" class="close light" data-dismiss="modal" aria-label="Close" @click="details = !details"><span aria-hidden="true">×</span></button>
                    <img class="img-responsive" :src="movie.image">
                    <p>{{ the_movie.overview }}</p>
                    <p><a :href="the_movie.imdb" class="btn btn-default" target="_blank">IMDb</a></p>
                </div><!-- card reveal -->

                <div class="card-reveal" v-if="edit">
                    <span class="card-title">{{ the_movie.title }}</span> <button type="button" class="close light" data-dismiss="modal" aria-label="Close" @click="edit = !edit"><span aria-hidden="true">×</span></button>

                    <form class="form-horizontal">
                        <fieldset>

                            <legend>Edit</legend>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="title">Title</label>
                                <div class="col-md-7">
                                    <input id="title" name="title" type="text" placeholder="Movie Title" class="form-control input-md" v-model="movie.title">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="format">Format</label>
                                <div class="col-md-4">
                                    <select id="format" name="format" class="form-control" v-model.number="movie.format_id">
                                        <option value="1">VHS</option>
                                        <option value="2">DVD</option>
                                        <option value="3">Streaming</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="length">Length</label>
                                <div class="col-md-3">
                                    <input id="length" name="length" type="text" placeholder="90" class="form-control input-md" v-model.number="movie.length">
                                </div>
                                <label class="col-md-1 control-label" for="year">Year</label>
                                <div class="col-md-3">
                                    <input id="year" name="year" type="text" placeholder="2016" class="form-control input-md" v-model.number="movie.year">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Rating</label>
                                <div class="col-md-8">
                                    <star-rating :id="movie.id" :value="movie.rating" :bus="bus" class="pull-left"></star-rating>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-3">
                                    <button class="btn btn-success" v-on:click.prevent="updateMovie">Save Changes</button>
                                    <button class="btn btn-danger" v-on:click.prevent="edit = !edit">Cancel</button>
                                </div>
                            </div>

                        </fieldset>
                    </form>
                </div><!-- card reveal -->

            </transition>
        </div>
    </div>
</template>

<script>
    const moment = require('moment');

    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                visible: true,
                dropdown: false,
                details: false,
                edit: false,
                token: GLOBAL.token,
            };
        },

        props: [
            'movie',
            'bus'
        ],

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            var vm = this;
            vm.bus.$on('movieRated', function(data) {
                if (data['id'] == vm.the_movie.id) {
                    vm.the_movie['rating'] = data['rating'];
                }
                return;
            })
        },

        computed: {
            the_movie: function() {
                var vm = this;
                var formats = {
                    1: 'VHS',
                    2: 'DVD',
                    3: 'Streaming',
                };
                var movie = vm.movie;
                movie['format'] = formats[movie.format_id];
                movie['duration'] = moment.utc(moment.duration(parseInt(movie.length * 60000)).asMilliseconds()).format("H [h] mm [m]");

                var image = 'http://lorempixel.com/555/312/people/' + (movie.id % 10);

                movie['image'] = image;

                vm.$http.get('/token/guidebox/search/' + vm.movie.title + '?api_token=' + vm.token)
                        .then(response => {
                            // check response and handle error
                            var metadata = response.data;
                            movie['overview'] = metadata.overview;
                            movie['imdb'] = 'http://www.imdb.com/title/' + metadata.imdb;
                            if (metadata.image) {
                                movie['image'] = metadata.image;
                            }
                        })


                return movie;
            }
        },

        methods: {
            /**
             * Update the movie.
             */
            updateMovie() {
                this.$http.put('/token/movies/' + this.movie.id + '?api_token=' + this.token, this.movie)
                        .then(response => {
                            // check response and handle error

                            this.edit = false;
                        })
            },

            /**
             * Delete the movie.
             */
            deleteMovie() {
                var vm = this;
                this.$http.delete('/token/movies/' + this.movie.id + '?api_token=' + this.token)
                        .then(response => {
                            // check response and handle error

                            // send an event to an event bus that the parent is listening on
                            this.bus.$emit('removeMovie', vm.movie);
                            this.visible = false;
                        })
            }
        }
    }
</script>
