<style scoped>

</style>

<template>
    <div>
        <div v-if="movies.length > 0">
            <ul id="movie-collection">
              <li v-for="movie in movies">
                {{ movie.title }}
              </li>
            </ul>
        </div>
        <div v-else>
            Token Fail, log in to see your movie collection.
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
                movies: [],
                token: GLOBAL.token,
            };
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.prepareComponent();
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
                console.log(this.data);
                this.$http.get('/token/movies/?api_token=' + this.token)
                        .then(response => {
                            this.movies = response.data;
                        });
            },

            /**
             * Revoke the given token.
             */
            revoke(token) {
                this.$http.delete('/token/movies/' + movie.id + '?api_token=' + this.token)
                        .then(response => {
                            this.getMovies();
                        });
            }
        }
    }
</script>
