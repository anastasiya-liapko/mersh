<template>
  <div class="popup call modal fade"
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
          <h2 class="popup-form__title">Заказать звонок</h2>

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
              v-if="$v.data.phone.$error">Укажите телефон</p>
            </transition>
          </div>

          <button class="popup-form__submit button button_form button_submit d-flex align-items-center justify-content-center"
              data-success="Отправлено!"
              data-error="Ошибка!"
              @click.prevent="submit"
              :disabled="$v.$invalid">
              <span>{{ message }}</span>
          </button>

        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { required, minLength } from 'vuelidate/lib/validators'
import AwesomeMask from 'awesome-mask'
import axios from 'axios'
import { domenMixin } from '@/mixins'

export default {
  data () {
    return {
      id: 'js-call',
      data: {
        name: '',
        phone: ''
      },
      message: 'Отправить',
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
        required,
        minLength: minLength(18)
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
      var button = document.querySelector('.call .button_submit')
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
    submit () {
      var self = this
      axios.post(self.domen + '/api/call/?name=' + self.data.name +
      '&phone=' + self.data.phone)
        .then(function (response) {
          console.log(response)
          self.showMessage(1)
          self.resetForm()
          setTimeout(function () {
            $('#' + self.id).modal('hide')
          }, 1200)
        })
        .catch(function (error) {
          console.log(error)
          self.showMessage(0)
        })
    }
  },
  directives: {
    'mask': AwesomeMask
  },
  mixins: [domenMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.popup
  .modal-dialog
    // max-width: 735px
    // width: 735px
    max-width: 38.281vw
    width: 38.281vw
    height: auto
  .modal-content
    // padding: 68px
    padding: 3.542vw
    border: none
    border-radius: 0
  .close
    z-index: 10
    position: absolute
    top: 0
    right: 0
    // width: 68px
    // height: 68px
    width: 3.542vw
    height: 3.542vw
    text-shadow: none
    background: #e4e4e4
    opacity: 1
    transition: background .3s
    &:hover
      opacity: 1 !important
      background-color: $color-brown
      .icon-close::before
        color: $color-white
    .icon-close
      &::before
        // font-size: 17px
        font-size: 0.885vw
        transition: color .3s

.popup-form
  width: 100%
  .recaptcha
    // margin-top: 25px
    margin-top: 1.302vw

.popup-form__title
  // margin-bottom: 5px
  margin-bottom: 0.260vw
  font-family: $font-cormorant-sc
  // font-size: 24px
  font-size: 1.250vw
  font-weight: 700
  line-height: 1
  color: $color-black
  text-transform: uppercase

.popup-form__img-wrapper
  // margin-top: 42px
  // margin-bottom: 47px
  margin-top: 2.188vw
  margin-bottom: 2.448vw

.popup-form__field
  position: relative
  width: 100%
  // margin-top: 25px
  margin-top: 1.302vw

.popup-form__label,
.popup-form__input,
.popup-form__input::placeholder,
.popup-form__descr,
.popup-form__textarea,
.popup-form__textarea::placeholder
  font-family: $font-montserrat
  // font-size: 18px
  font-size: 0.938vw
  font-weight: 400
  line-height: 1
  color: $color-black
  background-color: transparent

.popup-form__descr
  line-height: normal

.popup-form__input
  // width: 435px
  // padding: 25px 0
  width: 22.656vw
  padding: 1.302vw 0
  border: none
  border-bottom: 1px solid #979797
  transition: border 0.3s linear
  &.invalid
    border-bottom: 1px solid red

.popup-form__textarea
  // width: 435px
  // padding: 25px 30px
  width: 22.656vw
  // height: 209px
  height: 10.885vw
  padding: 1.302vw 1.563vw
  border: 1px solid #979797
  transition: border 0.3s linear
  &.invalid
    border: 1px solid red

.popup-form__error-text
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

.popup-form__submit
  // margin-top: 25px
  margin-top: 1.302vw

.call
  .popup-form__submit
    // margin-top: 65px
    margin-top: 3.385vw

@media(max-width: 991px)
  .popup
    .modal-dialog
      max-width: calc(38.281vw * #{$gain-m})
      width: calc(38.281vw * #{$gain-m})
    .modal-content
      padding: calc(3.542vw * #{$gain-m})
    .close
      width: calc(3.542vw * #{$gain-m})
      height: calc(3.542vw * #{$gain-m})
      .icon-close
        &::before
          font-size: calc(0.885vw * #{$gain-m})

  .popup-form
    .recaptcha
      margin-top: calc(1.302vw * #{$gain-m} / 7)
      transform: scale(0.7)

  .popup-form__title
    margin-bottom: calc(0.260vw * #{$gain-m})
    font-size: calc(1.250vw * #{$gain-m})

  .popup-form__img-wrapper
    margin-top: calc(2.188vw * #{$gain-m})
    margin-bottom: calc(2.448vw * #{$gain-m})

  .popup-form__field
    margin-top: calc(1.302vw * #{$gain-m})

  .popup-form__label,
  .popup-form__input,
  .popup-form__input::placeholder,
  .popup-form__descr,
  .popup-form__textarea,
  .popup-form__textarea::placeholder
    font-size: calc(0.938vw * #{$gain-m})

  .popup-form__input
    width: calc(22.656vw * #{$gain-m})
    padding: calc(1.302vw * #{$gain-m}) 0

  .popup-form__textarea
    width: calc(22.656vw * #{$gain-m})
    height: calc(10.885vw * #{$gain-m})
    padding: calc(1.302vw * #{$gain-m}) calc(1.563vw * #{$gain-m})

  .popup-form__error-text
    width: calc(22.656vw * #{$gain-m})
    margin-top: calc(0.260vw * #{$gain-m})
    font-size: calc(0.729vw * #{$gain-m})

  .popup-form__submit
    margin-top: calc(1.302vw * #{$gain-m})

  .call
    .popup-form__submit
      margin-top: calc(3.385vw * #{$gain-m})

@media(max-width: 575px)
  .popup
    .modal-dialog
      max-width: calc(38.281vw * #{$gain-xs})
      width: calc(38.281vw * #{$gain-xs})
      margin: auto
    .modal-content
      padding: calc(3.542vw * #{$gain-xs})
    .close
      width: calc(3.542vw * #{$gain-xs})
      height: calc(3.542vw * #{$gain-xs})
      .icon-close
        &::before
          font-size: calc(0.885vw * #{$gain-xs} * 1.2)

  .popup-form
    .recaptcha
      margin-top: calc(1.302vw * #{$gain-xs} / 7)

  .popup-form__title
    margin-bottom: calc(0.260vw * #{$gain-xs})
    font-size: calc(1.250vw * #{$gain-xs} * 1.2)

  .popup-form__img-wrapper
    margin-top: calc(2.188vw * #{$gain-xs})
    margin-bottom: calc(2.448vw * #{$gain-xs})

  .popup-form__field
    margin-top: calc(1.302vw * #{$gain-xs})

  .popup-form__label,
  .popup-form__input,
  .popup-form__input::placeholder,
  .popup-form__descr,
  .popup-form__textarea,
  .popup-form__textarea::placeholder
    font-size: calc(0.938vw * #{$gain-xs} * 1.2)

  .popup-form__input
    width: calc(22.656vw * #{$gain-xs})
    padding: calc(1.302vw * #{$gain-xs}) 0

  .popup-form__textarea
    width: calc(22.656vw * #{$gain-xs})
    height: calc(10.885vw * #{$gain-xs})
    padding: calc(1.302vw * #{$gain-xs}) calc(1.563vw * #{$gain-xs})

  .popup-form__error-text
    width: calc(22.656vw * #{$gain-xs})
    margin-top: calc(0.260vw * #{$gain-xs})
    font-size: calc(0.729vw * #{$gain-xs} * 1.1)

  .popup-form__submit
    margin-top: calc(1.302vw * #{$gain-xs})

  .call
    .popup-form__submit
      margin-top: calc(3.385vw * #{$gain-xs})

// @media(max-width: 575px)
//   .popup
//     .modal-dialog
//       // max-width: 735px
//       // width: 735px
//       max-width: 100%
//       width: 95.828vw
//     .modal-content
//       // padding: 68px
//       padding: 8.866vw
//     .close
//       // width: 68px
//       // height: 68px
//       width: 8.866vw
//       height: 8.866vw
//       .icon-close
//         &::before
//           // font-size: 17px
//           font-size: calc(2.216vw * 1.2)

//   .popup-form__title
//     // margin-bottom: 5px
//     // font-size: 24px
//     margin-bottom: 0.652vw
//     font-size: calc(3.129vw * 1.2)

//   .popup-form__img-wrapper
//     // margin-top: 42px
//     // margin-bottom: 47px
//     margin-top: 5.476vw
//     margin-bottom: 6.128vw

//   .popup-form__field
//     // margin-top: 25px
//     margin-top: 3.259vw

//   .popup-form__label,
//   .popup-form__input,
//   .popup-form__input::placeholder,
//   .popup-form__descr,
//   .popup-form__textarea,
//   .popup-form__textarea::placeholder
//     // font-size: 18px
//     font-size: calc(2.347vw * 1.2)

//   .popup-form__input
//     // width: 435px
//     // padding: 25px 0
//     width: 56.714vw
//     padding: 3.259vw 0

//   .popup-form__textarea
//     // width: 435px
//     // padding: 25px 30px
//     width: 56.714vw
//     padding: 3.259vw 3.911vw

//   .popup-form__error-text
//     // width: 435px
//     // margin-top: 5px
//     // font-size: 14px
//     width: 56.714vw
//     margin-top: calc(0.652vw / 2)
//     font-size: calc(1.825vw * 1.1)

//   .popup-form__submit
//     // margin-top: 25px
//     margin-top: 3.259vw

//   .call
//     .popup-form__submit
//       // margin-top: 65px
//       margin-top: 8.475vw
</style>
