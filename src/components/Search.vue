<template>
  <transition name="slide-bottom">
  <div class="search"
    :id="id"
    v-show="showPopup && popupId === id">
    <div class="container">
      <div class="search__inner d-flex justify-content-center align-items-center">
        <form class="search__form d-flex justify-content-center align-items-center"
          id="js-formSearch">
            <input class="search__form-input flex-grow-1"
              type="text"
              name="search"
              placeholder="Поиск"
              @blur="$v.data.search.$touch()"
              v-model="data.search"
              ref="input">
            <button class="search__form-submit d-flex justify-content-center align-items-center"
              type="submit"
              :disabled="$v.$invalid"
              @click.prevent="submit">
              <span class="icon-search-small d-flex justify-content-center align-items-center"></span>
            </button>
        </form>
      </div>
    </div>
  </div>
  </transition>
</template>

<script>
import { hideMixin } from '@/mixins'
import { mapGetters, mapActions } from 'vuex'
import { required, minLength } from 'vuelidate/lib/validators'
import axios from 'axios'

export default {
  data () {
    return {
      id: 'js-search',
      data: {
        search: ''
      }
    }
  },
  computed: {
    ...mapGetters([
      // 'products',
      'showPopup',
      'popupId'
    ])
  },
  methods: {
    ...mapActions({
      'hidePopup': 'hidePopup'
      // 'switchShowPopup': 'switchShowPopup'
    }),
    submit () {
      var self = this
      axios.post('/post.php', self.data)
        .then(function (response) {
          console.log(response)
          self.hidePopup()
          self.$router.push({ name: 'search', params: { name: self.data.search } })
          setTimeout(function () {
            self.data.search = ''
          }, 500)
        })
        .catch(function (error) {
          console.log(error)
          self.hidePopup()
          self.$router.push({ name: 'search', params: { name: self.data.search } })
          setTimeout(function () {
            self.data.search = ''
          }, 500)
        })
    },
    hide (e) {
      var search = document.querySelector('#js-search .search__inner')
      var searchButton = document.getElementById('js-searchOpen')

      if (!search.contains(e.target) && !searchButton.contains(e.target)) {
        this.hidePopup(this.id)
      }
    }
  },
  validations: {
    data: {
      search: {
        required,
        minLength: minLength(3)
      }
    }
  },
  mixins: [hideMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.search
  position: absolute
  top: 100%
  left: 0
  right: 0
  .container
    // padding: 0 117px
    padding: 0 6.094vw
    transition: padding 0.3s linear

.search__inner
  width: 100%
  // padding-top: 36px
  // padding-bottom: 36px
  padding-top: 1.875vw
  padding-bottom: 1.875vw
  background-color: $color-nav

.slide-bottom-enter,
.slide-bottom-enter-active
  animation: swing-in-top-fwd 0.5s cubic-bezier(0.175, 0.885, 0.320, 1.275) both

.slide-bottom-leave,
.slide-bottom-leave-active
  animation: swing-out-top-bck 0.45s cubic-bezier(0.600, -0.280, 0.735, 0.045) both

@keyframes swing-in-top-fwd
  0%
    transform: rotateX(-100deg)
    transform-origin: top
    opacity: 0
  100%
    transform: rotateX(0deg)
    transform-origin: top
    opacity: 1

@keyframes swing-out-top-bck
  0%
    transform: rotateX(0deg)
    transform-origin: top
    opacity: 1
  100%
    transform: rotateX(-100deg)
    transform-origin: top
    opacity: 0

.search__form
  width: 85.8%
  border-bottom: 1px solid rgba(0, 0, 0, 0.35)
  .icon-search-small
    &::before
      // font-size: 20px
      font-size: 1.042vw
      color: $color-black

.search__form-input
  // padding: 13px 0
  padding: 0.677vw 0
  font-family: $font-montserrat
  // font-size: 20px
  font-size: 1.042vw
  line-height: 1
  font-weight: 400
  color: $color-black
  background-color: transparent
  border: none
  &::placeholder
    // font-size: 20px
    font-size: 1.042vw
    line-height: 1
    font-weight: 400
    color: $color-black

.search__form-submit
  // padding: 13px
  padding: 0.677vw
  background-color: transparent
  border: 0
  &:disabled
    opacity: 0.5

@media(max-width: 1199px)
  .search
    .container
      padding: 0 15px

  .search__inner
    padding-top: calc(36px / #{$lose-m})
    padding-bottom: calc(calc(36px / #{$lose-m})

  .search__form
    .icon-search-small
      &::before
        font-size: calc(20px / #{$lose-m})

  .search__form-input
    padding: calc(13px / #{$lose-m}) 0
    font-size: calc(20px / #{$lose-m})
    &::placeholder
      font-size: calc(20px / #{$lose-m})

  .search__form-submit
    padding: calc(13px / #{$lose-m})

@media(max-width: 991px)
  .search__inner
    padding-top: calc(36px / #{$lose-s})
    padding-bottom: calc(calc(36px / #{$lose-s})

  .search__form
    .icon-search-small
      &::before
        font-size: calc(20px / #{$lose-s})

  .search__form-input
    padding: calc(13px / #{$lose-s}) 0
    font-size: calc(20px / #{$lose-s})
    &::placeholder
      font-size: calc(20px / #{$lose-s})

  .search__form-submit
    padding: calc(13px / #{$lose-s})

@media(max-width: 767px)
  .search__inner
    padding-top: calc(36px / #{$lose-xs})
    padding-bottom: calc(calc(36px / #{$lose-xs})

  .search__form
    .icon-search-small
      &::before
        font-size: calc(20px / #{$lose-xs})

  .search__form-input
    padding: calc(13px / #{$lose-xs}) 0
    font-size: calc(20px / #{$lose-xs})
    &::placeholder
      font-size: calc(20px / #{$lose-xs})

  .search__form-submit
    padding: calc(13px / #{$lose-xs})

@media(max-width: 575px)
  .search
    .container
      padding: 0

  .search__inner
    padding-top: calc(1.875vw * #{$gain-xs})
    padding-bottom: calc(1.875vw * #{$gain-xs})
    padding-left: 15px
    padding-right: 15px

  .search__form
    width: 100%
    .icon-search-small
      &::before
        font-size: calc(1.042vw * #{$gain-xs} * 1.4)

  .search__form-input
    padding: calc(0.677vw * #{$gain-xs}) 0
    font-size: calc(1.042vw * #{$gain-xs} * 1.4)
    &::placeholder
      font-size: calc(1.042vw * #{$gain-xs} * 1.4)

  .search__form-submit
    padding: calc(0.677vw * #{$gain-xs})
</style>
