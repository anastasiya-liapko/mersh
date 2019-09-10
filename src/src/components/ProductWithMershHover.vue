<template>
  <div
    @mouseenter="hoverMershAddDelay"
    @mouseleave="hoverMershRemoveDelay">
    <div class="product__img-wrapper">
      <img :src="element.img"
        class="product__img"
        alt="">
    </div>
    <div class="product__name d-flex justify-content-center align-items-center">
      <span class="hover-mersh d-flex flex-wrap justify-content-center"
        :data-length="element.name.split('').length"
        >
        <span
          class="hover-mersh__word d-flex"
          v-for="(word, wordIndex) in element.name.split(' ')"
          v-bind:key="word + '-' + wordIndex">
            <span
              class="hover-mersh__letter"
              v-for="(letter, letterIndex) in word.split('')"
              v-bind:key="letter + '-' + letterIndex">
              {{ letter }}
            </span>
            &nbsp;
        </span>
      </span>
    </div>
    <div class="product__hover d-flex flex-column justify-content-end align-items-center">
      <span class="product__hover-name hover-mersh d-flex flex-wrap justify-content-center"
        :data-length="element.name.split('').length"
        >
        <span
          class="hover-mersh__word d-flex"
          v-for="(word, wordIndex) in element.name.split(' ')"
          v-bind:key="word + '-' + wordIndex">
            <span
              class="hover-mersh__letter"
              v-for="(letter, letterIndex) in word.split('')"
              v-bind:key="letter + '-' + letterIndex">
              {{ letter }}
            </span>
            &nbsp;
        </span>
      </span>
      <span class="product__hover-text hover-mersh d-flex flex-nowrap"
        :data-length="hoverText.split('').length"
        >
        <span
          class="hover-mersh__word d-flex"
          v-for="(word, wordIndex) in hoverText.split(' ')"
          v-bind:key="word + '-' + wordIndex">
            <span
              class="hover-mersh__letter"
              v-for="(letter, letterIndex) in word.split('')"
              v-bind:key="letter + '-' + letterIndex">
              {{ letter }}
            </span>
            &nbsp;
        </span>
      </span>
      <span
        class="product__hover-arrow hover-mersh__letter hover-mersh__arrow-right icon-right-arrow">
      </span>
    </div>
  </div>
</template>

