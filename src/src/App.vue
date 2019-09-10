<template>
  <div id="app" class="app d-flex flex-column">
    <app-header></app-header>

    <div class="page-wrapper d-flex flex-column flex-grow-1">
      <transition name="fade-down" mode="out-in" appear>
        <!-- <keep-alive include="home-view,info-view"> -->
          <router-view :key="$route.fullPath" class="page flex-grow-1"/>
        <!-- </keep-alive> -->
      </transition>
    </div>

    <app-footer></app-footer>

    <app-nav></app-nav>
    <app-call></app-call>
    <app-success></app-success>
    <app-order></app-order>
  </div>
</template>

<script>
// import { scrollMixin } from '@/mixins'
import { mapActions } from 'vuex'
import Header from '@/components/Header.vue'
import Footer from '@/components/Footer.vue'
import Nav from '@/components/Nav.vue'
import Call from '@/components/PopupCall.vue'
import Success from '@/components/PopupSuccess.vue'
import Order from '@/components/PopupOrder.vue'

export default {
  // watch: {
  //   '$route' (to, from) {
  //     this.scroll(0)
  //   }
  // },
  created () {
    var self = this
    var products = JSON.parse(localStorage.getItem('mershProducts'))
    if (products) {
      products.forEach(function (elem) {
        self.addToCart(elem)
      })
    }
    var order = JSON.parse(localStorage.getItem('mershOrder'))
    if (order) {
      this.setOrder(order)
    }
    var orderNumber = JSON.parse(localStorage.getItem('mershOrderNumber'))
    if (orderNumber) {
      this.setOrderNumber(orderNumber)
    }
  },
  methods: {
    ...mapActions([
      'addToCart',
      'setOrder',
      'setOrderNumber'
    ])
  },
  components: {
    'app-header': Header,
    'app-footer': Footer,
    'app-nav': Nav,
    'app-call': Call,
    'app-success': Success,
    'app-order': Order
  }
  // mixins: [scrollMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
html
  height: 100%

body
  min-height: 100%
  display: flex
  flex-direction: column
  img
    width: 100%
    height: auto
  button,
  input,
  textarea
    &:focus
      outline: none
  input,
  textarea
    -webkit-appearance: none
    border-radius: 0
    &::placeholder
      opacity: 0.7
      transition: opacity 0.3s linear
    &:focus
      outline: none
      &::placeholder
        opacity: 0

.modal-backdrop,
.modal-backdrop.show
  opacity: 0.71
  background-color: #b6babf

#app
  flex-grow: 1
  width: 100%
  min-height: 100vh
  font-family: $font-montserrat
  -webkit-font-smoothing: antialiased
  -moz-osx-font-smoothing: grayscale
  text-align: left
  color: #000000
  background-image: radial-gradient(circle at 73% 11%, #ffffff, #f1e5dd)
  &.fixed
    position: fixed
    min-height: 100%

.container
  padding: 0

// .page-wrapper
//   min-height: calc(100vh - #{$height-header})

.container-inner
  // width: 1161px
  width: 60.469vw
  margin: 0 auto
  // padding-left: 282.5px
  // padding-right: 282.5px
  // padding-left: 14.714vw
  // padding-right: 14.714vw
  border-bottom: 0.208vw solid $color-grey

.clearfix
  overflow: auto

.button
  padding: 0

.button_form,
.button_form-page
  // width: 360px
  // height: 80px
  width: 18.750vw
  height: 4.167vw
  font-family: $font-montserrat
  // font-size: 18px
  font-size: 0.938vw
  font-weight: 400
  // line-height: 80px
  line-height: 4.167vw
  text-align: center
  text-transform: uppercase
  color: $color-white
  background-color: $color-brown
  border: none
  transition: background-color 0.3s linear, opacity 0.3s linear
  &:disabled
    opacity: 0.7
  &:hover:not(:disabled)
    text-decoration: none
    color: $color-white
    background-color: $color-text
    cursor: pointer

@keyframes shake-horizontal
  0%,
  100%
    transform: translateX(0)
  10%,
  30%,
  50%,
  70%
    transform: translateX(-10px)
  20%,
  40%,
  60%
    transform: translateX(10px)
  80%
    transform: translateX(8px)
  90%
    transform: translateX(-8px)

@keyframes scale-in-center
  0%
    transform: scale(0)
    opacity: 0
  100%
    transform: scale(1)
    opacity: 1

.button_submit
  position: relative
  overflow: hidden
  transition: 0.35s ease all

.button_submit::before
  content: attr(data-success)
  position: absolute
  top: -4.167vw
  left: 0
  width: 100%
  // opacity: 0.9
  box-sizing: border-box

.button_submit::after
  content: attr(data-error)
  position: absolute
  top: 0
  left: 0
  width: 100%
  opacity: 0
  box-sizing: border-box

.button_submit.success
  line-height: calc(4.167vw * 3)
  // box-shadow: 0 0 3px rgba(black, 0.5) inset

.button_submit.error
  animation: shake-horizontal 0.7s cubic-bezier(0.455, 0.030, 0.515, 0.955) both
  &::after
    animation: scale-in-center 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both
  span
    opacity: 0

.title
  font-family: $font-cormorant-sc
  // font-size: 50px
  font-size: 2.604vw
  line-height: 1
  font-weight: 700
  text-transform: uppercase
  color: $color-brown

.subtitle,
.subtitle p
  font-family: $font-montserrat
  // font-size: 22px
  font-size: 1.146vw
  line-height: 1.55
  font-weight: 700
  color: $color-text

.text,
.text p,
p
  font-family: $font-montserrat
  // font-size: 22px
  font-size: 1.146vw
  line-height: 1.55
  font-weight: 500
  color: $color-text

.privacy
  .container-inner
    // padding-top: 12px
    // padding-bottom: 95px
    padding-top: 0.625vw
    padding-bottom: 4.948vw

.privacy__title
  // margin-bottom: 57px
  // padding-left: 150px
  // padding-right: 150px
  // margin-top: 80px
  margin-top: 4.167vw
  margin-bottom: 2.969vw
  padding-left: 7.813vw
  padding-right: 7.813vw

.privacy__subtitle
  // margin-bottom: 40px
  margin-bottom: 2.083vw

.privacy__subtitle,
.privacy__text
  // padding-right: 192px
  padding-right: 10vw
  & p
    // padding-right: 192px
    // padding-right: 10vw
  p:first-child
    // margin-bottom: 40px
    margin-bottom: 2.083vw
    font-family: $font-montserrat
    // font-size: 22px
    font-size: 1.146vw
    line-height: 1.55
    font-weight: 700
    color: $color-text

.slide-left-enter,
.slide-left-enter-active
  animation: slide-in-left 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) both

.slide-left-leave,
.slide-left-leave-active
  animation: slide-out-left 0.5s cubic-bezier(0.550, 0.085, 0.680, 0.530) both

@keyframes slide-in-left
  0%
    transform: translateX(-1000px)
    // opacity: 0
  100%
    transform: translateX(0)
    // opacity: 1

@keyframes slide-out-left
  0%
    transform: translateX(0)
    // opacity: 1
  100%
    transform: translateX(-1000px)
    // opacity: 0

.fade-left-enter,
.fade-left-enter-active
  animation-name: fadeInLeft
  animation-duration: 0.5s

.fade-left-leave,
.fade-left-leave-active
  animation-name: fadeOutLeft
  animation-duration: 0.3s

@keyframes fadeInLeft
  from
    // opacity: 0.05
    opacity: 0
    transform: translate3d(-60px, 0, 0)
  to
    opacity: 1
    transform: none

@keyframes fadeOutLeft
  from
    opacity: 1
    transform: none
  to
    // opacity: 0.05
    opacity: 0
    transform: translate3d(-60px, 0, 0)

.slide-left-infinite
  animation: slide-left-infinite 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) infinite alternate-reverse both

