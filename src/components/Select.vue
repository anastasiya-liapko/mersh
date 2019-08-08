<template>
  <div
    class="select"
    :class="{isOpened: computedShow}">
    <li
      :id="id"
      @click="toggleMenu()"
      class="select__toggle"

      v-if="selected !== undefined && selected !== ''">
      <span class="select__text">{{ computedOption }}</span>
      <span class="select__caret icon-arrow-order"
        :class="{open: computedShow}"></span>
    </li>

    <li
      :id="id"
      @click="toggleMenu()"
      class="select__toggle select__toggle_type_placeholder"

      v-if="selected === undefined || selected === ''">
      <span class="select__text">{{ placeholder }}</span>
      <span class="select__caret icon-arrow-order"
        :class="{open: computedShow}"></span>
    </li>

    <transition name="slide-bottom" appear>
      <ul
        class="select__menu"
        v-show="computedShow"
        :class="{opened: computedShow}">
        <li class="select__menu-item">
          <a class="select__menu-link"
            href="javascript:void(0)"
            @click="updateOption(name, '')">
          </a>
        </li>
        <li class="select__menu-item"
          v-for="option in options"
          v-bind:key="option.id">
          <a class="select__menu-link"
            href="javascript:void(0)"
            @click="updateOption(name, option)"
            :class="{isSelected: option.value === selectedOption}">
            <span class="select__text">{{ option.value }}</span>
          </a>
        </li>
      </ul>
    </transition>
  </div>
</template>

<script>
import { hideMixin } from '@/mixins'
import { mapActions } from 'vuex'

