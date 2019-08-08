<template>
  <div class="page-product d-flex flex-column">
    <div class="container container-main d-flex flex-grow-1">
      <div class="container-inner">
        <h2 class="title page-product__title text-center">{{ product.info.name }}</h2>
        <router-link class="page-product__category d-block text-center"
          :to="{name: 'category', params: {name: product.info.category_name.split(' ').join('-').toLowerCase() }}"
          tag="a">
          {{ product.info.category_name }}
        </router-link>

        <div class="page-product__slider">
          <app-slick class="product-slider"
            ref="slick"
            :options="slickOptions"
            @beforeChange="handleBeforeChange"
            @click.native="showCurrentSlide"
            @init="handleInit">
            <div
              class="position-relative"
              v-for="image in product.images"
              v-bind:key="image.id">
            <div
              data-toggle="modal"
              data-target="#js-preview">
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
                v-if="image.is_video === 0 && !showMute"
                @click="showMute = !showMute">
              </i>
            </div>
          </app-slick>
        </div>

        <div class="d-flex flex-column flex-sm-row justify-content-between">
          <div class="page-product__descr order-2 order-sm-1">
            <!-- <p class="subtitle privacy__subtitle page-product__subtitle">{{ product.subtitle }}</p> -->
            <div class="text privacy__text page-product__text" v-html="product.info.txt"></div>
          </div>
          <form class="page-product__form order-1 order-sm-2 d-flex flex-column align-items-center">
            <h2 class="title page-product__form-title text-right w-100">{{ productPrice }} P.</h2>

            <div class="page-product__select-wrapper select-wrapper d-flex flex-wrap align-items-center justify-content-between w-100"
              :class="{invalid: attribute.selected === '' && attribute.touched}"
              v-for="(attribute, i) in product.attributes"
              v-bind:key="i">
              <app-select
                class="page-product__select select select_type_product"
                :show="selectShow && selectName === attribute.name"
                :name="attribute.name"
                :placeholder="attribute.name"
                :options="attribute.values"
                :selected="attribute.selected"
                v-on:updateOption="select">
              </app-select>
              <transition name="fade">
                <p class="page-product__error-text page-product__error-text_type_select"
                  v-if="attribute.selected === '' && attribute.touched">
                  Это обязательное поле
                </p>
              </transition>
            </div>

            <button class="page-product__submit button button_form button_form-page button_submit"
              @click.prevent="submit"
              :data-toggle="!$v.$invalid && product.attributes.length === 0 || !validForm ? 'modal' : ''"
              :data-target="!$v.$invalid && product.attributes.length === 0 || !validForm ? '#js-success' : ''">
              <span class="button_submit-text">В корзину</span>
            </button>
          </form>
        </div>
      </div>
    </div>

    <app-preview type="modal" :product="product" :options="options"></app-preview>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters, mapActions } from 'vuex'
import { required } from 'vuelidate/lib/validators'
import Select from '@/components/Select.vue'
import Preview from '@/components/PopupPreview.vue'
import Slick from 'vue-slick'
import { scrollMixin } from '@/mixins'