<script>
import { hoverMershToggleDelay } from '@/mixins'
export default {
  props: ['element', 'hoverText'],
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
  overflow: hidden
  &:nth-child(2n)
    margin-right: 0
  .product__name
    display: none !important
  &:hover
    & .product__img
      transform: scale(1.4)
    & .hover-mersh__letter
      transform: perspective(1000px) rotate3d(0,1,0,360deg)
    & .product__name
      & .hover-mersh__letter
        color: transparent
    & .product__hover
      & .hover-mersh__letter
        color: $color-white
    & .hover-mersh__arrow-right
      opacity: 1

.product_type_category
  .product__name
    display: flex !important

.product__img-wrapper
  width: 100%
  height: 100%

.product__img
  transform: scale(1.1)
  transition: transform 0.3s linear

.product__name
  position: absolute
  top: 0
  left: 0
  width: 100%
  height: 100%
  font-family: $font-cormorant-sc
  // font-size: 30px
  font-size: 1.563vw
  line-height: 1
  font-weight: 700
  // letter-spacing: 17.37px
  text-transform: uppercase
  color: $color-white
  .hover-mersh
    // margin-left: -8.5px
    margin-left: -0.443vw
  .hover-mersh__letter
    // padding: 0 8.5px
    padding: 0 0.443vw

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
  color: transparent

.product__hover-name
  // margin-bottom: 32px
  margin-bottom: 1.667vw
  // letter-spacing: 11.58px
  .hover-mersh
    // margin-left: calc(-8.5px / 1.5)
    margin-left: calc(-0.443vw / 1.5)
  .hover-mersh__letter
    // padding: 0 calc(8.5px / 1.5)
    padding: 0 calc(0.443vw / 1.5)

.product__hover-text
  // margin-bottom: 22px
  margin-bottom: 1.146vw

.hover-mersh__arrow-right
  opacity: 0

@media(max-width: 1199px)
  .product
    width: calc(560px / #{$lose-m})
    height: calc(560px / #{$lose-m})
    margin-right: calc(36px / #{$lose-m})
    margin-bottom: calc(36px / #{$lose-m})

  .product__name
    font-size: calc(30px / #{$lose-m})
    .hover-mersh
      margin-left: calc(-8.5px / #{$lose-m})
    .hover-mersh__letter
      padding: 0 calc(8.5px / #{$lose-m})

  .product__hover
    padding-bottom: calc(42px / #{$lose-m})
    font-size: calc(20px / #{$lose-m})

  .product__hover-name
    margin-bottom: calc(32px
    .hover-mersh
      margin-left: calc(-8.5px / #{$lose-m} / 1.5)
    .hover-mersh__letter
      padding: 0 calc(8.5px / #{$lose-m} / 1.5)

  .product__hover-text
    margin-bottom: calc(22px / #{$lose-m})

@media(max-width: 991px)
  .product
    width: calc(560px / #{$lose-s})
    height: calc(560px / #{$lose-s})
    margin-right: calc(36px / #{$lose-s})
    margin-bottom: calc(36px / #{$lose-s})

  .product__name
    font-size: calc(30px / #{$lose-s})
    .hover-mersh
      margin-left: calc(-8.5px / #{$lose-s})
    .hover-mersh__letter
      padding: 0 calc(8.5px / #{$lose-s})

  .product__hover
    padding-bottom: calc(42px / #{$lose-s})
    font-size: calc(20px / #{$lose-s})

  .product__hover-name
    margin-bottom: calc(32px / #{$lose-s})
    .hover-mersh
      margin-left: calc(-8.5px / #{$lose-s} / 1.5)
    .hover-mersh__letter
      padding: 0 calc(8.5px / #{$lose-s} / 1.5)

  .product__hover-text
    margin-bottom: calc(22px / #{$lose-s})

@media(max-width: 767px)
  .product
    width: calc(560px / #{$lose-xs})
    height: calc(560px / #{$lose-xs})
    margin-right: calc(36px / #{$lose-xs})
    margin-bottom: calc(36px / #{$lose-xs})

  .product__name
    font-size: calc(30px / #{$lose-xs})
    .hover-mersh
      margin-left: calc(-8.5px / #{$lose-xs})
    .hover-mersh__letter
      padding: 0 calc(8.5px / #{$lose-xs})

  .product__hover
    padding-bottom: calc(42px / #{$lose-xs})
    font-size: calc(20px / #{$lose-xs})

  .product__hover-name
    margin-bottom: calc(32px / #{$lose-xs})
    .hover-mersh
      margin-left: calc(-8.5px / #{$lose-xs} / 1.5)
    .hover-mersh__letter
      padding: 0 calc(8.5px / #{$lose-xs} / 1.5)

  .product__hover-text
    margin-bottom: calc(22px / #{$lose-xs})

@media(max-width: 575px)
  .product
    width: calc(29.167vw * #{$gain-m})
    height: calc(29.167vw * #{$gain-m})
    margin-right: calc(1.875vw * #{$gain-m})
    margin-bottom: calc(1.875vw * #{$gain-m})

  .product__name
    font-size: calc(1.563vw * #{$gain-m})
    .hover-mersh
      margin-left: calc(-0.443vw * #{$gain-m})
    .hover-mersh__letter
      padding: 0 calc(0.443vw * #{$gain-m})

  .product__hover
    padding-bottom: calc(2.188vw * #{$gain-m})
    font-size: calc(1.042vw * #{$gain-m})

  .product__hover-name
    margin-bottom: calc(1.667vw * #{$gain-m})
    .hover-mersh
      margin-left: calc(-0.443vw * #{$gain-m} / 1.5)
    .hover-mersh__letter
      padding: 0 calc(0.443vw * #{$gain-m} / 1.5)

  .product__hover-text
    margin-bottom: calc(1.146vw * #{$gain-m})
</style>
