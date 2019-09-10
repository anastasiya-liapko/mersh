<template>
  <div id="js-bannerContent" class="banner banner_content">
    <div class="banner_content__img"></div>
  </div>
</template>

<script>
export default {

}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.banner_content
  z-index: -1
  position: absolute
  width: 100%
  height: 100%
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.5)
  transition: height 0.15s linear
  overflow: hidden
  &::before,
  &::after
    content: ''
    position: absolute
    top: 0
    left: 0
    right: 0
    bottom: 0
  &::before
    background-image: linear-gradient(to top, rgba(255, 255, 255, 0.5), rgba(0, 0, 0, 0.5))
  &::after
    background-image: linear-gradient(to top, #281917, rgba(36, 22, 15, 0.19))

.banner_content__img
  position: absolute
  width: 100%
  height: 100%
  filter: blur(34px)
  background-image: url(../assets/img/banner.jpg)
  background-position: top center
  background-size: 100% auto
  background-repeat: no-repeat
</style>