export default {
  data () {
    return {
      showMenu: false,
      selectorName: '',
      selectedOption: ''
    }
  },
  props: {
    show: [Boolean],
    id: [String],
    name: [String],
    options: {
      type: [Array, Object]
    },
    selected: [String],
    placeholder: [String]
  },
  computed: {
    computedOption () {
      return this.selectedOption = this.selected
    },
    computedShow () {
      return this.showMenu = this.show
    }
  },
  methods: {
    ...mapActions([
      'toggleSelect',
      'hideSelect'
    ]),
    updateOption: function (name, option) {
      this.selectorName = name
      this.selectedOption = option
      this.showMenu = false
      this.$emit('updateOption', [this.selectorName, this.selectedOption])
    },
    toggleMenu: function () {
      var value = {
        name: this.name,
        show: this.computedShow
      }
      this.toggleSelect(value)
    },
    hide (e) {
      var self = this
      if (e.target.closest('.select') === null || e.target.closest('.select__menu')) {
        self.hideSelect(self.name)
      }
    }
  },
  mixins: [hideMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.select_type_register
  // width: 378px
  width: 19.688vw
  .select__toggle
    // height: 68px
    // padding-top: 25px
    // padding-bottom: 25px
    // padding-right: 16px
    height: 3.542vw
    padding-top: 1.302vw
    padding-bottom: 1.302vw
    padding-right: 0.833vw
    font-family: $font-montserrat
    // font-size: 18px
    font-size: 0.938vw
    font-weight: 400
    line-height: 1
    color: $color-black
    border: 0
    border-bottom: 1px solid $color-text
    border-radius: 0
  .select__toggle_type_placeholder
    color: rgba(0, 0, 0, 0.7)
  .select__menu
    // top: calc(68px - 1px)
    top: calc(3.542vw - 1px)
    left: 0
    color: $color-black
    // background-color: $color-white
    background-image: radial-gradient(circle at 73% 11%, #ffffff, #f1e5dd)
    border: 1px solid $color-text
  .select__menu-item
    border-bottom: 1px solid $color-text
    &:last-child
      border-bottom: 0
  .select__menu-link
    display: flex
    // height: 52px
    // padding-top: calc(25px / 1.5)
    // padding-bottom: calc(25px / 1.5)
    // padding-right: 16px
    // padding-left: 16px
    height: 2.708vw
    padding-top: calc(1.302vw / 1.5)
    padding-bottom: calc(1.302vw / 1.5)
    padding-right: 0.833vw
    padding-left: 0.833vw
    font-family: $font-montserrat
    // font-size: 18px
    font-size: 0.938vw
    font-weight: 400
    line-height: 1
    color: $color-black
    &:hover
      color: $color-white
      background-color: $color-brown
      text-decoration: none
  .select__caret
    &::before
      // font-size: 7px
      font-size: 0.365vw
  .isSelected
    color: $color-white
    background-color: $color-brown

.select_type_cart
  // width: 152px
  width: 7.917vw
  .select__toggle
    // height: 38px
    // padding-top: 10px
    // padding-bottom: 10px
    // padding-right: 11px
    // padding-left: 17px
    height: 1.979vw
    padding-top: 0.521vw
    padding-bottom: 0.521vw
    padding-right: 0.573vw
    padding-left: 0.885vw
    font-family: $font-montserrat
    // font-size: 14px
    font-size: 0.729vw
    font-weight: 400
    line-height: 1
    color: $color-brown
    border: 1px solid $color-text
    border-radius: 0
  .select__toggle_type_placeholder
    color: rgba(55, 16, 5, 0.7)
  .select__menu
    // top: 38px
    top: 1.979vw
    left: 0
    color: $color-brown
    background-color: $color-lightgrey
    border: 1px solid $color-text
  .select__menu-item
    border-bottom: 1px solid $color-text
    &:last-child
      border-bottom: 0
  .select__menu-link
    display: flex
    // height: 38px
    // padding-top: 10px
    // padding-bottom: 10px
    // padding-right: 11px
    // padding-left: 17px
    height: 1.979vw
    padding-top: 0.521vw
    padding-bottom: 0.521vw
    padding-right: 0.573vw
    padding-left: 0.885vw
    font-family: $font-montserrat
    // font-size: 14px
    font-size: 0.729vw
    font-weight: 400
    line-height: 1
    color: $color-brown
    &:hover
      color: $color-white
      background-color: $color-brown
      text-decoration: none
  .select__caret
    &::before
      // font-size: 5px
      font-size: 0.260vw
  .isSelected
    color: $color-white
    background-color: $color-brown

.select_type_product
  width: 100%
  .select__toggle
    // height: 58px
    // padding-top: 20px
    // padding-bottom: 20px
    // padding-right: 28px
    // padding-left: 22px
    height: 3.021vw
    padding-top: 1.042vw
    padding-bottom: 1.042vw
    padding-right: 1.458vw
    padding-left: 1.146vw
    font-family: $font-montserrat
    // font-size: 14px
    font-size: 0.729vw
    font-weight: 400
    line-height: 1
    color: $color-brown
    background-color: transparent
    // border: 1px solid $color-text
    border: 0.052vw solid $color-text
    border-radius: 0
  .select__toggle_type_placeholder
    color: rgba(55, 16, 5, 0.7)
  .select__menu
    // top: 58px
    top: 3.021vw
    left: 0
    color: $color-brown
    background-image: radial-gradient(circle at 73% 11%, #ffffff, #f1e5dd)
    // border: 1px solid $color-text
    border: 0.052vw solid $color-text
  .select__menu-item
    // border-bottom: 1px solid $color-text
    border-bottom: 0.052vw solid $color-text
    &:last-child
      border-bottom: 0
  .select__menu-link
    display: flex
    // height: 58px
    // padding-top: 20px
    // padding-bottom: 20px
    // padding-right: 28px
    // padding-left: 22px
    height: 3.021vw
    padding-top: 1.042vw
    padding-bottom: 1.042vw
    padding-right: 1.458vw
    padding-left: 1.146vw
    font-family: $font-montserrat
    // font-size: 14px
    font-size: 0.729vw
    font-weight: 400
    line-height: 1
    color: $color-brown
    &:hover
      color: $color-white
      background-color: $color-brown
      text-decoration: none
  .select__caret
    // width: 16px
    // height: 8px
    width: 0.833vw
    height: 0.417vw
    &::before
      // font-size: 8px
      font-size: 0.417vw
      color: $color-text
  .isSelected
    color: $color-white
    background-color: $color-brown

//common styles
.select
  position: relative

.select__toggle
  z-index: 10
  position: relative
  display: flex
  align-items: center
  transition: border 0.3s linear
  &:hover
    cursor: pointer

.select__text
  margin-right: 0.573vw
  white-space: nowrap
  overflow: hidden

.select__caret
  display: flex
  align-items: center
  justify-content: center
  margin-left: auto
  transform-origin: center
  transition: transform 0.5s
  &.open
    transform: rotateX(180deg)

.select__menu
  z-index: 15
  position: absolute
  width: 100%
  height: auto
  padding: 0
  // box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175)
  box-shadow: 0 0.313vw 0.625vw rgba(0, 0, 0, 0.175)
  list-style: none
  background-clip: padding-box
  overflow: hidden

.select__menu-item
  position: relative
  width: 100%
  margin: 0
  overflow: hidden

li
  list-style: none

@media(max-width: 1199px)
  .select_type_register
    width: calc(378px / #{$lose-m})
    .select__toggle
      height: calc(68px / #{$lose-m})
      padding-top: calc(25px / #{$lose-m})
      padding-bottom: calc(25px / #{$lose-m})
      padding-right: calc(16px / #{$lose-m})
      font-size: calc(18px / #{$lose-m})
    .select__menu
      top: calc(68px / #{$lose-m} - 1px)
    .select__menu-link
      height: calc(52px / #{$lose-m})
      padding-top: calc(25px / #{$lose-m} / 1.5)
      padding-bottom: calc(25px / #{$lose-m} / 1.5)
      padding-right: calc(16px / #{$lose-m})
      padding-left: calc(16px / #{$lose-m})
      font-size: calc(18px / #{$lose-m})
    .select__caret
      &::before
        font-size: calc(7px / #{$lose-m})

  .select_type_cart
    width: calc(152px / #{$lose-m})
    .select__toggle
      height: calc(38px / #{$lose-m})
      padding-top: calc(10px / #{$lose-m})
      padding-bottom: calc(10px / #{$lose-m})
      padding-right: calc(11px / #{$lose-m})
      padding-left: calc(17px / #{$lose-m})
      font-size: calc(14px / #{$lose-m})
    .select__menu
      top: calc(38px / #{$lose-m})
    .select__menu-link
      height: calc(38px / #{$lose-m})
      padding-top: calc(10px / #{$lose-m})
      padding-bottom: calc(10px / #{$lose-m})
      padding-right: calc(11px / #{$lose-m})
      padding-left: calc(17px / #{$lose-m})
      font-size: calc(14px / #{$lose-m})
    .select__caret
      &::before
        font-size: calc(5px / #{$lose-m})

  .select_type_product
    .select__toggle
      height: calc(58px / #{$lose-m})
      padding-top: calc(20px / #{$lose-m})
      padding-bottom: calc(20px / #{$lose-m})
      padding-right: calc(28px / #{$lose-m})
      padding-left: calc(22px / #{$lose-m})
      font-size: calc(14px / #{$lose-m})
      border: calc(1px / #{$lose-m}) solid $color-text
    .select__menu
      top: calc(58px / #{$lose-m})
      border: calc(1px / #{$lose-m}) solid $color-text
    .select__menu-item
      border-bottom: calc(1px / #{$lose-m}) solid $color-text
    .select__menu-link
      height: calc(58px / #{$lose-m})
      padding-top: calc(20px / #{$lose-m})
      padding-bottom: calc(20px / #{$lose-m})
      padding-right: calc(28px / #{$lose-m})
      padding-left: calc(22px / #{$lose-m})
      font-size: calc(14px / #{$lose-m})
    .select__caret
      width: calc(16px / #{$lose-m})
      height: calc(8px / #{$lose-m})
      &::before
        font-size: calc(8px / #{$lose-m})

  // common styles
  .select__text
    margin-right: calc(11px / #{$lose-m})

  .select__menu
    box-shadow: 0 calc(6px / #{$lose-m}) calc(12px / #{$lose-m}) rgba(0, 0, 0, 0.175)

@media(max-width: 991px)
  .select_type_register
    width: calc(378px / #{$lose-s})
    .select__toggle
      height: calc(68px / #{$lose-s})
      padding-top: calc(25px / #{$lose-s})
      padding-bottom: calc(25px / #{$lose-s})
      padding-right: calc(16px / #{$lose-s})
      font-size: calc(18px / #{$lose-s})
    .select__menu
      top: calc(68px / #{$lose-s} - 1px)
    .select__menu-link
      height: calc(52px / #{$lose-s})
      padding-top: calc(25px / #{$lose-s} / 1.5)
      padding-bottom: calc(25px / #{$lose-s} / 1.5)
      padding-right: calc(16px / #{$lose-s})
      padding-left: calc(16px / #{$lose-s})
      font-size: calc(18px / #{$lose-s})
    .select__caret
      &::before
        font-size: calc(7px / #{$lose-s})

  .select_type_cart
    width: calc(152px / #{$lose-s})
    .select__toggle
      height: calc(38px / #{$lose-s})
      padding-top: calc(10px / #{$lose-s})
      padding-bottom: calc(10px / #{$lose-s})
      padding-right: calc(11px / #{$lose-s})
      padding-left: calc(17px / #{$lose-s})
      font-size: calc(14px / #{$lose-s})
    .select__menu
      top: calc(38px / #{$lose-s})
    .select__menu-link
      height: calc(38px / #{$lose-s})
      padding-top: calc(10px / #{$lose-s})
      padding-bottom: calc(10px / #{$lose-s})
      padding-right: calc(11px / #{$lose-s})
      padding-left: calc(17px / #{$lose-s})
      font-size: calc(14px / #{$lose-s})
    .select__caret
      &::before
        font-size: calc(5px / #{$lose-s})

  .select_type_product
    .select__toggle
      height: calc(58px / #{$lose-s})
      padding-top: calc(20px / #{$lose-s})
      padding-bottom: calc(20px / #{$lose-s})
      padding-right: calc(28px / #{$lose-s})
      padding-left: calc(22px / #{$lose-s})
      font-size: calc(14px / #{$lose-s})
      border: calc(1px / #{$lose-s}) solid $color-text
    .select__menu
      top: calc(58px / #{$lose-s})
      border: calc(1px / #{$lose-s}) solid $color-text
    .select__menu-item
      border-bottom: calc(1px / #{$lose-s}) solid $color-text
    .select__menu-link
      height: calc(58px / #{$lose-s})
      padding-top: calc(20px / #{$lose-s})
      padding-bottom: calc(20px / #{$lose-s})
      padding-right: calc(28px / #{$lose-s})
      padding-left: calc(22px / #{$lose-s})
      font-size: calc(14px / #{$lose-s})
    .select__caret
      width: calc(16px / #{$lose-s})
      height: calc(8px / #{$lose-s})
      &::before
        font-size: calc(8px / #{$lose-s})

  // common styles
  .select__text
    margin-right: calc(11px / #{$lose-s})

  .select__menu
    box-shadow: 0 calc(6px / #{$lose-s}) calc(12px / #{$lose-s}) rgba(0, 0, 0, 0.175)

@media(max-width: 767px)
  .select_type_product
    .select__toggle
      height: calc(58px / #{$lose-xs})
      padding-top: calc(20px / #{$lose-xs})
      padding-bottom: calc(20px / #{$lose-xs})
      padding-right: calc(28px / #{$lose-xs})
      padding-left: calc(22px / #{$lose-xs})
      font-size: calc(14px / #{$lose-xs})
      border: calc(1px / #{$lose-xs}) solid $color-text
    .select__menu
      top: calc(58px / #{$lose-xs})
      border: calc(1px / #{$lose-xs}) solid $color-text
    .select__menu-item
      border-bottom: calc(1px / #{$lose-xs}) solid $color-text
    .select__menu-link
      height: calc(58px / #{$lose-xs})
      padding-top: calc(20px / #{$lose-xs})
      padding-bottom: calc(20px / #{$lose-xs})
      padding-right: calc(28px / #{$lose-xs})
      padding-left: calc(22px / #{$lose-xs})
      font-size: calc(14px / #{$lose-xs})
    .select__caret
      width: calc(16px / #{$lose-xs})
      height: calc(8px / #{$lose-xs})
      &::before
        font-size: calc(8px / #{$lose-xs})

@media(max-width: 575px)
  .select_type_register
    // width: calc(19.688vw * #{$gain-xs} * 1.3)
    width: 100%
    .select__toggle
      height: calc(3.542vw * #{$gain-xs})
      padding-top: calc(1.302vw * #{$gain-xs})
      padding-bottom: calc(1.302vw * #{$gain-xs})
      padding-right: calc(0.833vw * #{$gain-xs})
      font-size: calc(0.938vw * #{$gain-xs} * 1.4)
    .select__menu
      top: calc(3.542vw * #{$gain-xs} - 1px)
    .select__menu-link
      height: calc(3.542vw * #{$gain-xs})
      padding-top: calc(1.302vw * #{$gain-xs})
      padding-bottom: calc(1.302vw * #{$gain-xs})
      padding-right: calc(0.833vw * #{$gain-xs})
      padding-left: calc(0.833vw * #{$gain-xs})
      font-size: calc(0.938vw * #{$gain-xs} * 1.4)
    .select__caret
      &::before
        font-size: calc(0.365vw * #{$gain-xs} * 1.4)

  .select_type_cart
    // width: calc(7.917vw * #{$gain-xs})
    width: 100%
    .select__toggle
      height: calc(1.979vw * #{$gain-xs} * 1.7)
      padding-top: calc(0.521vw * #{$gain-xs} * 1.7)
      padding-bottom: calc(0.521vw * #{$gain-xs} * 1.7)
      padding-right: calc(0.573vw * #{$gain-xs} * 1.7)
      padding-left: calc(0.885vw * #{$gain-xs} * 1.7)
      font-size: calc(0.729vw * #{$gain-xs} * 1.7)
    .select__menu
      top: calc(1.979vw * #{$gain-xs} * 1.7)
    .select__menu-link
      height: calc(1.979vw * #{$gain-xs} * 1.7)
      padding-top: calc(0.521vw * #{$gain-xs} * 1.7)
      padding-bottom: calc(0.521vw * #{$gain-xs} * 1.7)
      padding-right: calc(0.573vw * #{$gain-xs} * 1.7)
      padding-left: calc(0.885vw * #{$gain-xs} * 1.7)
      font-size: calc(0.729vw * #{$gain-xs} * 1.7)
    .select__caret
      &::before
        font-size: calc(0.260vw * #{$gain-xs} * 1.7)

  .select_type_product
    .select__toggle
      height: calc(3.021vw * #{$gain-xs} * 1.7)
      padding-top: calc(1.042vw * #{$gain-xs} * 1.7)
      padding-bottom: calc(1.042vw * #{$gain-xs} * 1.7)
      padding-right: calc(1.458vw * #{$gain-xs} * 1.7)
      padding-left: calc(1.146vw * #{$gain-xs} * 1.7)
      font-size: calc(0.729vw * #{$gain-xs} * 1.7)
      border: calc(0.052vw * #{$gain-xs} * 1.7) solid $color-text
    .select__menu
      top: calc(3.021vw * #{$gain-xs} * 1.7)
      border: calc(0.052vw * #{$gain-xs} * 1.7) solid $color-text
    .select__menu-item
      border-bottom: calc(0.052vw * #{$gain-xs} * 1.7) solid $color-text
    .select__menu-link
      height: calc(3.021vw * #{$gain-xs} * 1.7)
      padding-top: calc(1.042vw * #{$gain-xs} * 1.7)
      padding-bottom: calc(1.042vw * #{$gain-xs} * 1.7)
      padding-right: calc(1.458vw * #{$gain-xs} * 1.7)
      padding-left: calc(1.146vw * #{$gain-xs} * 1.7)
      font-size: calc(0.729vw * #{$gain-xs} * 1.7)
    .select__caret
      width: calc(0.833vw * #{$gain-xs} * 1.7)
      height: calc(0.417vw * #{$gain-xs} * 1.7)
      &::before
        font-size: calc(0.417vw * #{$gain-xs} * 1.7)

  // common styles
  .select__text
    margin-right: calc(0.573vw * #{$gain-xs} * 1.7)

  .select__menu
    box-shadow: 0 calc(0.313vw * #{$gain-xs}) calc(0.625vw * #{$gain-xs}) rgba(0, 0, 0, 0.175)
</style>
