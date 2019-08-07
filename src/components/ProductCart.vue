<template>
  <div class="cart__form-product d-flex flex-wrap flex-sm-nowrap justify-content-center align-items-center w-100">
    <router-link class="cart__form-name order-1 order-sm-1"
      :to="{name: 'category-product', params: { name: product.category, id: product.id }}"
      tag="a">
      {{ product.name }}
    </router-link>

    <div class="cart__form-variants flex-grow-1 d-flex flex-column flex-md-row flex-wrap order-3 order-sm-2">
      <div class="cart__select-wrapper select-wrapper d-flex flex-wrap align-items-center justify-content-between"
        v-for="(attribute, i) in product.variants"
        v-bind:key="i"
        :class="{invalid: attribute.selected === '' && attribute.touched}">
        <app-select
          :id="'js-selectCart-' + index"
          class="cart__select select select_type_cart"
          :show="selectShow && selectName === attribute.name + index"
          :name="attribute.name + index"
          :placeholder="attribute.name"
          :options="attribute.values"
          :selected="attribute.selected"
          v-on:updateOption="select">
        </app-select>
        <transition name="fade">
          <p class="cart__error-text cart__error-text_type_select"
            v-if="attribute.selected === '' && attribute.touched">
            Это обязательное поле
          </p>
        </transition>
      </div>
    </div>

    <div class="cart__form-price order-4 order-sm-3">{{ product.price }} руб.</div>
    <div class="cart__form-multiplication order-5 order-sm-4 d-flex align-items-center justify-content-center">
      <span class="icon">x</span>
    </div>
    <div class="cart__form-quantity order-6 order-sm-5">
      <input class="cart__form-input"
        type="text"
        placeholder="12"
        v-model="quantity"
        v-mask="'999'">
    </div>
    <div class="cart__form-total order-7 order-sm-6">{{ product.total }} руб.</div>
    <div class="cart__form-del order-2 order-sm-7 d-flex align-items-center justify-content-center"
      @click="removeFromCart(product)">
      <span class="icon icon-delete d-flex align-items-center justify-content-center"></span>
    </div>
  </div>
</template>

<script>
import Select from '@/components/Select.vue'
import { mapGetters, mapActions } from 'vuex'
import { required } from 'vuelidate/lib/validators'
import AwesomeMask from 'awesome-mask'

export default {
  data () {
    return {
      quantity: this.product.quantity,
      // touchVariants: false,
      variant: this.product.variant
    }
  },
  props: ['product', 'index'],
  computed: {
    ...mapGetters([
      'selectName',
      'selectShow'
    ])
  },
  mounted () {
    this.checkIfValid()
  },
  validations: {
    variant: {
      required
    }
  },
  methods: {
    ...mapActions([
      'removeFromCart',
      'updateVariant',
      'updateQuantity',
      'checkIfValid'
    ]),
    select (value) {
      var context = this
      this.variant = value[1] === '' ? '' : value[1].value
      this.product.variants.forEach( function (elem) {
        if (elem.name + context.index === value[0]) {
          elem.touched = true
          elem.selected = value[1] === '' ? '' : value[1].value
          elem.selectedPrice = value[1] === '' ? 0 : parseFloat(value[1].price)
        }
      })
      this.calcProductPrice()
    },
    calcProductPrice () {
      var priceDelta = 0
      this.product.variants.forEach(function (elem) {
        priceDelta += elem.selectedPrice
      })
      this.product.price = +(this.product.priceStart + priceDelta).toFixed(10)
    }
  },
  watch: {
    quantity: function () {
      if (this.quantity !== '') {
        var quantity = parseInt(this.quantity)
        var item = {
          id: this.product.id,
          index: this.index,
          name: this.product.name,
          category: this.product.category,
          quantity: quantity,
          priceStart: this.product.priceStart,
          price: this.product.price,
          variant: this.variant,
          variants: this.product.variants
        }
        this.updateQuantity(item)
      }
    },
    variant: function () {
      var item = {
        id: this.product.id,
        index: this.index,
        name: this.product.name,
        category: this.product.category,
        quantity: this.quantity,
        priceStart: this.product.priceStart,
        price: this.product.price,
        variant: this.variant,
        variants: this.product.variants
      }
      this.updateVariant(item)
    }
  },
  directives: {
    'mask': AwesomeMask
  },
  components: {
    'app-select': Select
  }
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.cart__select-wrapper
  position: relative
  // margin-right: 20px
  margin-right: 1.042vw
  &:last-child
    margin-right: 0
  &.invalid
    .select__toggle
      border: 1px solid red

.cart__error-text
  position: absolute
  top: 100%
  right: 0
  width: 100%
  margin-top: 0
  margin-bottom: 0
  font-family: $font-montserrat
  // font-size: 14px
  font-size: 0.729vw
  font-weight: 400
  line-height: 1
  color: red
  white-space: nowrap

@media(max-width: 1199px)
  .cart__select-wrapper
    margin-right: calc(20px / #{$lose-m})

  .cart__error-text
    font-size: calc(14px / #{$lose-m})

@media(max-width: 991px)
  .cart__select-wrapper
    margin-right: calc(20px / #{$lose-s})

  .cart__error-text
    font-size: calc(14px / #{$lose-s})

@media(max-width: 767px)
  .cart__select-wrapper
    margin-bottom: calc(20px / #{$lose-xs})
    margin-right: 0
    &:last-child
      margin-bottom: 0

  .cart__error-text
    font-size: calc(14px / #{$lose-xs})

@media(max-width: 575px)
  .cart__select-wrapper
    margin-bottom: calc(1.042vw * #{$gain-xs})

  .cart__error-text
    font-size: calc(0.729vw * #{$gain-xs})
</style>