@keyframes slide-left-infinite
  0%
    transform: translateX(0px)
  100%
    transform: translateX(0.521vw)

.icon-3d-wrapper
  &:hover .icon-3d
    // -webkit-animation: icon3dWhite 200ms infinite
    // animation: icon3dWhite 200ms infinite
    // transform: rotateY(360deg)
    // font-weight: 700
  &:hover .icon-3d-text
    // text-shadow: 0 0 4px $icon3dWhite1

@keyframes icon3d
  0%
    text-shadow: 5px 4px $redColor, -5px -6px $blueColor
  25%
    text-shadow: -5px -6px $redColor, 5px 4px $blueColor
  50%
    text-shadow: 5px -4px $redColor, -8px 4px $blueColor
  75%
    text-shadow: -8px -4px $redColor, -5px -4px $blueColor
  100%
    text-shadow: -5px 0 $redColor, 5px -4px $blueColor

@keyframes icon3dWhite
  0%
    text-shadow: 2.5px 2px $icon3dWhite1, -2.5px -3px $icon3dWhite2
  25%
    text-shadow: -2.5px -3px $icon3dWhite1, 2.5px 2px $icon3dWhite2
  50%
    text-shadow: 2.5px -2px $icon3dWhite1, -4px 2px $icon3dWhite2
  75%
    text-shadow: -4px -2px $icon3dWhite1, -2.5px -2px $icon3dWhite2
  100%
    text-shadow: -2.5px 0 $icon3dWhite1, 2.5px -2px $icon3dWhite2

