<template>
  <div class="privacy d-flex flex-column">

    <div class="container container-main d-flex flex-grow-1">
      <div class="container-inner">

        <h2 class="title privacy__title text-center">{{ info.title }}</h2>
        <!-- <p class="subtitle privacy__subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor </p> -->
        <div class="text privacy__text" v-html="info.txt"></div>

      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios'
import { scrollMixin, domenMixin } from '@/mixins'

export default {
  name: 'privacy',
  data () {
    return {
      info: '',
      domen: process.env.VUE_APP_DOMEN
    }
  },
  created () {
    this.domen = location.origin
    this.fetch()
  },
  beforeDestroy () {
    this.scroll(0)
  },
  methods: {
    fetch () {
      var context = this

      axios.get(context.domen + '/api/info/privacy')
        .then(res => {
          // console.log(res)
          context.info = res.data
        })
        .catch(error => console.log(error))
    }
  },
  mixins: [scrollMixin, domenMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'

</style>
