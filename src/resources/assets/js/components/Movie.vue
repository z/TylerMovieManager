<style scoped>

</style>

<template>
    <div class="col-md-6">
        <div class="card">
            <div class="card-image">
                <img class="img-responsive" :src="movie.image">

            </div><!-- card image -->

            <div class="card-content">
                <span class="card-title">{{ movie.title }}</span>
                <button type="button" class="btn btn-custom show-reveal pull-right" aria-label="details"  @click="show = !show">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <h4 class="pull-right">{{ movie.year }}</h4>
            </div><!-- card content -->
            <div class="card-action">
                <a href="#">WATCH</a>
                <span class="pull-right">
                    <span>{{ movie.length }}</span>
                    <span>{{ movie.format_id }}</span>
                    <i class="fa fa-star"></i> {{ movie.rating }}
                </span>
            </div><!-- card actions -->
            <transition name="custom-slide-transition"
                        enter-active-class="animated flipInX"
                        leave-active-class="animated flipOutX"
            >
                <div class="card-reveal" v-if="show">
                    <span class="card-title">{{ movie.title }}</span> <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="show = !show"><span aria-hidden="true">×</span></button>
                    <p>Here is some more information about this product that is only revealed once clicked on.</p>
                </div><!-- card reveal -->
            </transition>
        </div>
    </div>
</template>

<script>
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
                var movie = this.movie;
                var image = 'http://lorempixel.com/750/250/sports/' + movie.id;
                movie['image'] = image;
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
