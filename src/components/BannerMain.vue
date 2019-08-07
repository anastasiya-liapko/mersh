<template>
  <div id="js-bannerMain" class="banner banner_main">
    <video class="banner__video" muted="muted" loop="loop" preload="auto" autoplay="autoplay">
      <source v-if="bannerVideo !== ''" :src="bannerVideo" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
      Тег video не поддерживается вашим браузером.
    </video>
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

export default {
  data () {
    return {
      bannerVideo: '',
      buttonText: 'Новые поступления',
      domen: process.env.VUE_APP_DOMEN
    }
  },
  created () {
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

      axios.get(context.domen + '/api/info/header')
        .then(res => {
          // console.log(res.data)
          context.bannerVideo = res.data.banner.video
        })
        .catch(error => console.log(error))
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
  }
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

.banner__video
  width: 100%
  // min-height: 56vw
  height: auto
  background-color: $color-brown

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

  .banner__button
    width: calc(18.750vw * #{$gain-m} * 1.4)
    height: calc(4.167vw * #{$gain-m} * 1.4)
    font-size: calc(0.938vw * #{$gain-m} * 1.4)
    border: calc(0.104vw * #{$gain-m} * 1.4) solid $color-white

</style>
