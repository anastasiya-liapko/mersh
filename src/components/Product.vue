<template>
  <div
    @mouseenter="hoverMershAddDelay"
    @mouseleave="hoverMershRemoveDelay">
    <div class="product__img-wrapper">
      <img :src="element.img ? element.img : productImage"
        class="product__img"
        alt="">
    </div>
    <div class="product__name d-flex justify-content-center align-items-center text-center">
      {{ element.name }}
    </div>
    <div class="product__hover d-flex flex-column justify-content-end align-items-center">
      <span class="product__hover-name hover-mersh d-flex flex-wrap justify-content-center text-center">
        {{ element.name }}
      </span>
      <span class="product__hover-text hover-mersh d-flex flex-nowrap">
        {{ hoverText }}
      </span>
      <span
        class="product__hover-arrow hover-mersh__letter hover-mersh__arrow-right icon-right-arrow">
      </span>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { hoverMershToggleDelay } from '@/mixins'

export default {
  data () {
    return {
      productImage: '/img/product-placeholder.png',
      domen: process.env.VUE_APP_DOMEN
    }
  },
  props: ['element', 'hoverText'],
  created () {
    this.fetch()
  },
  methods: {
    fetch () {
      var context = this

      axios.get(context.domen + '/api/product/' + context.element.id)
        .then(res => {
          // console.log(res)
          context.productImage = res.data.images[0].content
        })
        .catch(error => console.log(error))
    }
  },
  mixins: [hoverMershToggleDelay]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.product
  position: relative
  // width: 560px
  // height: 560px
  // margin-right: 36px
  // margin-bottom: 36px
  width: 29.167vw
  height: 29.167vw
  margin-right: 1.875vw
  margin-bottom: 1.875vw
  background-color: $color-brown
  overflow: hidden
  &>div
    height: 100%
  &:nth-child(2n)
    margin-right: 0
  .product__name
    display: none !important
  &:hover
    & .product__img
      transform: scale(1.4)
    .product__name
      opacity: 0
      filter: blur(12px)
    .product__hover
      opacity: 1
      filter: blur(0px)

.product_type_category
  .product__name
    display: flex !important

.product__img-wrapper
  width: 100%
  height: 100%

.product__img
  width: 100%
  height: 100%
  object-fit: cover
  transform: scale(1.01)
  transition: transform 0.3s linear

.product__name
  position: absolute
  top: 0
  left: 0
  width: 100%
  height: 100%
  // padding-left: 17.37px
  padding-left: 0.905vw
  font-family: $font-cormorant-sc
  // font-size: 30px
  font-size: 1.563vw
  line-height: 1
  font-weight: 700
  // letter-spacing: 17.37px
  letter-spacing: 0.905vw
  text-transform: uppercase
  color: $color-white
  opacity: 1
  filter: blur(0px)
  transition: opacity 0.5s, filter 0.5s

.product__hover
  position: absolute
  top: 0
  left: 0
  width: 100%
  height: 100%
  // padding-bottom: 42px
  padding-bottom: 2.188vw
  font-family: $font-cormorant-sc
  // font-size: 20px
  font-size: 1.042vw
  line-height: 1
  font-weight: 700
  text-transform: uppercase
  color: $color-white
  opacity: 0
  filter: blur(12px)
  transition: opacity 0.5s, filter 0.5s

.product__hover-name
  // margin-bottom: 32px
  margin-bottom: 1.667vw
  // padding-left: 11.58px
  padding-left: 0.603vw
  // letter-spacing: 11.58px
  letter-spacing: 0.603vw
  // letter-spacing: 0.8em
  // transition: letter-spacing 0.5s

.product__hover-text
  // margin-bottom: 22px
  margin-bottom: 1.146vw
  // letter-spacing: -0.1em
  // transition: letter-spacing 0.5s

@media(max-width: 1199px)
  .product
    width: calc(560px / #{$lose-m})
    height: calc(560px / #{$lose-m})
    margin-right: calc(36px / #{$lose-m})
    margin-bottom: calc(36px / #{$lose-m})

  .product__name
    padding-left: calc(17.37px / #{$lose-m})
    font-size: calc(30px / #{$lose-m})
    letter-spacing: calc(17.37px / #{$lose-m})

  .product__hover
    padding-bottom: calc(42px / #{$lose-m})
    font-size: calc(20px / #{$lose-m})

  .product__hover-name
    margin-bottom: calc(32px

  .product__hover-text
    margin-bottom: calc(22px / #{$lose-m})

@media(max-width: 991px)
  .product
    width: calc(560px / #{$lose-s})
    height: calc(560px / #{$lose-s})
    margin-right: calc(36px / #{$lose-s})
    margin-bottom: calc(36px / #{$lose-s})

  .product__name
    padding-left: calc(17.37px / #{$lose-s})
    font-size: calc(30px / #{$lose-s})
    letter-spacing: calc(17.37px / #{$lose-s})

  .product__hover
    padding-bottom: calc(42px / #{$lose-s})
    font-size: calc(20px / #{$lose-s})

  .product__hover-name
    margin-bottom: calc(32px / #{$lose-s})

  .product__hover-text
    margin-bottom: calc(22px / #{$lose-s})

@media(max-width: 767px)
  .product
    width: calc(560px / #{$lose-xs})
    height: calc(560px / #{$lose-xs})
    margin-right: calc(36px / #{$lose-xs})
    margin-bottom: calc(36px / #{$lose-xs})

  .product__name
    padding-left: calc(17.37px / #{$lose-xs})
    font-size: calc(30px / #{$lose-xs})
    letter-spacing: calc(17.37px / #{$lose-xs})

  .product__hover
    padding-bottom: calc(42px / #{$lose-xs})
    font-size: calc(20px / #{$lose-xs})

  .product__hover-name
    margin-bottom: calc(32px / #{$lose-xs})

  .product__hover-text
    margin-bottom: calc(22px / #{$lose-xs})

@media(max-width: 575px)
  .product
    width: calc(29.167vw * #{$gain-m})
    height: calc(29.167vw * #{$gain-m})
    margin-right: calc(1.875vw * #{$gain-m})
    margin-bottom: calc(1.875vw * #{$gain-m})

  .product__name
    padding-left: calc(0.905vw * #{$gain-m})
    font-size: calc(1.563vw * #{$gain-m})
    letter-spacing: calc(0.905vw * #{$gain-m})

  .product__hover
    padding-bottom: calc(2.188vw * #{$gain-m})
    font-size: calc(1.042vw * #{$gain-m})

  .product__hover-name
    margin-bottom: calc(1.667vw * #{$gain-m})

  .product__hover-text
    margin-bottom: calc(1.146vw * #{$gain-m})
</style>