@keyframes icon3dBrown
  0%
    text-shadow: 2.5px 2px $icon3dBrown1, -2.5px -3px $icon3dBrown2
  25%
    text-shadow: -2.5px -3px $icon3dBrown1, 2.5px 2px $icon3dBrown2
  50%
    text-shadow: 2.5px -2px $icon3dBrown1, -4px 2px $icon3dBrown2
  75%
    text-shadow: -4px -2px $icon3dBrown1, -2.5px -2px $icon3dBrown2
  100%
    text-shadow: -2.5px 0 $icon3dBrown1, 2.5px -2px $icon3dBrown2

// slick-slider
.slick-slider
  position: relative
  display: block
  // height: 100%
  height: inherit
  box-sizing: border-box
  -webkit-user-select: none
  -moz-user-select: none
  -ms-user-select: none
  user-select: none
  -webkit-touch-callout: none
  -khtml-user-select: none
  -ms-touch-action: pan-y
  touch-action: pan-y
  -webkit-tap-highlight-color: transparent

.slick-list
  position: relative
  display: block
  overflow: hidden
  height: inherit
  margin: 0
  padding: 0

.slick-list:focus
  outline: none

.slick-list.dragging
  cursor: pointer
  cursor: hand

.slick-slider .slick-track,
.slick-slider .slick-list
  -webkit-transform: translate3d(0, 0, 0)
  -moz-transform: translate3d(0, 0, 0)
  -ms-transform: translate3d(0, 0, 0)
  -o-transform: translate3d(0, 0, 0)
  transform: translate3d(0, 0, 0)

.slick-track
  position: relative
  top: 0
  left: 0
  display: flex
  align-items: center
  height: inherit
  margin-left: auto
  margin-right: auto

.slick-track:before,
.slick-track:after
  display: table
  content: ''

.slick-track:after
  clear: both

.slick-loading .slick-track
  visibility: hidden

.slick-slide
  display: none
  float: left
  height: 100%
  min-height: 1px
  div
    height: inherit
  a
    display: flex !important
    align-items: center
    height: inherit
    overflow: hidden

[dir='rtl'] .slick-slide
  float: right

.slick-slide img
  display: block
  width: 100%
  height: auto
  margin: 0 auto

.slick-slide.slick-loading img
  display: none

.slick-slide.dragging img
  pointer-events: none

