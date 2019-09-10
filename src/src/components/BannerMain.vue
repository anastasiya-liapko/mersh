<template>
  <div id="js-bannerMain" class="banner banner_main">
    <!-- <video class="banner__video" muted="muted" loop="loop" preload="auto" autoplay="autoplay">
      <source v-if="bannerVideo !== ''" :src="bannerVideo" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
      Тег video не поддерживается вашим браузером.
    </video> -->
    <div class="banner__slider">
      <app-slick v-if="slider !== ''" class="product-slider"
        ref="slick"
        :options="slickOptions"
        @beforeChange="handleBeforeChange"
        @init="handleInit">
        <div
          class="position-relative"
          v-for="image in slider"
          v-bind:key="image.id">
          <div>
            <a>
              <video
                v-if="image.is_video === 1"
                muted="muted"
                loop="loop"
                preload="auto"
                width="100%">
                <source
                  :src="image.content"
                  type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                Тег video не поддерживается вашим браузером.
              </video>
              <img
                v-if="image.is_video === 0"
                :src="image.content"
                alt="">
            </a>
          </div>
          <i
            class="product-slider__sound fas fa-volume-mute d-flex align-items-center justify-content-start"
            v-if="image.is_video === 1 && showMute"
            @click="showMute = !showMute">
          </i>
          <i
            class="product-slider__sound fas fa-volume-up d-flex align-items-center justify-content-start"
            v-if="image.is_video === 1 && !showMute"
            @click="showMute = !showMute">
          </i>
        </div>
      </app-slick>
    </div>

    <div class="container d-flex">
      <router-link class="banner__button d-flex align-items-center justify-content-center"
        :to="{name: 'new'}"
        tag="a">
        {{ buttonText }}
      </router-link>
    </div>

  </div>
</template>

<script>
import axios from 'axios'
import Slick from 'vue-slick'
import { domenMixin } from '@/mixins'

