<template>
  <div class="order-accept d-flex flex-column">
    <div class="container container-main flex-grow-1 d-flex flex-column">
      <div class="container-inner flex-grow-1 d-flex flex-column align-items-center">
        <h2 class="title order-accept__title text-center">ВАш заказ принят</h2>

        <form class="order-accept__form d-flex flex-column align-items-center">
          <div class="order-accept__form-header d-flex flex-column align-items-center">
            <div class="order-accept__form-icon-wrapper">
              <span class="icon icon-checked"></span>
            </div>
            <span class="order-accept__form-order-number">Заказ №{{ orderNumber }}</span>
          </div>

          <div class="d-flex flex-column align-items-center w-100">
          <div class="order-accept__form-product d-flex justify-content-center align-items-center"
            v-for="(product) in cartProducts"
            v-bind:key="product.id">
            <div class="order-accept__form-name order-1 order-sm-1">{{ product.name }}</div>

            <div class="order-accept__form-price order-4 order-sm-3 text-right">{{ product.price }} руб.</div>
            <div class="order-accept__form-multiplication order-5 order-sm-4 d-flex align-items-center justify-content-center">
              <span class="icon">x</span>
            </div>
            <div class="order-accept__form-quantity order-6 order-sm-5">{{ product.quantity }}</div>
            <div class="order-accept__form-total order-7 order-sm-6 text-right">{{ product.total }} руб.</div>
          </div>
          </div>

          <div class="order-accept__form-order-price">{{ totalPrice }} руб.</div>

          <p class="order-accept__form-descr">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim</p>

          <router-link class="order-accept__form-submit button button_form button_form-page"
            :to="{name: 'index'}"
            tag="a">
              Продолжить покупки
          </router-link>
        </form>

      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import { scrollMixin } from '@/mixins'