.slick-initialized .slick-slide
  display: block

.slick-loading .slick-slide
  visibility: hidden

.slick-vertical .slick-slide
  display: block
  height: auto
  border: 1px solid transparent

.slick-arrow.slick-hidden
  display: none

.slick-prev,
.slick-next
  z-index: 10
  position: absolute
  top: 50%
  right: 0
  // width: 77px
  // height: 77px
  width: 4.010vw
  height: 4.010vw
  padding: 0
  font-size: 0
  background-color: $color-beige
  border: none
  transition: background-color 0.3s
  &::before,
  &::after
    position: absolute
    content: ''
    top: 50%
    left: 50%
    // width: 15px
    // height: 2px
    // margin-left: -7px
    width: 0.781vw
    height: 0.104vw
    margin-left: -0.365vw
    background-color: $color-brown
    transition: background-color 0.3s
  &:hover
    background-color: $color-brown
    &::before,
    &::after
      background-color: $color-white

.slick-prev
  // margin-top: -77px
  margin-top: -4.010vw
  &::before
    // margin-top: 4px
    margin-top: 0.208vw
    transform: rotate(45deg)
  &::after
    // margin-top: calc(-9px + 4px)
    margin-top: calc(-0.469vw + 0.208vw)
    transform: rotate(-45deg)

.slick-next
  // margin-bottom: 77px
  margin-bottom: 4.010vw
  &::before
    // margin-top: calc(-9px + 4px)
    margin-top: calc(-0.469vw + 0.208vw)
    transform: rotate(45deg)
  &::after
    // margin-top: 4px
    margin-top: 0.208vw
    transform: rotate(-45deg)

.slick-dots
  z-index: 10
  position: absolute
  left: 0
  // bottom: 28px
  bottom: 1.458vw
  display: flex
  justify-content: center
  width: 100%
  margin: 0
  padding: 0
  overflow: hidden
  li
    // margin-right: 14px
    margin-right: 0.729vw
    font-size: 0
    button
      // width: 76px
      // height: 7px
      width: 3.958vw
      height: 0.365vw
      padding: 0
      font-size: 0
      background-color: rgba(255, 255, 255, 0.25)
      border: none
      transition: background-color 0.3s
      &:hover
        background-color: rgba(255, 255, 255, 1)
    &:last-child
      margin-right: 0
  li.slick-active
    button
      background-color: rgba(255, 255, 255, 1)

.product-slider__sound
  z-index: 10
  position: absolute
  // right: 15px
  // bottom: 15px
  // width: 60px
  // height: 55px
  // padding: 15px
  right: 0
  bottom: 0
  width: 3.125vw
  height: 2.865vw
  padding: 0.781vw
  &:hover
    cursor: pointer
  &::before
    // font-size: 25px
    font-size: 1.302vw
    color: $color-white
    text-shadow: 1px 1px 2px black

@keyframes fadeInDown
  from
    // opacity: 0.05
    opacity: 0
    transform: translate3d(0, -60px, 0)
  to
    opacity: 1
    transform: none

@keyframes fadeOutUp
  from
    opacity: 1
    transform: none
  to
    // opacity: 0.05
    opacity: 0
    transform: translate3d(0, -60px, 0)

.fade-down-enter-active
  animation-name: fadeInDown
  animation-duration: 0.5s

.fade-down-leave-active
  animation-name: fadeOutUp
  animation-duration: 0.3s

@media(min-width: 1490px)
  .container
    min-width: 1440px

@media(min-width: 1775px)
  .container
    min-width: 1725px

