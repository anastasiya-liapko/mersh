<template>
  <div class="cart d-flex flex-column">
    <div class="container container-main flex-grow-1 d-flex flex-column">
      <div class="container-inner flex-grow-1">

        <h2 class="title cart__title text-center">{{ title }}</h2>

        <form class="cart__form d-flex flex-column align-items-center">
          <transition-group class="cart-transition-group cart-transition-group__item position-relative"
            name="cart-transition-group"
            tag="div">
          <div class="cart__form-header d-flex align-items-center w-100 cart-transition-group__item"
            v-if="totalPrice !== 0"
            v-bind:key="1">
            <div class="cart__form-header-text cart__form-name d-none d-sm-flex">Наименование</div>
            <div class="cart__form-header-text cart__form-variants d-none d-sm-flex">Характеристики</div>
            <div class="cart__form-header-text cart__form-price d-none d-sm-flex">Цена</div>
            <div class="cart__form-header-text cart__form-multiplication d-none d-sm-flex"></div>
            <div class="cart__form-header-text cart__form-quantity d-none d-sm-flex">Количество</div>
            <div class="cart__form-header-text cart__form-total d-none d-sm-flex">сумма</div>
            <div class="cart__form-header-text cart__form-del d-none d-sm-flex"></div>
          </div>

          <div v-bind:key="2">
          <app-product class="cart-transition-group__item"
            v-for="(product, i) in cartProducts"
            v-bind:key="product.id+product.variant+product.quantity+i"
            :product="product" :index="i">
          </app-product>
          </div>

          <div class="cart__form-footer d-flex align-items-center w-100 cart-transition-group__item"
            v-if="totalPrice !== 0"
            v-bind:key="3">
            <div class="cart__form-footer-text cart__form-name">Всего</div>
            <div class="cart__form-footer-text cart__form-variants d-none d-sm-flex"></div>
            <div class="cart__form-footer-text cart__form-price d-none d-sm-flex"></div>
            <div class="cart__form-footer-text cart__form-multiplication d-none d-sm-flex"></div>
            <div class="cart__form-footer-text cart__form-quantity d-none d-sm-flex"></div>
            <div class="cart__form-footer-text cart__form-total text-right text-sm-center">{{ totalPrice }} руб.</div>
          </div>

          <button class="cart__form-submit button button_submit button_form button_form-page d-flex align-items-center justify-content-center cart-transition-group__item"
            data-success="Отправлено!"
            data-error="Ошибка!"
            @click.prevent="submit"
            :disabled="disabled && totalPrice !== 0"
            v-bind:key="4">
            <span class="w-100" data-empty="Перейти в каталог">{{ message }}</span>
          </button>
          </transition-group>
        </form>

      </div>
    </div>
  </div>
</template>

<script>
import Product from '@/components/ProductCart.vue'
import { mapGetters, mapActions } from 'vuex'
import axios from 'axios'
import { scrollMixin } from '@/mixins'