export default {
  name: 'order-accept',
  computed: {
    ...mapGetters([
      'cartProducts',
      'totalPrice',
      'orderNumber'
    ])
  },
  beforeDestroy () {
    this.deleteCartProducts()
    this.scroll(0)
  },
  methods: {
    ...mapActions([
      'emptyCart'
    ]),
    deleteCartProducts () {
      var self = this
      this.emptyCart()
      localStorage.removeItem('mershProducts')
      localStorage.removeItem('mershTotalPrice')
      localStorage.removeItem('mershTotalQuantity')
      localStorage.removeItem('mershOrder')
      localStorage.removeItem('mershOrderNumber')
    }
  },
  mixins: [scrollMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.order-accept
  .container-inner
    // padding-top: 92px
    // padding-bottom: 91px
    padding-top: 4.792vw
    padding-bottom: 4.740vw

.order-accept__title
  // margin-bottom: 47px
  margin-bottom: 2.448vw

.order-accept__form
  // width: 773px
  width: 40.260vw

.order-accept__form-header
  // width: 647px
  // margin-bottom: 27px
  width: 33.698vw
  margin-bottom: 1.406vw
  border-top: 1px solid $color-text

.order-accept__form-icon-wrapper
  // width: 135px
  // height: 135px
  // margin-top: 66px
  // margin-bottom: 43px
  width: 7.031vw
  height: 7.031vw
  margin-top: 3.438vw
  margin-bottom: 2.240vw
  .icon
    &::before
      // font-size: 135px
      font-size: 7.031vw
      color: $color-brown

.order-accept__form-order-number
  font-family: $font-montserrat
  // font-size: 31px
  font-size: 1.615vw
  font-weight: 400
  line-height: 1
  color: $color-brown

.order-accept__form-product
  // width: 678px
  // margin-bottom: 10px
  // padding-left: 36px
  // padding-right: 46px
  // padding-top: 24px
  // padding-bottom: 24px
  width: 35.313vw
  margin-bottom: 0.521vw
  padding-left: 1.875vw
  padding-right: 2.396vw
  padding-top: 1.250vw
  padding-bottom: 1.250vw
  background-color: $color-lightgrey
  border: 1px solid $color-text
  &:last-child
    margin-bottom: 0

.order-accept__form-name
  width: 39%
  margin-right: auto
  font-family: $font-montserrat
  // font-size: 18px
  font-size: 0.938vw
  font-weight: 700
  line-height: 1
  color: $color-brown

.order-accept__form-total
  width: 24%
  margin-left: auto
  font-family: $font-montserrat
  // font-size: 14px
  font-size: 0.729vw
  font-weight: 700
  line-height: 1
  color: $color-brown

.order-accept__form-price,
.order-accept__form-multiplication,
.order-accept__form-quantity
  font-family: $font-montserrat
  // font-size: 14px
  font-size: 0.729vw
  font-weight: 400
  line-height: 1
  color: $color-brown

.order-accept__form-price
  width: 20%
  white-space: nowrap

.order-accept__form-quantity
  width: 10%

.order-accept__form-multiplication
  // margin-left: 21px
  // margin-right: 21px
  margin-left: 1.094vw
  margin-right: 1.094vw

.order-accept__form-order-price
  // margin-top: 30px
  // margin-bottom: 43px
  margin-top: 1.563vw
  margin-bottom: 2.240vw
  font-family: $font-montserrat
  // font-size: 20px
  font-size: 1.042vw
  font-weight: 700
  line-height: 1
  color: $color-brown

.order-accept__form-descr
  // margin-bottom: 30px
  margin-bottom: 1.563vw
  font-family: $font-montserrat
  // font-size: 20px
  font-size: 1.042vw
  font-weight: 400
  line-height: normal
  text-align: center
  color: $color-brown

@media(max-width: 1199px)
  .order-accept
    .container-main
      padding-left: 0
      padding-right: 0
    .container-inner
      padding-top: calc(92px / #{$lose-m})
      padding-bottom: calc(91px / #{$lose-m})
      padding-left: 15px
      padding-right: 15px

  .order-accept__title
    margin-bottom: calc(47px / #{$lose-m})

  .order-accept__form
    width: calc(773px / #{$lose-m})

  .order-accept__form-header
    width: calc(647px / #{$lose-m})
    margin-bottom: calc(27px / #{$lose-m})

  .order-accept__form-icon-wrapper
    width: calc(135px / #{$lose-m})
    height: calc(135px / #{$lose-m})
    margin-top: calc(66px / #{$lose-m})
    margin-bottom: calc(43px / #{$lose-m})
    .icon
      &::before
        font-size: calc(135px / #{$lose-m})

  .order-accept__form-order-number
    font-size: calc(31px / #{$lose-m})

  .order-accept__form-product
    width: calc(678px / #{$lose-m})
    margin-bottom: calc(10px / #{$lose-m})
    padding-left: calc(36px / #{$lose-m})
    padding-right: calc(46px / #{$lose-m})
    padding-top: calc(24px / #{$lose-m})
    padding-bottom: calc(24px / #{$lose-m})

  .order-accept__form-name
    font-size: calc(18px / #{$lose-m})

  .order-accept__form-total
    font-size: calc(14px / #{$lose-m})

  .order-accept__form-price,
  .order-accept__form-multiplication,
  .order-accept__form-quantity
    font-size: calc(14px / #{$lose-m})

  .order-accept__form-multiplication
    margin-left: calc(21px / #{$lose-m})
    margin-right: calc(21px / #{$lose-m})

  .order-accept__form-order-price
    margin-top: calc(30px / #{$lose-m})
    margin-bottom: calc(43px / #{$lose-m})
    font-size: calc(20px / #{$lose-m})

  .order-accept__form-descr
    margin-bottom: calc(30px / #{$lose-m})
    font-size: calc(20px / #{$lose-m})

@media(max-width: 767px)
  .order-accept
    .container-inner
      padding-top: calc(92px / #{$lose-s})
      padding-bottom: calc(91px / #{$lose-s})

  .order-accept__title
    margin-bottom: calc(47px / #{$lose-s})

  .order-accept__form
    width: calc(773px / #{$lose-s})

  .order-accept__form-header
    width: calc(647px / #{$lose-s})
    margin-bottom: calc(27px / #{$lose-s})

  .order-accept__form-icon-wrapper
    width: calc(135px / #{$lose-s})
    height: calc(135px / #{$lose-s})
    margin-top: calc(66px / #{$lose-s})
    margin-bottom: calc(43px / #{$lose-s})
    .icon
      &::before
        font-size: calc(135px / #{$lose-s})

  .order-accept__form-order-number
    font-size: calc(31px / #{$lose-s})

  .order-accept__form-product
    width: calc(678px / #{$lose-s})
    margin-bottom: calc(10px / #{$lose-s})
    padding-left: calc(36px / #{$lose-s})
    padding-right: calc(46px / #{$lose-s})
    padding-top: calc(24px / #{$lose-s})
    padding-bottom: calc(24px / #{$lose-s})

  .order-accept__form-name
    font-size: calc(18px / #{$lose-s})

  .order-accept__form-total
    font-size: calc(14px / #{$lose-s})

  .order-accept__form-price,
  .order-accept__form-multiplication,
  .order-accept__form-quantity
    font-size: calc(14px / #{$lose-s})

  .order-accept__form-multiplication
    margin-left: calc(21px / #{$lose-s})
    margin-right: calc(21px / #{$lose-s})

  .order-accept__form-order-price
    margin-top: calc(30px / #{$lose-s})
    margin-bottom: calc(43px / #{$lose-s})
    font-size: calc(20px / #{$lose-s})

  .order-accept__form-descr
    margin-bottom: calc(30px / #{$lose-s})
    font-size: calc(20px / #{$lose-s})

@media(max-width: 575px)
  .order-accept
    .container-inner
      padding-top: calc(4.792vw * #{$gain-xs} / 1.5)
      padding-bottom: calc(4.740vw * #{$gain-xs} / 1.5)

  .order-accept__title
    margin-bottom: calc(2.448vw * #{$gain-xs})

  .order-accept__form
    width: 100%

  .order-accept__form-header
    width: calc(33.698vw * #{$gain-xs})
    margin-bottom: calc(1.406vw * #{$gain-xs})

  .order-accept__form-icon-wrapper
    width: calc(7.031vw * #{$gain-xs})
    height: calc(7.031vw * #{$gain-xs})
    margin-top: calc(3.438vw * #{$gain-xs})
    margin-bottom: calc(2.240vw * #{$gain-xs})
    .icon
      &::before
        font-size: calc(7.031vw * #{$gain-xs})

  .order-accept__form-order-number
    font-size: calc(1.615vw * #{$gain-xs} * 1.2)

  .order-accept__form-product
    width: 100%
    margin-bottom: calc(0.521vw * #{$gain-xs})
    padding-left: calc(1.875vw * #{$gain-xs} / 2)
    padding-right: calc(2.396vw * #{$gain-xs} / 2)
    padding-top: calc(1.250vw * #{$gain-xs})
    padding-bottom: calc(1.250vw * #{$gain-xs})

  .order-accept__form-name
    font-size: calc(0.938vw * #{$gain-xs} * 1.3)

  .order-accept__form-total
    font-size: calc(0.729vw * #{$gain-xs} * 1.3)

  .order-accept__form-price,
  .order-accept__form-multiplication,
  .order-accept__form-quantity
    font-size: calc(0.729vw * #{$gain-xs} * 1.3)

  .order-accept__form-multiplication
    margin-left: calc(1.094vw * #{$gain-xs})
    margin-right: calc(1.094vw * #{$gain-xs})

  .order-accept__form-order-price
    margin-top: calc(1.563vw * #{$gain-xs})
    margin-bottom: calc(2.240vw * #{$gain-xs})
    font-size: calc(1.042vw * #{$gain-xs} * 1.5)

  .order-accept__form-descr
    margin-bottom: calc(1.563vw * #{$gain-xs})
    font-size: calc(1.042vw * #{$gain-xs} * 1.2)

</style>
