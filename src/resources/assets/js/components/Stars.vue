<style scoped>
.star-rating__checkbox {
  position: absolute;
  overflow: hidden;
  clip: rect(0 0 0 0);
  height: 1px;
  width: 1px;
  margin: -1px;
  padding: 0;
  border: 0;
}

.star-rating__star {
  display: inline-block;
  padding: 3px;
  vertical-align: middle;
  line-height: 1.5em;
  font-size: 1.5em;
  color: #ABABAB;
  transition: color .2s ease-out;
}

.star-rating__star:hover {
  cursor: pointer;
}

.star-rating__star.is-selected {
  color: #FFD700;
}

.star-rating__star.is-disabled:hover {
  cursor: default;
}
</style>

<template>
    <div class="star-rating">
        <label class="star-rating__star" v-for="rating in ratings" :id="id"
               :class="{'is-selected': ((the_value >= rating) && the_value != null), 'is-disabled': disabled}"
               v-on:click="set(rating)" v-on:mouseover="starOver(rating)" v-on:mouseout="starOut">
            <input class="star-rating star-rating__checkbox" type="radio" :value="the_value" :name="name" v-model="the_value" :disabled="disabled" :required="required">★
        </label>
    </div>
</template>

<script>
// Based on: https://jsfiddle.net/olimorris/swyuarc9/
export default {

    props: [
        'bus',
        'name',
        'value',
        'id',
        'disabled',
        'required'
    ],

    /*
     * Initial state of the component's data.
     */
    data: function () {
        return {
            temp_value: null,
            the_value: this.value,
            ratings: [1, 2, 3, 4, 5]
        };
    },

    methods: {
        /*
         * Behavior of the stars on mouseover.
         */
        starOver: function (index) {
            var vm = this;

            if (!this.disabled) {
                this.temp_value = this.the_value;
                return this.the_value = index;
            }

        },

        /*
         * Behavior of the stars on mouseout.
         */
        starOut: function () {
            var vm = this;

            if (!this.disabled) {
                return this.the_value = this.temp_value;
            }
        },

        /*
         * Set the rating of the score
         */
        set: function (rating) {
            var vm = this;

            if (!this.disabled) {
                // Make some call to a Laravel API using Vue.Resource
                var data = {
                    rating: rating
                }
                if (this.id) {
                    data['id'] = this.id;
                }
                this.bus.$emit('movieRated', data);
                this.temp_value = rating;
                return this.the_value = rating;
            }
        }
    }
}
</script>