export default {
  name: 'product',
  data () {
    return {
      product: '',
      productPrice: '',
      variant: '',
      slickOptions: {
        slidesToShow: 1,
        dots: true,
        initialSlide: 0
      },
      showMute: true,
      currentSlide: 0,
      domen: process.env.VUE_APP_DOMEN,
      validForm: false
    }
  },
  created () {
    this.fetch()
    // var self = this
    // var id = this.$router.currentRoute.params.id
    // this.products.forEach(function (elem, i) {
    //   if (elem.id === parseInt(id)) {
    //     self.product = elem
    //   }
    // })
  },
  beforeDestroy () {
    this.scroll(0)
  },
  computed: {
    ...mapGetters([
      // 'products',
      'selectName',
      'selectShow'
    ]),
    options () {
      return {
        slidesToShow: 1,
        dots: true,
        initialSlide: this.currentSlide
      }
    },
    productId () {
      return this.$route.params.id
    }
  },
  validations: {
    variant: {
      required
    }
  },
  methods: {
    ...mapActions([
      'filterSelect',
      'resetSelect',
      'addToCart'
      // 'removeFromCart'
    ]),
    fetch () {
      var context = this

      axios.get(context.domen + '/api/product/' + context.productId)
        .then(res => {
          // console.log(res)
          context.product = res.data
          if (context.product.images.length === 0) {
            context.product.images.push({
              'id': 1,
              'is_video': 0,
              'content': '/img/product-placeholder.png'
            })
          }
          context.productPrice = res.data.info.price
          context.product.attributes.forEach( function (elem) {
            elem.touched = false
            elem.selected = ''
          })
          // console.log(context.product)
        })
        .catch(error => console.log(error))
    },
    select (value) {
      this.variant = value[1] === '' ? '' : value[1].value
      this.product.attributes.forEach( function (elem) {
        if (elem.name === value[0]) {
          elem.touched = true
          elem.selected = value[1] === '' ? '' : value[1].value
          elem.selectedPrice = value[1] === '' ? 0 : parseFloat(value[1].price)
        }
      })
      this.calcProductPrice()
    },
    calcProductPrice () {
      var priceDelta = 0
      this.product.attributes.forEach(function (elem) {
        elem.selectedPrice === undefined ? '' : priceDelta += elem.selectedPrice
      })
      this.productPrice = +(parseFloat(this.product.info.price) + parseFloat(priceDelta)).toFixed(10)
    },
    submit () {
      var context = this
      context.validForm = false
      var item = {
        id: this.product.info.id,
        name: this.product.info.name,
        category: this.product.info.category_name,
        quantity: 1,
        priceStart: parseFloat(this.product.info.price),
        price: this.productPrice,
        variant: this.variant,
        variants: this.product.attributes
      }
      this.product.attributes.forEach(function (elem) {
        elem.touched = true
        if (elem.selected === '') {
          context.validForm = true
        }
      })
      if (!this.$v.$invalid && this.product.attributes.length === 0 || !this.validForm) {
        this.addToCart(item)
      }
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
    },
    showCurrentSlide () {
      this.currentSlide = this.$refs.slick.currentSlide()
    }
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
    'app-select': Select,
    'app-preview': Preview,
    'app-slick': Slick
  },
  mixins: [scrollMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.page-product
  .container-inner
    // padding-top: 92px
    // padding-bottom: 70px
    padding-top: 4.792vw
    padding-bottom: 3.646vw

.page-product__category
  // margin-bottom: 42px
  margin-bottom: 2.188vw
  font-family: $font-cormorant
  // font-size: 20px
  font-size: 1.042vw
  font-weight: 700
  line-height: 1
  // letter-spacing: 3.1px
  letter-spacing: 0.161vw
  text-transform: uppercase
  color: $color-text
  transition: color 0.3s
  &:hover
    color: $color-brown
    text-decoration: none

.page-product__slider
  // width: 1160px
  // height: 560px
  // margin-bottom: 69px
  width: 60.417vw
  height: 29.167vw
  margin-bottom: 3.594vw

.page-product__descr
  // width: 719px
  width: 37.448vw

.page-product__subtitle,
.page-product__text
  padding-right: 0

.page-product__form
  // width: 360px
  width: 18.750vw

.page-product__form-title
  // margin-bottom: 22px
  margin-bottom: 1.146vw

.page-product__select-wrapper
  position: relative
  // margin-bottom: 19px
  margin-bottom: 0.990vw
  &.invalid
    .select__toggle
      border: 1px solid red

.page-product__error-text
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

@media(max-width: 1199px)
  .page-product
    .container-inner
      padding-top: calc(92px / #{$lose-m})
      padding-bottom: calc(70px / #{$lose-m})

  .page-product__category
    margin-bottom: calc(42px / #{$lose-m})
    font-size: calc(20px / #{$lose-m})
    letter-spacing: calc(3.1px / #{$lose-m})

  .page-product__slider
    width: calc(1160px / #{$lose-m})
    height: calc(560px / #{$lose-m})
    margin-bottom: calc(69px / #{$lose-m})

  .page-product__descr
    width: calc(719px / #{$lose-m})

  .page-product__form
    width: calc(360px / #{$lose-m})

  .page-product__form-title
    margin-bottom: calc(22px / #{$lose-m})

  .page-product__select-wrapper
    margin-bottom: calc(19px / #{$lose-m} * 1.3)

  .page-product__error-text
    font-size: calc(14px / #{$lose-m})

@media(max-width: 991px)
  .page-product
    .container-inner
      padding-top: calc(92px / #{$lose-s})
      padding-bottom: calc(70px / #{$lose-s})

  .page-product__category
    margin-bottom: calc(42px / #{$lose-s})
    font-size: calc(20px / #{$lose-s})
    letter-spacing: calc(3.1px / #{$lose-s})

  .page-product__slider
    width: calc(1160px / #{$lose-s})
    height: calc(560px / #{$lose-s})
    margin-bottom: calc(69px / #{$lose-s})

  .page-product__descr
    width: calc(719px / #{$lose-s})

  .page-product__form
    width: calc(360px / #{$lose-s})

  .page-product__form-title
    margin-bottom: calc(22px / #{$lose-s})

  .page-product__select-wrapper
    margin-bottom: calc(19px / #{$lose-s} * 1.3)

  .page-product__error-text
    font-size: calc(14px / #{$lose-s})

@media(max-width: 767px)
  .page-product
    .container-inner
      padding-top: calc(92px / #{$lose-xs})
      padding-bottom: calc(70px / #{$lose-xs})

  .page-product__category
    margin-bottom: calc(42px / #{$lose-xs})
    font-size: calc(20px / #{$lose-xs})
    letter-spacing: calc(3.1px / #{$lose-xs})

  .page-product__slider
    width: calc(1160px / #{$lose-xs})
    height: calc(560px / #{$lose-xs})
    margin-bottom: calc(69px / #{$lose-xs})

  .page-product__descr
    width: calc(719px / #{$lose-xs})

  .page-product__form
    width: calc(360px / #{$lose-xs})

  .page-product__form-title
    margin-bottom: calc(22px / #{$lose-xs})

  .page-product__select-wrapper
    margin-bottom: calc(19px / #{$lose-xs} * 1.3)

  .page-product__error-text
    font-size: calc(14px / #{$lose-xs})

  .page-product__submit
    width: calc(360px / #{$lose-xs})
    height: calc(80px / #{$lose-xs})
    font-size: calc(18px / #{$lose-xs})
    line-height: calc(80px / #{$lose-xs})

@media(max-width: 575px)
  .page-product
    .container-main
      padding: 0
    .container-inner
      padding-top: calc(4.792vw * #{$gain-xs} / 1.5)
      padding-bottom: calc(3.646vw * #{$gain-xs} / 2)
      padding-left: 15px
      padding-right: 15px

  .page-product__category
    margin-bottom: calc(2.188vw * #{$gain-xs})
    font-size: calc(1.042vw * #{$gain-xs} * 1.3)
    letter-spacing: calc(0.161vw * #{$gain-xs})

  .page-product__slider
    width: calc(100vw - 30px)
    height: calc((100vw - 30px) * 48.28 / 100)
    margin-bottom: calc(3.594vw * #{$gain-xs} / 1.5)

  .page-product__descr
    width: 100%

  .page-product__form
    width: 100%
    margin-bottom: calc(3.594vw * #{$gain-xs} / 1.5)

  .page-product__form-title
    margin-bottom: calc(1.146vw * #{$gain-xs} * 1.5)

  .page-product__select-wrapper
    margin-bottom: calc(0.990vw * #{$gain-xs} * 1.7)

  .page-product__error-text
    font-size: calc(0.729vw * #{$gain-xs} * 1.5)

  .page-product__submit
    width: 100%
    height: calc(4.167vw * #{$gain-xs} * 1.2)
    font-size: calc(0.938vw * #{$gain-xs} * 1.3)
    line-height: calc(4.167vw * #{$gain-xs} * 1.2)

</style>