export default {
  data () {
    return {
      slickOptions: {
        slidesToShow: 1,
        dots: true,
        arrows: false
      },
      slider: '',
      showMute: true,
      currentSlide: 0,
      buttonText: 'Новые поступления',
      domen: process.env.VUE_APP_DOMEN
    }
  },
  created () {
    this.domen = location.origin
    this.fetch()
  },
  mounted: function () {
    // this.setMarginToBanner()
    // window.addEventListener('resize', this.setMarginToBanner)
    // window.addEventListener('scroll', this.setMarginToBanner)

    // this.setHeightToBanner()
    // window.addEventListener('resize', this.setHeightToBanner)
    // window.addEventListener('scroll', this.setHeightToBanner)
  },
  beforeDestroy: function () {
    // window.removeEventListener('resize', this.setMarginToBanner)
    // window.removeEventListener('scroll', this.setMarginToBanner)

    // window.removeEventListener('resize', this.setHeightToBanner)
    // window.removeEventListener('scroll', this.setHeightToBanner)
  },
  methods: {
    fetch () {
      var context = this

      axios.get(context.domen + '/api/info/slider')
        .then(res => {
          // console.log(res.data)
          context.slider = res.data
        })
        .catch(error => console.log(error))
    },
    handleBeforeChange (event, slick, currentSlide, nextSlide) {
      if (slick.$slides[currentSlide].querySelector('video')) {
        slick.$slides[currentSlide].querySelector('video').muted = true
        slick.$slides[currentSlide].querySelector('video').pause()
        this.showMute = true
      }

      if (slick.$slides[nextSlide].querySelector('video')) {
        slick.$slides[nextSlide].querySelector('video').currentTime = 0
        slick.$slides[nextSlide].querySelector('video').play()
      }
    },
    handleInit (event, slick) {
      var video = document.querySelector('.slick-current video')
      if (video) {
        video.play()
      }
    }
    // setMarginToBanner () {
    //   var header = document.getElementById('js-header')
    //   var banner = document.getElementById('js-bannerMain')
    //   banner.setAttribute('style', 'margin-top: -' + header.offsetHeight + 'px')
    //   var interval = setInterval(function () {
    //     banner.setAttribute('style', 'margin-top: -' + header.offsetHeight + 'px')
    //   }, 10)
    //   setTimeout(function () {
    //     banner.setAttribute('style', 'margin-top: -' + header.offsetHeight + 'px')
    //     clearInterval(interval)
    //   }, 300)
    // },
    // setHeightToBanner () {
    //   var header = document.getElementById('js-header')
    //   var banner = document.querySelector('.banner')
    //   var video = document.querySelector('.banner__video')
    //   banner.setAttribute('style', 'height: ' + video.offsetHeight + 'px')
    //   setTimeout(function () {
    //     banner.setAttribute('style', 'height: ' + video.offsetHeight + 'px')
    //   }, 300)
    // }
  },
  watch: {
    showMute: function () {
      var video = document.querySelector('.slick-active video')
      if (video) {
        this.showMute ? video.muted = true : video.muted = false
      }
    }
  },
  components: {
    'app-slick': Slick
  },
  mixins: [domenMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.banner_main
  position: relative
  width: 100%
  height: auto
  overflow: hidden
  .container
    position: absolute
    top: 0
    left: 50%
    width: 100%
    height: 100%
    margin-left: -720px
    // margin-left: -37.500vw
    padding-left: 6.094vw
    padding-right: 6.094vw
    // padding-bottom: 127px
    padding-bottom: 6.615vw
    pointer-events: none
    transition: height 0.3s linear

.banner__slider
  width: 100%
  // min-height: 56vw
  // height: auto
  height: 49.688vw
  background-color: $color-brown
  img,
  video
    width: 100%
    height: 49.688vw
    object-fit: cover
  .slick-dots
    overflow: visible
    li
      box-shadow: 0 0 3px rgba(0,0,0,0.5)

.banner__button
  // width: 360px
  // height: 80px
  width: 18.750vw
  height: 4.167vw
  margin-top: auto
  margin-left: auto
  font-family: $font-montserrat
  // font-size: 18px
  // line-height: calc(80px - 2px * 2)
  font-size: 0.938vw
  // line-height: calc(4.167vw - 2px * 2)
  line-height: 1
  font-weight: 400
  text-align: center
  text-transform: uppercase
  text-shadow: 1px 1px 2px black
  box-shadow: 0 0 3px rgba(0,0,0,0.5)
  color: $color-white
  background-color: rgba(255, 255, 255, 0.26)
  // border: 2px solid $color-white
  border: 0.104vw solid $color-white
  pointer-events: auto
  transition: background-color 0.3s linear
  &:hover
    text-decoration: none
    color: $color-white
    background-color: transparent

@media(min-width: 1775px)
  .banner_main
    .container
      margin-left: -863px

@media(max-width: 1489px)
  .banner_main
    .container
      margin-left: -570px

@media(max-width: 1199px)
  .banner_main
    .container
      margin-left: -480px
      padding-left: 15px
      padding-right: 15px

  .banner__button
    width: 18.750vw
    height: 4.167vw
    font-size: 0.938vw

@media(max-width: 991px)
  .banner_main
    .container
      margin-left: -360px

@media(max-width: 767px)
  .banner_main
    .container
      margin-left: -270px

  .banner__button
    width: calc(18.750vw * #{$gain-m})
    height: calc(4.167vw * #{$gain-m})
    font-size: calc(0.938vw * #{$gain-m})
    border: calc(0.104vw * #{$gain-m}) solid $color-white

@media(max-width: 575px)
  .banner_main
    .container
      left: 0
      margin-left: 0
      padding-bottom: calc(6.615vw * 1.4)

  .banner__button
    width: calc(18.750vw * #{$gain-m} * 1.4)
    height: calc(4.167vw * #{$gain-m} * 1.4)
    font-size: calc(0.938vw * #{$gain-m} * 1.4)
    border: calc(0.104vw * #{$gain-m} * 1.4) solid $color-white

</style>
