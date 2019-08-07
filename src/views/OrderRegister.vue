<template>
  <div class="order-register d-flex flex-column">
    <div class="container container-main d-flex flex-column flex-grow-1">
      <div class="container-inner flex-grow-1 d-flex flex-column align-items-center">

        <form class="order-register__form d-flex flex-column align-items-center justify-content-center">
          <h2 class="title order-register__title">Оформление заказа</h2>
          <p class="order-register__number">Заказ №{{ orderNumber }}</p>
          <p class="order-register__products">{{ productsNames }}</p>
          <p class="order-register__price">Сумма: {{ totalPrice }} руб.</p>

          <div class="order-register__fields">
          <div class="order-register__field d-flex flex-wrap align-items-center justify-content-between">
            <label class="order-register__label">Имя</label>
            <input class="order-register__input"
              :class="{invalid: $v.data.name.$error}"
              type="text"
              name="name"
              placeholder="Иван Петров"
              @blur="$v.data.name.$touch()"
              v-model="data.name">
            <p class="order-register__error-text"
              v-if="$v.data.name.$error">Укажите имя</p>
          </div>

          <div class="order-register__field d-flex flex-wrap align-items-center justify-content-between">
            <label class="order-register__label">Телефон</label>
            <input class="order-register__input"
              :class="{invalid: $v.data.phone.$error}"
              type="text"
              name="phone"
              placeholder="+ 7 (ххх) ххх хх хх"
              v-mask="'+9 (999) 999-99-99'"
              @blur="$v.data.phone.$touch()"
              v-model="data.phone">
            <transition name="fade">
              <p class="order-register__error-text"
                v-if="!$v.data.phone.required && $v.data.phone.$dirty">
                Укажите телефон или email
              </p>
              <p class="order-register__error-text"
                v-if="!$v.data.phone.minLength">
                Введите телефон в формате + 7 (ххх) ххх хх хх
              </p>
            </transition>
          </div>

          <div class="order-register__field d-flex flex-wrap align-items-center justify-content-between">
            <label class="order-register__label">Email</label>
            <input class="order-register__input"
              :class="{invalid: $v.data.email.$error}"
              type="text"
              name="email"
              placeholder="mersh@site.com"
              @blur="$v.data.email.$touch()"
              v-model="data.email">
            <transition name="fade">
              <p class="order-register__error-text"
                v-if="!$v.data.email.email">
                Введите email в формате mersh@site.com
              </p>
            </transition>
          </div>

          <div class="order-register__select-wrapper select-wrapper d-flex flex-wrap align-items-center justify-content-between"
            :class="{invalid: !$v.data.delivery.required && $v.data.delivery.$invalid && touchDelivery}">
            <label class="order-register__label">Способ доставки</label>
            <app-select
              :id="'js-selectDelivery'"
              class="order-register__select select select_type_register"
              :show="selectShow && selectName === 'delivery'"
              :name="'delivery'"
              :placeholder="'Курьер'"
              :options="deliveryTypes"
              :selected="data.delivery"
              v-on:updateOption="select">
            </app-select>
            <transition name="fade">
              <p class="order-register__error-text order-register__error-text_type_select"
                v-if="!$v.data.delivery.required && $v.data.delivery.$invalid && touchDelivery">
                Укажите способ доставки
              </p>
            </transition>
          </div>

          <div class="order-register__field d-flex flex-wrap align-items-center justify-content-between">
            <label class="order-register__label">Адрес</label>
            <input class="order-register__input"
              :class="{invalid: $v.data.address.$error}"
              type="text"
              name="address"
              placeholder="Улица"
              @blur="$v.data.address.$touch()"
              v-model="data.address">
            <p class="order-register__error-text"
              v-if="$v.data.address.$error">Укажите адрес</p>
          </div>

          <div class="order-register__select-wrapper select-wrapper d-flex flex-wrap align-items-center justify-content-between"
            :class="{invalid: !$v.data.payment.required && $v.data.payment.$invalid && touchPayment}">
            <label class="order-register__label">Способ оплаты</label>
            <app-select
              :id="'js-selectPayment'"
              class="order-register__select select select_type_register"
              :show="selectShow && selectName === 'payment'"
              :name="'payment'"
              :placeholder="'Наличные'"
              :options="selectPayment"
              :selected="data.payment"
              v-on:updateOption="select">
            </app-select>
            <transition name="fade">
              <p class="order-register__error-text order-register__error-text_type_select"
                v-if="!$v.data.payment.required && $v.data.payment.$invalid && touchPayment">
                Укажите cпособ оплаты
              </p>
            </transition>
          </div>

          <div class="order-register__field d-flex flex-wrap align-items-center justify-content-between">
            <label class="order-register__label">Сообщение</label>
            <textarea class="order-register__textarea"
              type="text"
              name="message"
              placeholder="Текст"
              v-model="data.message"></textarea>
          </div>

          <p-check class="order-register__checkbox p-icon" v-model="checkboxPrivacy">
            <i class="icon fas fa-check d-flex align-items-center justify-content-center" slot="extra"></i>
            <p class="order-register__checkbox-descr d-flex flex-wrap mb-0">
            Я согласен с&nbsp;
            <router-link class="order-register__link"
              tag="a"
              :to="{ name: 'privacy' }">
              политикой конфиденциальности
            </router-link>
            и даю разрешение на обработку персональных данных
            </p>
          </p-check>

          </div>

          <vue-recaptcha
            class="recaptcha"
            ref="recaptcha"
            :sitekey="sitekey"
            @verify="register"
            @expired="onCaptchaExpired"
          />

          <div class="order-register__buttons d-flex flex-column flex-sm-row align-items-center justify-content-between">
            <router-link class="order-register__cancel button button_form button_form-page order-2 order-sm-1"
              :to="{ name: 'cart' }"
              tag="a">
                Отмена
            </router-link>

            <button class="order-register__submit button button_form button_form-page button_submit order-1 order-sm-2 d-flex align-items-center justify-content-center"
              data-success="Отправлено!"
              data-error="Ошибка!"
              @click.prevent="submit"
              :disabled="$v.$invalid || !recaptcha || !checkboxPrivacy">
              <span>{{ message }}</span>
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</template>

