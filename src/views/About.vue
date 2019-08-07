<template>
  <div class="privacy about d-flex flex-column">

    <div class="container container-main d-flex flex-grow-1">
      <div class="container-inner">

        <h2 class="title privacy__title text-center">{{ info.title }}</h2>
        <div class="about__img-wrapper about__img-wrapper_1 d-flex">
          <img :src="mainImage" alt="">
        </div>
        <!-- <p class="subtitle privacy__subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor </p> -->
        <div class="text privacy__text" v-html="info.txt"></div>

        <div class="about__img-wrapper about__img-wrapper_2 d-flex flex-wrap align-items-center justify-content-between">
          <img :src="image.img"
            alt=""
            v-for="(image, i) in images"
            v-bind:key="i">
        </div>

      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios'
import { scrollMixin } from '@/mixins'

export default {
  name: 'about',
  data () {
    return {
      info: '',
      images: [],
      mainImage: '',
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

      axios.get(context.domen + '/api/info/about')
        .then(res => {
          // console.log(res)
          context.info = res.data.info
          context.images = res.data.images
          context.mainImage = res.data.main_image.img
        })
        .catch(error => console.log(error))
    }
  },
  mixins: [scrollMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.about__img-wrapper_1
  // margin-bottom: 97px
  margin-bottom: 5.052vw

.about__img-wrapper_2
  // margin-top: 100px
  margin-top: 5.208vw
  img
    width: 48.25%
    // margin-bottom: 39px
    margin-bottom: 2.031vw

@media(max-width: 1199px)
  .about__img-wrapper_2
    img
      margin-bottom: calc(39px / #{$lose-m})

@media(max-width: 991px)
  .about__img-wrapper_2
    img
      margin-bottom: calc(39px / #{$lose-s})

@media(max-width: 575px)
  .about__img-wrapper_2
    img
      margin-bottom: calc(2.031vw * #{$gain-xs})
</style>
