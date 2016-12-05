<style scoped>

</style>

<template>
    <div class="col-md-6" v-if="movie.length > 0">
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
                        <li><a href="#" @click="edit = !edit" v-on:click.prevent>Edit</a></li>
                        <li><a href="#" v-on:click.prevent="deleteMovie">Delete</a></li>
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
                    <span class="card-title">{{ the_movie.title }}</span> <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="details = !details"><span aria-hidden="true">×</span></button>
                    <img class="img-responsive" :src="movie.image">
                    <p>{{ the_movie.overview }}</p>
                    <p><a :href="the_movie.imdb" target="_blank">IMDb</a></p>
                </div><!-- card reveal -->

                <div class="card-reveal" v-if="edit">
                    <span class="card-title">{{ the_movie.title }}</span> <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="edit = !edit"><span aria-hidden="true">×</span></button>

                    <form class="form-horizontal">
                        <fieldset>

                            <legend>Edit</legend>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="title">Title</label>
                                <div class="col-md-7">
                                    <input id="title" name="title" type="text" placeholder="Movie Title" class="form-control input-md" v-model="movie.title">
                                </div>
                            </div>

                            <!-- Select Basic -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="format">Format</label>
                                <div class="col-md-7">
                                    <select id="format" name="format" class="form-control" v-model.number="movie.format_id">
                                        <option value="1">VHS</option>
                                        <option value="2">DVD</option>
                                        <option value="3">Streaming</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="year">Year</label>
                                <div class="col-md-7">
                                    <input id="year" name="year" type="text" placeholder="2016" class="form-control input-md" v-model.number="movie.year">
                                </div>
                            </div>

                            <!-- Multiple Radios (inline) -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="rating">Rating</label>
                                <div class="col-md-7">
                                    <label class="radio-inline" for="rating-0">
                                        <input type="radio" name="rating" id="rating-0" value="1" v-model.number="movie.rating">
                                        1
                                    </label>
                                    <label class="radio-inline" for="rating-1">
                                        <input type="radio" name="rating" id="rating-1" value="2" v-model.number="movie.rating">
                                        2
                                    </label>
                                    <label class="radio-inline" for="rating-2">
                                        <input type="radio" name="rating" id="rating-2" value="3" v-model.number="movie.rating">
                                        3
                                    </label>
                                    <label class="radio-inline" for="rating-3">
                                        <input type="radio" name="rating" id="rating-3" value="4" v-model.number="movie.rating">
                                        4
                                    </label>
                                    <label class="radio-inline" for="rating-4">
                                        <input type="radio" name="rating" id="rating-4" value="5" v-model.number="movie.rating">
                                        5
                                    </label>
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="length">Length</label>
                                <div class="col-md-7">
                                    <input id="length" name="length" type="text" placeholder="90" class="form-control input-md" v-model.number="movie.length">
                                    <span class="help-block">In minutes</span>
                                </div>
                            </div>

                            <!-- Button (Double) -->
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="button1id"></label>
                                <div class="col-md-7">
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
                movie['duration'] = moment.utc(moment.duration(parseInt(movie.length*60*60)).asMilliseconds()).format("HH:mm:ss");

                vm.$http.get('/token/guidebox/search/' + vm.movie.title + '?api_token=' + vm.token)
                        .then(response => {
                            // check response and handle error
                            var metadata = response.data;
                            movie['overview'] = metadata.overview;
                            movie['imdb'] = 'http://www.imdb.com/title/' + metadata.imdb;
                            movie['image'] = metadata.image;
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
                        })
            }
        }
    }
</script>
