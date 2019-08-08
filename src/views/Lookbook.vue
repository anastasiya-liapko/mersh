<template>
  <div class="lookbook d-flex flex-column">
    <div class="container container-main d-flex flex-grow-1">
      <div class="container-inner">
        <div class="lookbook__header" :style="'background-image: url(' + main_image + ')'">
          <p class="lookbook__name text-center">{{ info.title }}</p>
          <h2 class="title lookbook__title text-center">Современные ювелирные украшения</h2>
        </div>

        <div class="lookbook__content d-flex flex-column flex-sm-row">
          <div class="lookbook__descr">
            <!-- <p class="subtitle privacy__subtitle lookbook__subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p> -->
            <div class="text privacy__text lookbook__text" v-html="info.txt"></div>
          </div>
        <div v-if="images !== ''" class="lookbook__slider">
          <app-slick ref="slick"
            :options="slickOptions">
            <div v-for="(image, i) in images"
              v-bind:key="'image' + i">
              <a>
                <img class="lookbook__slider-img" :src="image.img" alt="">
              </a>
            </div>
          </app-slick>
        </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Slick from 'vue-slick'
import { scrollMixin } from '@/mixins'

export default {
  name: 'lookbook',
  data () {
    return {
      slickOptions: {
        slidesToShow: 1,
        dots: true
      },
      info: '',
      main_image: '',
      images: '',
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

      axios.get(context.domen + '/api/info/lookbook')
        .then(res => {
          // console.log(res)
          context.info = res.data.info
          context.main_image = res.data.main_image.img
          context.images = res.data.images
          // console.log(context.$refs.slick)
        })
        .catch(error => console.log(error))
    }
  },
  components: {
    'app-slick': Slick
  },
  mixins: [scrollMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.lookbook
  .container-inner
    // padding-top: 68px
    // padding-bottom: 61px
    padding-top: 3.542vw
    padding-bottom: 3.177vw

.lookbook__header
  // width: 1160px
  // height: 711px
  // margin-bottom: 64px
  // padding-top: 70px
  // padding-left: 180px
  // padding-right: 180px
  width: 60.417vw
  height: 37.031vw
  margin-bottom: 3.333vw
  padding-top: 3.646vw
  padding-left: 9.375vw
  padding-right: 9.375vw
  // background-image: url(../assets/img/lookbook.jpg)
  background-position: center
  background-size: cover
  background-repeat: no-repeat
  background-color: $color-brown

.lookbook__name
  // margin-bottom: 15px
  margin-bottom: 0.781vw
  font-family: $font-cormorant
  // font-size: 14px
  font-size: 0.729vw
  font-weight: 700
  line-height: 1
  // letter-spacing: 11px
  letter-spacing: 0.573vw
  text-transform: uppercase
  color: $color-white

.lookbook__title
  color: $color-white

.lookbook__descr
  // width: 460px
  // margin-right: 40px
  width: 23.958vw
  margin-right: 2.083vw

.lookbook__slider
  // width: 660px
  // height: 529px
  width: 34.375vw
  height: 27.552vw
  .lookbook__slider-img
    width: 34.375vw
    height: 27.552vw
    object-fit: cover

.lookbook__subtitle,
.lookbook__text
  padding-right: 0

@media(max-width: 1199px)
  .lookbook
    .container-inner
      padding-top: calc(68px / #{$lose-m})
      padding-bottom: calc(61px / #{$lose-m})

  .lookbook__header
    width: calc(1160px / #{$lose-m})
    height: calc(711px / #{$lose-m})
    margin-bottom: calc(64px / #{$lose-m})
    padding-top: calc(70px / #{$lose-m})
    padding-left: calc(180px / #{$lose-m})
    padding-right: calc(180px / #{$lose-m})

  .lookbook__name
    margin-bottom: calc(15px / #{$lose-m})
    font-size: calc(14px / #{$lose-m})
    letter-spacing: calc(11px / #{$lose-m})

  .lookbook__descr
    width: calc(460px / #{$lose-m})
    margin-right: calc(40px / #{$lose-m})

  .lookbook__slider
    width: calc(660px / #{$lose-m})
    height: calc(529px / #{$lose-m})
    .lookbook__slider-img
      width: calc(660px / #{$lose-m})
      height: calc(529px / #{$lose-m})

@media(max-width: 991px)
  .lookbook
    .container-inner
      padding-top: calc(68px / #{$lose-s})
      padding-bottom: calc(61px / #{$lose-s})

  .lookbook__header
    width: calc(1160px / #{$lose-s})
    height: calc(711px / #{$lose-s})
    margin-bottom: calc(64px / #{$lose-s})
    padding-top: calc(70px / #{$lose-s})
    padding-left: calc(180px / #{$lose-s})
    padding-right: calc(180px / #{$lose-s})

  .lookbook__name
    margin-bottom: calc(15px / #{$lose-s})
    font-size: calc(14px / #{$lose-s})
    letter-spacing: calc(11px / #{$lose-s})

  .lookbook__descr
    width: calc(460px / #{$lose-s})
    margin-right: calc(40px / #{$lose-s})

  .lookbook__slider
    width: calc(660px / #{$lose-s})
    height: calc(529px / #{$lose-s})
    .lookbook__slider-img
      width: calc(660px / #{$lose-s})
      height: calc(529px / #{$lose-s})

@media(max-width: 767px)
  .lookbook
    .container-inner
      padding-top: calc(68px / #{$lose-xs})
      padding-bottom: calc(61px / #{$lose-xs})

  .lookbook__header
    width: calc(1160px / #{$lose-xs})
    height: calc(711px / #{$lose-xs})
    margin-bottom: calc(64px / #{$lose-xs})
    padding-top: calc(70px / #{$lose-xs})
    padding-left: calc(180px / #{$lose-xs})
    padding-right: calc(180px / #{$lose-xs})

  .lookbook__name
    margin-bottom: calc(15px / #{$lose-xs})
    font-size: calc(14px / #{$lose-xs})
    letter-spacing: calc(11px / #{$lose-xs})

  .lookbook__descr
    width: calc(460px / #{$lose-xs})
    margin-right: calc(40px / #{$lose-xs})

  .lookbook__slider
    width: calc(660px / #{$lose-xs})
    height: calc(529px / #{$lose-xs})
    .lookbook__slider-img
      width: calc(660px / #{$lose-xs})
      height: calc(529px / #{$lose-xs})

@media(max-width: 575px)
  .lookbook
    .container-main
      padding: 0
    .container-inner
      padding-top: 0
      padding-bottom: calc(3.177vw * #{$gain-xs})

  .lookbook__header
    width: 100vw
    height: calc(37.031vw * #{$gain-xs})
    margin-bottom: calc(3.333vw * #{$gain-xs})
    padding-top: calc(3.646vw * #{$gain-xs})
    padding-left: 15px
    padding-right: 15px

  .lookbook__name
    margin-bottom: calc(0.781vw * #{$gain-xs})
    font-size: calc(0.729vw * #{$gain-xs} * 1.7)
    letter-spacing: calc(0.573vw * #{$gain-xs})

  .lookbook__content
    padding-left: 15px
    padding-right: 15px

  .lookbook__descr
    width: 100%
    margin-right: calc(2.083vw * #{$gain-xs})
    margin-bottom: calc(3.333vw * #{$gain-xs} / 2)

  .lookbook__slider
    width: calc(100vw - 30px)
    height: calc((100vw - 30px) * 80.15 / 100)
    .lookbook__slider-img
      width: calc(100vw - 30px)
      height: calc((100vw - 30px) * 80.15 / 100)
</style>