@media(max-width: 1199px)
  .container
    padding: 0 15px

  .container-inner
    width: 100%
    border-bottom: calc(4px / #{$lose-m}) solid $color-grey

  .title
    font-size: calc(50px / #{$lose-m})

  .subtitle,
  .subtitle p
    font-size: calc(22px / #{$lose-m})

  .text,
  .text p,
  p
    font-size: calc(22px / #{$lose-m})

  .button_form-page
    width: calc(360px / #{$lose-m})
    height: calc(80px / #{$lose-m})
    font-size: calc(18px / #{$lose-m})
    line-height: calc(80px / #{$lose-m})

  .button_submit::before
    top: calc(-80px / #{$lose-m})

  .button_form
    &::before
      top: -4.167vw

  .button_submit.success
    line-height: calc(80px / #{$lose-m} * 3)

  .button_form.success
    line-height: calc(4.167vw * 3)

  .privacy
    .container-inner
      padding-top: calc(12px / #{$lose-m})
      padding-bottom: calc(115px / #{$lose-m})

  .privacy__title
    margin-top: calc(80px / #{$lose-m})
    margin-bottom: calc(57px / #{$lose-m})
    padding-left: calc(150px / #{$lose-m})
    padding-right: calc(150px / #{$lose-m})

  .privacy__subtitle
    margin-bottom: calc(40px / #{$lose-m})

  .privacy__subtitle,
  .privacy__text
    padding-right: 0
    & p
      // padding-right: 0
    p:first-child
      margin-bottom: calc(40px / #{$lose-m})
      font-size: calc(22px / #{$lose-m})

  @keyframes slide-left-infinite
    0%
      transform: translateX(0px)
    100%
      transform: translateX(calc(0.521vw * #{$gain-m}))

  .slick-prev,
  .slick-next
    width: calc(77px / #{$lose-m})
    height: calc(77px / #{$lose-m})
    &::before,
    &::after
      width: calc(15px / #{$lose-m})
      height: calc(2px / #{$lose-m})
      margin-left: calc(-7px / #{$lose-m})

  .slick-prev
    margin-top: calc(-77px / #{$lose-m})
    &::before
      margin-top: calc(4px / #{$lose-m})
    &::after
      margin-top: calc(-9px / #{$lose-m} + 4px / #{$lose-m})

  .slick-next
    margin-bottom: calc(77px / #{$lose-m})
    &::before
      margin-top: calc(-9px / #{$lose-m} + 4px / #{$lose-m})
    &::after
      margin-top: calc(4px / #{$lose-m})

  .slick-dots
    bottom: calc(28px / #{$lose-m})
    li
      margin-right: calc(14px / #{$lose-m})
      button
        width: calc(76px / #{$lose-m})
        height: calc(7px / #{$lose-m})

  .product-slider__sound
    width: calc(60px / #{$lose-m})
    height: calc(55px / #{$lose-m})
    padding: calc(15px / #{$lose-m})
    &::before
      font-size: calc(25px / #{$lose-m})

@media(max-width: 991px)
  .container-inner
    width: 100%
    // width: calc(60.469vw * #{$gain-s})
    border-bottom: calc(4px / #{$lose-s}) solid $color-grey

  .title
    font-size: calc(50px / #{$lose-s})

  .subtitle,
  .subtitle p
    font-size: calc(22px / #{$lose-s})

  .text,
  .text p,
  p
    font-size: calc(22px / #{$lose-s})

  .button_form
    width: calc(18.750vw * #{$gain-m})
    height: calc(4.167vw * #{$gain-m})
    font-size: calc(0.938vw * #{$gain-m})
    line-height: calc(4.167vw * #{$gain-m})

  .button_form-page
    width: calc(360px / #{$lose-s})
    height: calc(80px / #{$lose-s})
    font-size: calc(18px / #{$lose-s})
    line-height: calc(80px / #{$lose-s})

  .button_submit::before
    top: calc(-80px / #{$lose-s})

  .button_form
    &::before
      top: calc(-4.167vw * #{$gain-m})

  .button_submit.success
    line-height: calc(80px / #{$lose-s} * 3)

  .button_form.success
    line-height: calc(4.167vw * #{$gain-m} * 3)

  .privacy
    .container-inner
      padding-top: calc(12px / #{$lose-s})
      padding-bottom: calc(115px / #{$lose-s})

  .privacy__title
    margin-top: calc(80px / #{$lose-s})
    margin-bottom: calc(57px / #{$lose-s})
    padding-left: calc(150px / #{$lose-s})
    padding-right: calc(150px / #{$lose-s})

  .privacy__subtitle
    margin-bottom: calc(40px / #{$lose-s})

  .privacy__text
    p:first-child
      margin-bottom: calc(40px / #{$lose-s})
      font-size: calc(22px / #{$lose-s})

  @keyframes slide-left-infinite
    0%
      transform: translateX(0px)
    100%
      transform: translateX(calc(0.521vw * #{$gain-s}))

  .slick-prev,
  .slick-next
    width: calc(77px / #{$lose-s})
    height: calc(77px / #{$lose-s})
    &::before,
    &::after
      width: calc(15px / #{$lose-s})
      height: calc(2px / #{$lose-s})
      margin-left: calc(-7px / #{$lose-s})

  .slick-prev
    margin-top: calc(-77px / #{$lose-s})
    &::before
      margin-top: calc(4px / #{$lose-s})
    &::after
      margin-top: calc(-9px / #{$lose-s} + 4px / #{$lose-s})

  .slick-next
    margin-bottom: calc(77px / #{$lose-s})
    &::before
      margin-top: calc(-9px / #{$lose-s} + 4px / #{$lose-s})
    &::after
      margin-top: calc(4px / #{$lose-s})

  .slick-dots
    bottom: calc(28px / #{$lose-s})
    li
      margin-right: calc(14px / #{$lose-s})
      button
        width: calc(76px / #{$lose-s})
        height: calc(7px / #{$lose-s})

  .product-slider__sound
    width: calc(60px / #{$lose-s})
    height: calc(55px / #{$lose-s})
    padding: calc(15px / #{$lose-s})
    &::before
      font-size: calc(25px / #{$lose-s})

@media(max-width: 767px)
  .container-inner
    // width: calc(60.469vw * #{$gain-xs})
    border-bottom: calc(4px / #{$lose-xs}) solid $color-grey

  .title
    font-size: calc(50px / #{$lose-xs})

  .subtitle,
  .subtitle p
    font-size: calc(22px / #{$lose-xs})

  .text,
  .text p,
  p
    font-size: calc(22px / #{$lose-xs})

  .privacy
    .container-inner
      padding-top: calc(12px / #{$lose-xs})
      padding-bottom: calc(115px / #{$lose-xs})

  .privacy__title
    margin-top: calc(80px / #{$lose-xs})
    margin-bottom: calc(57px / #{$lose-xs})
    padding-left: calc(150px / #{$lose-xs})
    padding-right: calc(150px / #{$lose-xs})

  .privacy__subtitle
    margin-bottom: calc(40px / #{$lose-xs})

  .privasy__text
    p:first-child
      margin-bottom: calc(40px / #{$lose-xs})
      font-size: calc(22px / #{$lose-xs})

  @keyframes slide-left-infinite
    0%
      transform: translateX(0px)
    100%
      transform: translateX(calc(0.521vw * #{$gain-xs}))

  .slick-prev,
  .slick-next
    width: calc(77px / #{$lose-xs})
    height: calc(77px / #{$lose-xs})
    &::before,
    &::after
      width: calc(15px / #{$lose-xs})
      height: calc(2px / #{$lose-xs})
      margin-left: calc(-7px / #{$lose-xs})

  .slick-prev
    margin-top: calc(-77px / #{$lose-xs})
    &::before
      margin-top: calc(4px / #{$lose-xs})
    &::after
      margin-top: calc(-9px / #{$lose-xs} + 4px / #{$lose-xs})

  .slick-next
    margin-bottom: calc(77px / #{$lose-xs})
    &::before
      margin-top: calc(-9px / #{$lose-xs} + 4px / #{$lose-xs})
    &::after
      margin-top: calc(4px / #{$lose-xs})

  .slick-dots
    bottom: calc(28px / #{$lose-xs})
    li
      margin-right: calc(14px / #{$lose-xs})
      button
        width: calc(76px / #{$lose-xs})
        height: calc(7px / #{$lose-xs})

  .product-slider__sound
    width: calc(60px / #{$lose-xs})
    height: calc(55px / #{$lose-xs})
    padding: calc(15px / #{$lose-xs})
    &::before
      font-size: calc(25px / #{$lose-xs})

@media(max-width: 575px)
  .container-inner
    // width: calc(60.469vw * #{$gain-xs})
    border-bottom: calc(0.208vw * #{$gain-xs}) solid $color-grey

  .title
    font-size: calc(2.604vw * #{$gain-xs})

  .subtitle,
  .subtitle p
    font-size: calc(1.146vw * #{$gain-xs} * 1.2)
    text-align: justify

  .text,
  .text p,
  p
    font-size: calc(1.146vw * #{$gain-xs} * 1.2)
    text-align: justify

  .button_form
    width: calc(18.750vw * #{$gain-xs})
    height: calc(4.167vw * #{$gain-xs})
    font-size: calc(0.938vw * #{$gain-xs})
    line-height: calc(4.167vw * #{$gain-xs})

  .button_form-page
    width: 100%
    height: calc(4.167vw * #{$gain-xs} * 1.2)
    font-size: calc(0.938vw * #{$gain-xs} * 1.3)
    line-height: calc(4.167vw * #{$gain-xs} * 1.2)

  .button_submit::before
    top: calc(-4.167vw * #{$gain-xs})

  .button_submit.success
    line-height: calc(4.167vw * #{$gain-xs} * 3)

  .privacy
    .container-main
      padding: 0
    .container-inner
      padding-top: calc(0.625vw * #{$gain-xs} / 1.5)
      padding-bottom: calc(5.990vw * #{$gain-xs} / 3)
      padding-left: 15px
      padding-right: 15px

  .privacy__title
    margin-top: calc(4.167vw * #{$gain-xs} / 1.5)
    margin-bottom: calc(2.969vw * #{$gain-xs} / 1.5)
    padding-left: 0
    padding-right: 0

  .privacy__subtitle
    margin-bottom: calc(2.083vw * #{$gain-xs} / 1.5)

  .privacy__text
    p:first-child
      margin-bottom: calc(2.083vw * #{$gain-xs} / 1.5)
      font-size: calc(1.146vw * #{$gain-xs} * 1.2)
      text-align: justify

  .slick-prev,
  .slick-next
    width: calc(4.010vw * #{$gain-xs})
    height: calc(4.010vw * #{$gain-xs})
    &::before,
    &::after
      width: calc(0.781vw * #{$gain-xs})
      height: calc(0.104vw * #{$gain-xs})
      margin-left: calc(-0.365vw * #{$gain-xs})

  .slick-prev
    margin-top: calc(-4.010vw * #{$gain-xs})
    &::before
      margin-top: calc(0.208vw * #{$gain-xs})
    &::after
      margin-top: calc(-0.469vw * #{$gain-xs} + 0.208vw * #{$gain-xs})

  .slick-next
    margin-bottom: calc(4.010vw * #{$gain-xs})
    &::before
      margin-top: calc(-0.469vw * #{$gain-xs} + 0.208vw * #{$gain-xs})
    &::after
      margin-top: calc(0.208vw * #{$gain-xs})

  .slick-dots
    bottom: calc(1.458vw * #{$gain-xs})
    li
      margin-right: calc(0.729vw * #{$gain-xs})
      button
        width: calc(3.958vw * #{$gain-xs})
        height: calc(0.365vw * #{$gain-xs})

  .product-slider__sound
    width: calc(3.125vw * #{$gain-xs} * 1.3)
    height: calc(2.865vw * #{$gain-xs} * 1.5)
    padding: calc(0.781vw * #{$gain-xs})
    &::before
      font-size: calc(1.302vw * #{$gain-xs} * 1.5)
</style>