export default {
  name: 'cart',
  data () {
    return {
      title: 'Корзина',
      message: 'Отправить'
    }
  },
  computed: {
    ...mapGetters([
      'selectName',
      'selectShow',
      'cartProducts',
      'totalPrice',
      'disabled'
    ])
  },
  created () {
    this.checkIfValid()
  },
  mounted () {
    this.setTitle()
  },
  beforeDestroy () {
    this.scroll(0)
  },
  methods: {
    ...mapActions([
      'filterSelect',
      'resetSelect',
      'checkIfValid',
      'setOrder'
    ]),
    showMessage (value) {
      var button = document.querySelector('.cart .button_submit')
      if (!value) {
        button.classList.add('error')
      } else {
        button.classList.add('success')
      }
      setTimeout(function () {
        button.classList.remove('error')
        button.classList.remove('success')
      }, 1200)
    },
    setTitle () {
      var button = document.querySelector('.cart .button_submit')
      this.totalPrice === 0 ? button.classList.add('empty') : button.classList.remove('empty')
      this.title = this.totalPrice === 0 ? 'Корзина пуста!' : 'Корзина'
    },
    submit () {
      var self = this

      var array = []
      self.cartProducts.forEach( function (elem, i) {
        array[i] = {}
        array[i].id = elem.id
        array[i].quantity = elem.quantity
        array[i].attributes = []
        elem.variants.forEach(function (item) {
          item.values.forEach(function (value) {
            if (value.value === item.selected) {
              array[i].attributes.push({
                'attr_id': item.attr_id,
                'value_id': value.value_id
              })
            }
          })
        })
      })
      self.setOrder(array)

      if (this.totalPrice === 0) {
        this.$router.push({ name: 'index' })
      } else {
        axios.post('/post.php', self.cartProducts)
          .then(function (response) {
            // console.log(response)
            self.showMessage(1)
            self.$router.push({ name: 'order-register' })
          })
          .catch(function (error) {
            console.log(error)
            self.showMessage(0)

            // for test
            // self.$router.push({ name: 'order-register' })
          })
      }
    }
  },
  watch: {
    totalPrice: function () {
      this.setTitle()
    }
  },
  components: {
    'app-product': Product
  },
  mixins: [scrollMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.cart
  .container-inner
    // padding-top: 92px
    // padding-bottom: 112px
    padding-top: 4.792vw
    padding-bottom: 5.833vw

.cart__title
  margin-bottom: 0

.cart__form
  // margin-top: 20px
  margin-top: 1.042vw

.cart__form-product
  // margin-bottom: 20px
  // padding-top: 16px
  // padding-bottom: 16px
  // padding-left: 36px
  // padding-right: 26px
  margin-bottom: 1.042vw
  padding-top: 0.833vw
  padding-bottom: 0.833vw
  padding-left: 1.875vw
  padding-right: 1.354vw
  background-color: $color-lightgrey
  border: 1px solid $color-text

.cart__form-name
  // width: 198px
  width: 10.313vw
  font-family: $font-montserrat
  // font-size: 18px
  font-size: 0.938vw
  font-weight: 700
  line-height: 1
  color: $color-brown
  transition: opacity 0.3s
  &:hover
    text-decoration: none
    color: $color-brown
    opacity: 0.7

.cart__form-variants
  // width: 152px
  // margin-left: 5px
  // margin-right: 5px
  width: 7.917vw
  margin-left: 0.260vw
  margin-right: 0.260vw

.cart__form-price
  // width: 91px
  width: 4.740vw
  margin-left: auto
  font-family: $font-montserrat
  // font-size: 14px
  font-size: 0.729vw
  font-weight: 400
  line-height: 1
  color: $color-brown
  white-space: nowrap

.cart__form-multiplication
  // width: 8px
  // height: 8px
  // margin-left: 21px
  // margin-right: 21px
  width: 0.417vw
  height: 0.417vw
  margin-left: 1.094vw
  margin-right: 1.094vw
  .icon
    font-family: $font-montserrat
    // font-size: 8px
    font-size: 0.417vw
    font-weight: 400
    line-height: 1
    color: $color-brown

.cart__form-quantity
  // width: 110px
  width: 5.729vw

.cart__form-total
  // width: 112px
  // margin-left: 30px
  width: 5.833vw
  margin-left: 1.563vw
  font-family: $font-montserrat
  // font-size: 14px
  font-size: 0.729vw
  font-weight: 700
  line-height: 1
  color: $color-brown
  white-space: nowrap

.cart__form-del
  // width: 17px
  // height: 20px
  // margin-left: 5px
  width: 0.885vw
  height: 1.042vw
  margin-left: 0.260vw
  transition: opacity 0.3s
  .icon
    &::before
      // font-size: 20px
      font-size: 1.042vw
      color: $color-brown
  &:hover
    opacity: 0.7
    cursor: pointer

.cart__form-input
  // width: 100px
  // height: 38px
  width: 5.208vw
  height: 1.979vw
  font-family: $font-montserrat
  // font-size: 14px
  font-size: 0.729vw
  font-weight: 400
  // line-height: 38px
  line-height: 1.979vw
  text-align: center
  color: $color-brown
  background-color: transparent
  border: 1px solid $color-text
  &::placeholder
    font-family: $font-montserrat
    // font-size: 14px
    font-size: 0.729vw
    font-weight: 400
    // line-height: 38px
    line-height: 1.979vw
    text-align: center
    color: $color-brown
    opacity: 0.7

.cart__form-header
  // padding-left: 36px
  // padding-right: 26px
  // padding-top: 20px
  // padding-bottom: 20px
  padding-left: 1.875vw
  padding-right: 1.354vw
  padding-top: 1.042vw
  padding-bottom: 1.042vw

.cart__form-header-text
  font-family: $font-montserrat
  // font-size: 14px
  font-size: 0.729vw
  font-weight: 700
  line-height: 1
  color: $color-brown
  white-space: nowrap
  text-transform: uppercase

.cart__form-footer
  // margin-top: 7px
  // padding-top: 26px
  // padding-bottom: 26px
  // padding-left: 36px
  // padding-right: 26px
  margin-top: 0.365vw
  padding-top: 1.354vw
  padding-bottom: 1.354vw
  padding-left: 1.875vw
  padding-right: 1.354vw
  border-top: 1px solid $color-text
  .cart__form-total
    // width: 134px
    width: 6.979vw
  .cart__form-name
    &:hover
      opacity: 1

.cart__form-footer-text
  font-family: $font-montserrat
  // font-size: 18px
  font-size: 0.938vw
  font-weight: 700
  line-height: 1
  color: $color-brown
  white-space: nowrap

.cart__form-submit
  // margin-top: 36px
  margin-top: 1.875vw
  margin-left: auto
  margin-right: auto
  perspective: 800px
  &:hover
    span::before
      background: $color-text
  &:disabled:hover
    span::before
      background: $color-brown
  span
    position: relative
    transition: background 0.6s
    transform-origin: 50% 0
    transform-style: preserve-3d
    transform-origin: 0% 50%
    pointer-events: none
    &::before
      position: absolute
      top: 0
      left: 0
      width: 100%
      height: 100%
      background: $color-brown
      color: $color-brown
      content: attr(data-empty)
      transform: rotateX(270deg)
      transition: transform 0.6s, background 0.3s
      transform-origin: 0 0
      pointer-events: none

.cart__form-submit.empty
  overflow: visible
  span
  span::before
    color: $color-white
    transform: rotateX(0deg)
  &::before
    color: transparent

.cart-transition-group
  display: flex
  flex-direction: column
  justify-content: flex-end
  width: 100%

.cart-transition-group__item
  transition: all 0.4s, opacity 0.2s

.cart-transition-group-enter,
.cart-transition-group-leave-to
  // opacity: 0
  // transform: translateY(30px)

.cart-transition-group-leave-to
  opacity: 0

.cart-transition-group-leave-active
  position: absolute

@media(max-width: 1199px)
  .cart
    .container-inner
      padding-top: calc(92px / #{$lose-m})
      padding-bottom: calc(112px / #{$lose-m})

  .cart__form
    margin-top: calc(20px / #{$lose-m})

  .cart__form-product
    margin-bottom: calc(20px / #{$lose-m})
    padding-top: calc(16px / #{$lose-m})
    padding-bottom: calc(16px / #{$lose-m})
    padding-left: calc(36px / #{$lose-m})
    padding-right: calc(26px / #{$lose-m})

  .cart__form-name
    width: calc(198px / #{$lose-m})
    font-size: calc(18px / #{$lose-m})

  .cart__form-variants
    width: calc(152px / #{$lose-m})
    margin-left: calc(5px / #{$lose-m})
    margin-right: calc(5px / #{$lose-m})

  .cart__form-price
    width: calc(91px / #{$lose-m})
    font-size: calc(14px / #{$lose-m})

  .cart__form-multiplication
    width: calc(8px / #{$lose-m})
    height: calc(8px / #{$lose-m})
    margin-left: calc(21px / #{$lose-m})
    margin-right: calc(21px / #{$lose-m})
    .icon
      font-size: calc(8px / #{$lose-m})

  .cart__form-quantity
    width: calc(110px / #{$lose-m})

  .cart__form-total
    width: calc(112px / #{$lose-m})
    margin-left: calc(30px / #{$lose-m})
    font-size: calc(14px / #{$lose-m})

  .cart__form-del
    width: calc(17px / #{$lose-m})
    height: calc(20px / #{$lose-m})
    margin-left: calc(5px / #{$lose-m})
    .icon
      &::before
        font-size: calc(20px / #{$lose-m})

  .cart__form-input
    width: calc(100px / #{$lose-m})
    height: calc(38px / #{$lose-m})
    font-size: calc(14px / #{$lose-m})
    line-height: calc(38px / #{$lose-m})
    &::placeholder
      font-size: calc(14px / #{$lose-m})
      line-height: calc(38px / #{$lose-m})

  .cart__form-header
    padding-left: calc(36px / #{$lose-m})
    padding-right: calc(26px / #{$lose-m})
    padding-top: calc(20px / #{$lose-m})
    padding-bottom: calc(20px / #{$lose-m})

  .cart__form-header-text
    font-size: calc(14px / #{$lose-m})

  .cart__form-footer
    margin-top: calc(7px / #{$lose-m})
    padding-top: calc(26px / #{$lose-m})
    padding-bottom: calc(26px / #{$lose-m})
    padding-left: calc(36px / #{$lose-m})
    padding-right: calc(26px / #{$lose-m})
    .cart__form-total
      width: calc(134px / #{$lose-m})

  .cart__form-footer-text
    font-size: calc(18px / #{$lose-m})

  .cart__form-submit
    margin-top: calc(36px / #{$lose-m})

@media(max-width: 991px)
  .cart
    .container-inner
      padding-top: calc(92px / #{$lose-s})
      padding-bottom: calc(112px / #{$lose-s})

  .cart__form
    margin-top: calc(20px / #{$lose-s})

  .cart__form-product
    margin-bottom: calc(20px / #{$lose-s})
    padding-top: calc(16px / #{$lose-s})
    padding-bottom: calc(16px / #{$lose-s})
    padding-left: calc(36px / #{$lose-s})
    padding-right: calc(26px / #{$lose-s})

  .cart__form-name
    width: calc(198px / #{$lose-s})
    font-size: calc(18px / #{$lose-s})

  .cart__form-variants
    width: calc(152px / #{$lose-s})
    margin-left: calc(5px / #{$lose-s})
    margin-right: calc(5px / #{$lose-s})

  .cart__form-price
    width: calc(91px / #{$lose-s})
    font-size: calc(14px / #{$lose-s})

  .cart__form-multiplication
    width: calc(8px / #{$lose-s})
    height: calc(8px / #{$lose-s})
    margin-left: calc(21px / #{$lose-s})
    margin-right: calc(21px / #{$lose-s})
    .icon
      font-size: calc(8px / #{$lose-s})

  .cart__form-quantity
    width: calc(110px / #{$lose-s})

  .cart__form-total
    width: calc(112px / #{$lose-s})
    margin-left: calc(30px / #{$lose-s})
    font-size: calc(14px / #{$lose-s})

  .cart__form-del
    width: calc(17px / #{$lose-s})
    height: calc(20px / #{$lose-s})
    margin-left: calc(5px / #{$lose-s})
    .icon
      &::before
        font-size: calc(20px / #{$lose-s})

  .cart__form-input
    width: calc(100px / #{$lose-s})
    height: calc(38px / #{$lose-s})
    font-size: calc(14px / #{$lose-s})
    line-height: calc(38px / #{$lose-s})
    &::placeholder
      font-size: calc(14px / #{$lose-s})
      line-height: calc(38px / #{$lose-s})

  .cart__form-header
    padding-left: calc(36px / #{$lose-s})
    padding-right: calc(26px / #{$lose-s})
    padding-top: calc(20px / #{$lose-s})
    padding-bottom: calc(20px / #{$lose-s})

  .cart__form-header-text
    font-size: calc(14px / #{$lose-s})

  .cart__form-footer
    margin-top: calc(7px / #{$lose-s})
    padding-top: calc(26px / #{$lose-s})
    padding-bottom: calc(26px / #{$lose-s})
    padding-left: calc(36px / #{$lose-s})
    padding-right: calc(26px / #{$lose-s})
    .cart__form-total
      width: calc(134px / #{$lose-s})

  .cart__form-footer-text
    font-size: calc(18px / #{$lose-s})

  .cart__form-submit
    margin-top: calc(36px / #{$lose-s})

@media(max-width: 575px)
  .cart
    .container-main
      padding-left: 0
      padding-right: 0
    .container-inner
      padding-top: calc(4.792vw * #{$gain-xs} / 1.5)
      padding-bottom: calc(5.833vw * #{$gain-xs} / 1.5)
      padding-left: 15px
      padding-right: 15px

  .cart__form
    margin-top: calc(1.042vw * #{$gain-xs})

  .cart__form-product
    margin-bottom: calc(1.042vw * #{$gain-xs})
    padding-top: calc(0.833vw * #{$gain-xs})
    padding-bottom: calc(0.833vw * #{$gain-xs})
    padding-left: calc(1.875vw * #{$gain-xs})
    padding-right: calc(1.354vw * #{$gain-xs})

  .cart__form-name
    flex-grow: 1
    width: 50%
    margin-right: calc(0.260vw * #{$gain-xs})
    font-size: calc(0.938vw * #{$gain-xs} * 1.7)

  .cart__form-variants
    width: 100%
    margin-left: 0
    margin-right: 0
    margin-top: calc(0.781vw * #{$gain-xs})
    margin-bottom: calc(0.781vw * #{$gain-xs})

  .cart__form-price
    width: auto
    margin-left: 0
    font-size: calc(0.729vw * #{$gain-xs} * 1.7)

  .cart__form-multiplication
    flex-grow: 1
    height: calc(0.417vw * #{$gain-xs} * 2)
    margin-left: calc(1.094vw * #{$gain-xs})
    margin-right: calc(1.094vw * #{$gain-xs})
    .icon
      font-size: calc(0.417vw * #{$gain-xs} * 2)

  .cart__form-quantity
    display: flex
    width: auto
    margin-right: auto
    margin-left: auto

  .cart__form-total
    width: 38%
    margin-left: calc(0.260vw * #{$gain-xs})
    margin-right: 0
    font-size: calc(0.729vw * #{$gain-xs} * 1.7)
    text-align: right

  .cart__form-del
    width: calc(0.885vw * #{$gain-xs} * 2)
    height: calc(1.042vw * #{$gain-xs} * 2)
    margin-left: calc(0.260vw * #{$gain-xs})
    .icon
      &::before
        font-size: calc(1.042vw * #{$gain-xs} * 2)

  .cart__form-input
    width: calc(5.208vw * #{$gain-xs} * 1.7)
    height: calc(1.979vw * #{$gain-xs} * 1.7)
    font-size: calc(0.729vw * #{$gain-xs} * 1.7)
    line-height: calc(1.979vw * #{$gain-xs} * 1.7)
    &::placeholder
      font-size: calc(0.729vw * #{$gain-xs} * 1.7)
      line-height: calc(1.979vw * #{$gain-xs} * 1.7)

  .cart__form-header
    padding-left: calc(1.875vw * #{$gain-xs})
    padding-right: calc(1.354vw * #{$gain-xs})
    padding-top: calc(1.042vw * #{$gain-xs})
    padding-bottom: calc(1.042vw * #{$gain-xs})

  .cart__form-header-text
    font-size: calc(0.729vw * #{$gain-xs})

  .cart__form-footer
    margin-top: calc(0.365vw * #{$gain-xs})
    padding-top: calc(1.354vw * #{$gain-xs})
    padding-bottom: calc(1.354vw * #{$gain-xs})
    padding-left: calc(1.875vw * #{$gain-xs})
    padding-right: calc(1.354vw * #{$gain-xs})
    .cart__form-total
      width: 50%

  .cart__form-footer-text
    font-size: calc(0.938vw * #{$gain-xs} * 1.7)

  .cart__form-submit
    margin-top: calc(1.875vw * #{$gain-xs})

</style>
