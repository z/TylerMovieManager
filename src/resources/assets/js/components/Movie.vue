<style scoped>

</style>

<template>
    <div class="col-md-6">
        <div class="card">
            <div class="card-image">
                <img class="img-responsive" :src="movie.image">

            </div><!-- card image -->

            <div class="card-content">
                <span class="card-title">{{ the_movie.title }}</span>
                <button type="button" class="btn btn-custom show-reveal pull-right" aria-label="details" @click="show = !show">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <h4 class="pull-right">{{ the_movie.year }}</h4>
            </div><!-- card content -->
            <div class="card-action">
                <a href="#" @click="show = !show" v-on:click.prevent="onClick">VIEW</a>
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
                <div class="card-reveal" v-if="show">
                    <span class="card-title">{{ the_movie.title }}</span> <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="show = !show"><span aria-hidden="true">×</span></button>
                    <p>Here is some more information about this product that is only revealed once clicked on.</p>
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
                show: false,
                token: GLOBAL.token,
            };
        },

        props: [
            'movie'
        ],

        computed: {
            the_movie: function() {
                var formats = {
                    1: 'VHS',
                    2: 'DVD',
                    3: 'Streaming',
                };
                var movie = this.movie;
                var image = 'http://lorempixel.com/750/250/sports/' + movie.id;
                movie['image'] = image;
                movie['format'] = formats[movie.format_id];
                movie['duration'] = moment.utc(moment.duration(parseInt(movie.length*60*60)).asMilliseconds()).format("HH:mm:ss");
                return movie;
            }
        },

        methods: {
            /**
             * Revoke the given token.
             */
            delete(movieId) {
                this.$http.delete('/token/movies/' + movieId + '?api_token=' + this.token)
            }
        }
    }
</script>
