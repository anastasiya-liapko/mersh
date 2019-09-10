<template>
  <div class="popup order modal fade"
    :id="id"
    tabindex="-1"
    role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <button type="button" class="close d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
          <span class="icon-close d-flex align-items-center justify-content-center" aria-hidden="true"></span>
        </button>
        <form class="popup-form d-flex flex-column align-items-center justify-content-center">
          <h2 class="popup-form__title">Изготовление на заказ</h2>

          <div class="popup-form__field d-flex flex-wrap align-items-center justify-content-between">
            <label class="popup-form__label mb-0">Имя</label>
            <input class="popup-form__input"
              :class="{invalid: $v.data.name.$error}"
              type="text"
              name="name"
              placeholder="Иван Петров"
              @blur="$v.data.name.$touch()"
              v-model="data.name">
            <p class="popup-form__error-text"
              v-if="$v.data.name.$error">Укажите имя</p>
          </div>

          <div class="popup-form__field d-flex flex-wrap align-items-center justify-content-between">
            <label class="popup-form__label mb-0">Телефон</label>
            <input class="popup-form__input"
              :class="{invalid: $v.data.phone.$error}"
              type="text"
              name="phone"
              placeholder="+ 7 (ххх) ххх хх хх"
              v-mask="'+9 (999) 999-99-99'"
              @blur="$v.data.phone.$touch()"
              v-model="data.phone">
            <transition name="fade">
              <p class="popup-form__error-text"
                v-if="!$v.data.phone.required && $v.data.phone.$dirty">
                Укажите телефон или email
              </p>
              <p class="popup-form__error-text"
                v-if="!$v.data.phone.minLength">
                Введите телефон в формате + 7 (ххх) ххх хх хх
              </p>
            </transition>
          </div>

          <div class="popup-form__field d-flex flex-wrap align-items-center justify-content-between">
            <label class="popup-form__label mb-0">Email</label>
            <input class="popup-form__input"
              :class="{invalid: $v.data.email.$error}"
              type="text"
              name="email"
              placeholder="mersh@site.com"
              @blur="$v.data.email.$touch()"
              v-model="data.email">
            <transition name="fade">
              <p class="popup-form__error-text"
                v-if="!$v.data.email.required && $v.data.email.$dirty">
                Укажите телефон или email
              </p>
              <p class="popup-form__error-text"
                v-if="!$v.data.email.email">
                Введите email в формате mersh@site.com
              </p>
            </transition>
          </div>

          <div class="popup-form__field d-flex flex-wrap align-items-center justify-content-between">
            <label class="popup-form__label mb-0">Сообщение</label>
            <textarea class="popup-form__textarea"
              :class="{invalid: $v.data.message.$error}"
              type="text"
              name="message"
              placeholder="Текст"
              @blur="$v.data.message.$touch()"
              v-model="data.message"></textarea>
            <transition name="fade">
              <p class="popup-form__error-text"
                v-if="$v.data.message.$error">
                Укажите сообщение
              </p>
            </transition>
          </div>

          <vue-recaptcha
            class="recaptcha"
            ref="recaptcha"
            :sitekey="sitekey"
            @verify="register"
            @expired="onCaptchaExpired"
          />

          <button
              class="popup-form__submit button button_form button_submit d-flex align-items-center justify-content-center"
              data-success="Отправлено!"
              data-error="Ошибка!"
              @click.prevent="submit"
              :disabled="$v.$invalid || !recaptcha">
              <span>{{ message }}</span>
          </button>

        </form>
      </div>
    </div>
  </div>
</template>

<script>
import VueRecaptcha from 'vue-recaptcha'
import { required, minLength, email, requiredUnless } from 'vuelidate/lib/validators'
import AwesomeMask from 'awesome-mask'
import axios from 'axios'
import { domenMixin } from '@/mixins'

export default {
  data () {
    return {
      id: 'js-order',
      data: {
        name: '',
        phone: '',
        email: '',
        message: '',
        recaptchaToken: ''
      },
      message: 'Отправить',
      sitekey: process.env.VUE_APP_RECAPTCHA_TOKEN,
      recaptcha: false,
      domen: process.env.VUE_APP_DOMEN
    }
  },
  mounted () {
    this.domen = location.origin
    var self = this
    $('#' + this.id).on('hidden.bs.modal', function () {
      self.resetForm()
    })
    // $('#' + this.id).on('show.bs.modal', function () {
    //   setTimeout(function () {
    //     document.querySelector('.popup input').focus()
    //   }, 400)
    // })
  },
  validations: {
    data: {
      name: {
        required
      },
      phone: {
        required: requiredUnless('email'),
        minLength: minLength(18)
      },
      email: {
        required: requiredUnless('phone'),
        email
      },
      message: {
        required
      }
    }
  },
  methods: {
    resetForm () {
      var self = this
      Object.keys(self.data).forEach(function (key, index) {
        self.data[key] = ''
      })
      self.$v.$reset()
    },
    showMessage (value) {
      var button = document.querySelector('.order .button_submit')
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
      var self = this
      axios.post(self.domen + '/api/message/?name=' + self.data.name +
      '&phone=' + self.data.phone +
      '&email=' + self.data.email +
      '&msg=' + self.data.message)
        .then(function (response) {
          console.log(response)
          self.showMessage(1)
          self.resetForm()
          self.$refs.recaptcha.reset()
          self.recaptcha = false
          setTimeout(function () {
            $('#' + self.id).modal('hide')
          }, 1200)
        })
        .catch(function (error) {
          console.log(error)
          self.showMessage(0)
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
    'vue-recaptcha': VueRecaptcha
  },
  mixins: [domenMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.order
  .popup-form__submit
    // margin-top: 25px
    margin-top: 1.302vw

@media(max-width: 1199px)
  .order
    .popup-form__submit
      margin-top: calc(1.302vw * #{$gain-m} / 7)

@media(max-width: 575px)
  .order
    .popup-form__submit
      margin-top: calc(1.302vw * #{$gain-xs} / 7)

// // calc from viewport width 767px
// @media(max-width: 575px)
//   .order
//     .popup-form__submit
//       // margin-top: 25px
//       margin-top: calc(3.259vw / 7)
//     .recaptcha
//       // margin-top: 25px
//       margin-top: calc(3.259vw / 7)
</style>
