<template>
  <div class="privacy pay d-flex flex-column">

    <div class="container container-main d-flex flex-grow-1">
      <div class="container-inner">

        <h2 class="title privacy__title text-center">{{ payment.title }}</h2>
        <!-- <p class="subtitle privacy__subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor </p> -->
        <div class="text privacy__text" v-html="payment.txt"></div>

        <h2 class="title privacy__title text-center"> {{ delivery.title }}</h2>
        <!-- <p class="subtitle privacy__subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor </p> -->
        <div class="text privacy__text" v-html="delivery.txt"></div>

      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios'
import { scrollMixin } from '@/mixins'

export default {
  name: 'pay',
  data () {
    return {
      delivery: '',
      payment: '',
      domen: process.env.VUE_APP_DOMEN
    }
  },
  created () {
    this.fetch()
  },
  beforeDestroy () {
    this.scroll(0)
  },
  methods: {
    fetch () {
      var context = this

      axios.get(context.domen + '/api/info/services')
        .then(res => {
          // console.log(res)
          context.delivery = res.data.delivery
          context.payment = res.data.payment
        })
        .catch(error => console.log(error))
    }
  },
  mixins: [scrollMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'

</style>