<script>
import VueRecaptcha from 'vue-recaptcha'
import { required, minLength, email } from 'vuelidate/lib/validators'
import AwesomeMask from 'awesome-mask'
import axios from 'axios'
import { mapGetters, mapActions } from 'vuex'
import Select from '@/components/Select.vue'
import PrettyCheck from 'pretty-checkbox-vue/check'
import { scrollMixin } from '@/mixins'

export default {
  name: 'order-register',
  data () {
    return {
      id: 'js-orderRegister',
      data: {
        name: '',
        phone: '',
        email: '',
        delivery: '',
        deliveryId: '',
        address: '',
        payment: '',
        payment_type: '',
        message: '',
        recaptchaToken: ''
      },
      message: 'Отправить',
      sitekey: process.env.VUE_APP_RECAPTCHA_TOKEN,
      recaptcha: false,
      touchDelivery: false,
      touchPayment: false,
      checkboxPrivacy: false,
      domen: process.env.VUE_APP_DOMEN,
      deliveryTypes: []
    }
  },
  computed: {
    ...mapGetters([
      // 'selectDelivery',
      'selectPayment',
      'selectName',
      'selectShow',
      'totalPrice',
      'cartProducts',
      'order',
      'orderNumber'
    ]),
    productsNames () {
      var names = ''
      this.cartProducts.forEach(function (elem) {
        names += elem.name + ', '
      })
      return names
    }
  },
  created () {
    this.getDeliveryTypes()
    this.orderNumber === '' ? this.getOrderNumber() : ''
  },
  beforeDestroy () {
    this.scroll(0)
  },
  validations: {
    data: {
      name: {
        required
      },
      phone: {
        required,
        minLength: minLength(18)
      },
      email: {
        email
      },
      delivery: {
        required
      },
      address: {
        required
      },
      payment: {
        required
      }
    }
  },
  methods: {
    ...mapActions([
      'filterSelect',
      'resetSelect',
      'addDelivery',
      'setOrderNumber'
    ]),
    select (value) {
      switch (value[0]) {
        case 'delivery':
          this.data.delivery = value[1].value
          this.data.deliveryId = value[1].id
          this.touchDelivery = true
          this.addDelivery(value[1])
          break
        case 'payment':
          this.data.payment = value[1].value
          this.data.payment_type = value[1].type
          this.touchPayment = true
          this.message = value[1].value === 'Онлайн' ? 'Оплатить' : 'Отправить'
          break
      }
    },
    getOrderNumber () {
      var context = this
      axios.post(context.domen + '/api/checkout/')
        .then(res => {
          // console.log(res)
          context.setOrderNumber(res.data)
        })
        .catch(error => console.log(error))
    },
    getDeliveryTypes () {
      var context = this
      axios.get(context.domen + '/api/delivery')
        .then(res => {
          // console.log(res)
          res.data.forEach(function (elem) {
            context.deliveryTypes.push({
              id: elem.id,
              value: elem.name,
              price: elem.price
            })
          })
        })
        .catch(error => console.log(error))
    },
    resetForm () {
      var self = this
      Object.keys(self.data).forEach(function (key, index) {
        self.data[key] = ''
      })
      self.$v.$reset()
      this.touchDelivery = false
      this.touchPayment = false
      this.checkboxPrivacy = false
    },
    showMessage (value) {
      var button = document.querySelector('.order-register .button_submit')
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
    register (recaptchaToken) {
      this.recaptcha = true
      this.data.recaptchaToken = recaptchaToken
    },
    submit () {
      var context = this

      var array = {
        'id': parseInt(this.orderNumber),
        'name': this.data.name,
        'phone': this.data.phone,
        'email': this.data.email,
        'address': this.data.address,
        'msg': this.data.message,
        'payment_type': this.data.payment_type,
        'delivery_type': this.data.deliveryId,
        'products': this.order
      }

      // console.log(Array.isArray(this.order))
      // console.log(array)

      // axios.post(context.domen + '/api/order/', array)
      // .then(res => {
      //   console.log(res)
      // })
      // .catch(error => console.log(error))


      var order = JSON.stringify(context.order)
      console.log(order)

      axios.post(context.domen + '/api/order/?id=' + context.orderNumber +
      '&name=' + context.data.name +
      '&phone=' + context.data.phone +
      '&email=' + context.data.email +
      '&address=' + context.data.address +
      '&msg=' + context.data.message +
      '&payment_type=' + context.data.payment_type +
      '&delivery_type=' + context.data.deliveryId +
      '&products=' + order)
        .then(function (response) {
          console.log(response)
          context.showMessage(1)
          context.resetForm()
          context.$refs.recaptcha.reset()
          context.recaptcha = false
          context.$router.push({ name: 'order-accept' })
        })
        .catch(function (error) {
          console.log(error)
          context.showMessage(0)
        })
    },
    onCaptchaExpired () {
      this.$refs.recaptcha.reset()
      this.recaptcha = false
    }
  },
  directives: {
    'mask': AwesomeMask
  },
  components: {
    'vue-recaptcha': VueRecaptcha,
    'app-select': Select,
    'p-check': PrettyCheck
  },
  mixins: [scrollMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.order-register
  .container-inner
    // padding-top: 60px
    // padding-bottom: 127px
    padding-top: 3.125vw
    padding-bottom: 6.615vw

.order-register__form
  width: 100%
  // border: 1px solid black
  .recaptcha
    // margin-bottom: 20px
    // margin-top: 63px
    margin-bottom: 1.042vw
    margin-top: 3.281vw

.order-register__fields
  // width: 600px
  width: 31.250vw
  // border: 1px solid pink

.order-register__title
  // margin-top: 33px
  // margin-bottom: 33px
  margin-top: 1.719vw
  margin-bottom: 1.719vw

.order-register__number
  // margin-bottom: 17px
  margin-bottom: 0.885vw
  font-family: $font-montserrat
  // font-size: 31px
  font-size: 1.615vw
  font-weight: 400
  line-height: 1
  color: $color-brown

.order-register__products
  // margin-bottom: 6px
  margin-bottom: 0.313vw
  font-family: $font-montserrat
  // font-size: 20px
  font-size: 1.042vw
  font-weight: 400
  line-height: 1
  color: $color-brown

.order-register__price
  // margin-bottom: 65px
  margin-bottom: 3.385vw
  font-family: $font-montserrat
  // font-size: 20px
  font-size: 1.042vw
  font-weight: 700
  line-height: 1
  color: $color-brown

.order-register__select-wrapper
  position: relative
  // margin-left: auto
  // margin-top: 25px
  margin-top: 1.302vw
  &.invalid
    .select__toggle
      border-bottom: 1px solid red

.order-register__field
  position: relative
  width: 100%
  // margin-top: 25px
  margin-top: 1.302vw

.order-register__label,
.order-register__input,
.order-register__input::placeholder,
.order-register__descr,
.order-register__textarea,
.order-register__textarea::placeholder
  font-family: $font-montserrat
  // font-size: 18px
  font-size: 0.938vw
  font-weight: 400
  line-height: 1
  color: $color-black
  background-color: transparent

.order-register__label
  margin-bottom: 0

.order-register__descr
  line-height: normal

.order-register__input
  // width: 435px
  // padding: 25px 0
  width: 22.656vw
  padding: 1.302vw 0
  border: none
  border-bottom: 1px solid #979797
  transition: border 0.3s linear
  &.invalid
    border-bottom: 1px solid red

.order-register__textarea
  // width: 435px
  // padding: 25px 30px
  width: 22.656vw
  // height: 227px
  height: 11.823vw
  padding: 1.302vw 1.563vw
  border: 1px solid #979797
  transition: border 0.3s linear
  &.invalid
    border: 1px solid red

.order-register__checkbox
  display: flex
  flex-wrap: nowrap
  // margin-top: 30px
  margin-top: 1.563vw
  .state
    display: flex
    flex-wrap: nowrap
  .icon,
  label::before
    // width: 20px
    // height: 20px
    width: 1.042vw !important
    height: 1.042vw !important
  .icon,
  .icon::before,
  label::before
    top: 1px !important
  .icon::before
    // font-size: 10px
    font-size: 0.521vw
  label
    text-indent: 0 !important
    white-space: normal

.order-register__checkbox-descr
  display: flex
  // padding-left: 40px
  padding-left: 2.083vw
  font-family: $font-montserrat
  // font-size: 18px
  font-size: 0.938vw
  font-weight: 400
  line-height: normal
  color: $color-black

.order-register__link
  z-index: 10
  position: relative
  font-family: $font-montserrat
  // font-size: 18px
  font-size: 0.938vw
  font-weight: 400
  line-height: normal
  color: $color-black
  text-decoration: underline
  transition: opacity 0.3s
  &:hover
    color: $color-black
    opacity: 0.7

.order-register__error-text
  position: absolute
  top: 100%
  right: 0
  // width: 435px
  // margin-top: 5px
  width: 22.656vw
  margin-top: 0.260vw
  margin-bottom: 0
  font-family: $font-montserrat
  // font-size: 14px
  font-size: 0.729vw
  font-weight: 400
  line-height: 1
  color: red

.order-register__error-text_type_select
  // width: 378px
  width: 19.688vw

.fade-enter,
.fade-enter-active
  animation: fade-in 0.3s cubic-bezier(0.390, 0.575, 0.565, 1.000) both

.fade-leave,
.fade-leave-active
  animation: fade-out 0.25s ease-out both

@keyframes fade-in
  0%
    opacity: 0
  100%
    opacity: 1

@keyframes fade-out
  0%
    opacity: 1
  100%
    opacity: 0

.order-register__buttons
  // margin-top: 25px
  margin-top: 1.302vw

.order-register__cancel
  // margin-right: 40px
  margin-right: 2.083vw

@media(max-width: 1199px)
  .order-register
    .container-inner
      padding-top: calc(60px / #{$lose-m})
      padding-bottom: calc(127px / #{$lose-m})

  .order-register__form
    .recaptcha
      margin-bottom: calc(20px / #{$lose-m})
      margin-top: calc(63px / #{$lose-m})

  .order-register__fields
    width: calc(600px / #{$lose-m})

  .order-register__title
    margin-top: calc(33px / #{$lose-m})
    margin-bottom: calc(33px / #{$lose-m})

  .order-register__number
    margin-bottom: calc(17px / #{$lose-m})
    font-size: calc(31px / #{$lose-m})

  .order-register__products
    margin-bottom: calc(6px / #{$lose-m})
    font-size: calc(20px / #{$lose-m})

  .order-register__price
    margin-bottom: calc(65px / #{$lose-m})
    font-size: calc(20px / #{$lose-m})

  .order-register__select-wrapper
    margin-top: calc(25px / #{$lose-m})

  .order-register__field
    margin-top: calc(25px / #{$lose-m})

  .order-register__label,
  .order-register__input,
  .order-register__input::placeholder,
  .order-register__descr,
  .order-register__textarea,
  .order-register__textarea::placeholder
    font-size: calc(18px / #{$lose-m})

  .order-register__input
    width: calc(435px / #{$lose-m})
    padding: calc(25px / #{$lose-m}) 0

  .order-register__textarea
    width: calc(435px / #{$lose-m})
    padding: calc(25px / #{$lose-m}) calc(30px / #{$lose-m})
    height: calc(227px / #{$lose-m})

  .order-register__checkbox
    margin-top: calc(30px / #{$lose-m})
    .icon,
    label::before
      width: calc(20px / #{$lose-m}) !important
      height: calc(20px / #{$lose-m}) !important
    .icon::before
      font-size: calc(10px / #{$lose-m})

  .order-register__checkbox-descr
    padding-left: calc(40px / #{$lose-m})
    font-size: calc(18px / #{$lose-m})

  .order-register__link
    font-size: calc(18px / #{$lose-m})

  .order-register__error-text
    width: calc(435px / #{$lose-m})
    margin-top: calc(5px / #{$lose-m})
    font-size: calc(14px / #{$lose-m})

  .order-register__error-text_type_select
    width: calc(378px / #{$lose-m})

  .order-register__buttons
    margin-top: calc(25px / #{$lose-m})

  .order-register__cancel
    margin-right: calc(40px / #{$lose-m})

@media(max-width: 991px)
  .order-register
    .container-inner
      padding-top: calc(60px / #{$lose-s})
      padding-bottom: calc(127px / #{$lose-s})

  .order-register__form
    .recaptcha
      // margin-bottom: calc(20px / #{$lose-s} / 7)
      margin-bottom: 0
      margin-top: calc(63px / #{$lose-s} / 7)
      transform: scale(0.7)

  .order-register__fields
    width: calc(600px / #{$lose-s})

  .order-register__title
    margin-top: calc(33px / #{$lose-s})
    margin-bottom: calc(33px / #{$lose-s})

  .order-register__number
    margin-bottom: calc(17px / #{$lose-s})
    font-size: calc(31px / #{$lose-s})

  .order-register__products
    margin-bottom: calc(6px / #{$lose-s})
    font-size: calc(20px / #{$lose-s})

  .order-register__price
    margin-bottom: calc(65px / #{$lose-s})
    font-size: calc(20px / #{$lose-s})

  .order-register__select-wrapper
    margin-top: calc(25px / #{$lose-s})

  .order-register__field
    margin-top: calc(25px / #{$lose-s})

  .order-register__label,
  .order-register__input,
  .order-register__input::placeholder,
  .order-register__descr,
  .order-register__textarea,
  .order-register__textarea::placeholder
    font-size: calc(18px / #{$lose-s})

  .order-register__input
    width: calc(435px / #{$lose-s})
    padding: calc(25px / #{$lose-s}) 0

  .order-register__textarea
    width: calc(435px / #{$lose-s})
    padding: calc(25px / #{$lose-s}) calc(30px / #{$lose-s})
    height: calc(227px / #{$lose-s})

  .order-register__checkbox
    margin-top: calc(30px / #{$lose-s})
    .icon,
    label::before
      width: calc(20px / #{$lose-s}) !important
      height: calc(20px / #{$lose-s}) !important
    .icon::before
      font-size: calc(10px / #{$lose-s})

  .order-register__checkbox-descr
    padding-left: calc(40px / #{$lose-s})
    font-size: calc(18px / #{$lose-s})

  .order-register__link
    font-size: calc(18px / #{$lose-s})

  .order-register__error-text
    width: calc(435px / #{$lose-s})
    margin-top: calc(5px / #{$lose-s})
    font-size: calc(14px / #{$lose-s})

  .order-register__error-text_type_select
    width: calc(378px / #{$lose-s})

  .order-register__buttons
    margin-top: calc(25px / #{$lose-s})

  .order-register__cancel
    margin-right: calc(40px / #{$lose-s})

@media(max-width: 575px)
  .order-register
    .container-main
      padding: 0
    .container-inner
      padding-top: calc(3.125vw * #{$gain-xs} / 2)
      padding-bottom: calc(6.615vw * #{$gain-xs} / 2)
      padding-left: 15px
      padding-right: 15px

  .order-register__form
    .recaptcha
      margin-bottom: calc(1.042vw * #{$gain-xs})
      margin-top: calc(3.281vw * #{$gain-xs} / 1.5)
      transform: scale(0.8)

  .order-register__fields
    width: 100%

  .order-register__title
    margin-top: calc(1.719vw * #{$gain-xs})
    margin-bottom: calc(1.719vw * #{$gain-xs})

  .order-register__number
    margin-bottom: calc(0.885vw * #{$gain-xs})
    font-size: calc(1.615vw * #{$gain-xs} * 1.2)

  .order-register__products
    margin-bottom: calc(0.313vw * #{$gain-xs} * 2)
    font-size: calc(1.042vw * #{$gain-xs} * 1.3)

  .order-register__price
    margin-bottom: calc(3.385vw * #{$gain-xs} / 3)
    font-size: calc(1.042vw * #{$gain-xs} * 1.3)

  .order-register__select-wrapper
    margin-top: calc(1.302vw * #{$gain-xs})

  .order-register__field
    margin-top: calc(1.302vw * #{$gain-xs})

  .order-register__label,
  .order-register__input,
  .order-register__input::placeholder,
  .order-register__descr,
  .order-register__textarea,
  .order-register__textarea::placeholder
    font-size: calc(0.938vw * #{$gain-xs} * 1.4)

  .order-register__label
    width: 100%
    margin-top: calc(1.302vw * #{$gain-xs} * 1.5)
    margin-bottom: calc(1.302vw * #{$gain-xs})

  .order-register__input
    width: 100%
    padding: calc(1.302vw * #{$gain-xs}) 0

  .order-register__textarea
    width: 100%
    height: calc(11.823vw * #{$gain-xs})
    padding: calc(1.302vw * #{$gain-xs}) calc(1.563vw * #{$gain-xs})

  .order-register__checkbox
    margin-top: calc(1.563vw * #{$gain-xs})
    .icon,
    label::before
      width: calc(1.042vw * #{$gain-xs} * 1.5) !important
      height: calc(1.042vw * #{$gain-xs} * 1.5) !important
    .icon::before
      font-size: calc(0.521vw * #{$gain-xs} * 1.2 * 1.5)

  .order-register__checkbox-descr
    padding-left: calc(2.083vw * #{$gain-xs} * 1.5)
    font-size: calc(0.938vw * #{$gain-xs} * 1.4)

  .order-register__link
    font-size: calc(0.938vw * #{$gain-xs} * 1.4)

  .order-register__error-text
    width: 100%
    margin-top: calc(0.260vw * #{$gain-xs})
    font-size: calc(0.729vw * #{$gain-xs} * 1.4)

  .order-register__error-text_type_select
    width: 100%

  .order-register__buttons
    width: 100%
    margin-top: calc(1.302vw * #{$gain-xs})

  .order-register__cancel
    margin-right: 0
    margin-top: calc(1.302vw * #{$gain-xs})
</style>
