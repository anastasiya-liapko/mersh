<template>
  <div class="privacy contacts d-flex flex-column">

    <div class="container container-main d-flex flex-grow-1">
      <div class="container-inner">

        <h2 class="title privacy__title text-center">{{ contacts.title }}</h2>
        <!-- <p class="subtitle privacy__subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor</p> -->
        <div class="text privacy__text" v-html="contacts.txt"></div>

        <div class="contacts__data d-flex flex-column flex-sm-row align-items-sm-center justify-content-start">
          <div v-if="contacts.address !== ''" class="contacts__data-item contacts__data-item_type_address d-flex align-items-center justify-content-start">
            <span class="contacts__data-icon contacts__data-icon_type_address icon icon-map d-flex align-items-center justify-content-center"></span>
            <span class="contacts__data-text">{{ contacts.address }}</span>
          </div>

          <a v-if="contacts.phone !== ''" :href="'tel:' + phoneCall" class="contacts__data-item contacts__data-item_type_phone d-flex align-items-center justify-content-start">
            <span class="contacts__data-icon contacts__data-icon_type_phone icon icon-telephone d-flex align-items-center justify-content-center"></span>
            <span class="contacts__data-text">{{ contacts.phone }}</span>
          </a>

          <a v-if="contacts.email !== ''" :href="'mailto:' + contacts.email" class="contacts__data-item contacts__data-item_type_mail d-flex align-items-center justify-content-start">
            <span class="contacts__data-icon contacts__data-icon_type_mail icon icon-mail d-flex align-items-center justify-content-center"></span>
            <span class="contacts__data-text">{{ contacts.email }}</span>
          </a>
        </div>

        <div v-if="contacts.map_img !== ''" class="contacts__map">
          <img :src="contacts.map_img" alt="">
        </div>

      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios'
import { scrollMixin } from '@/mixins'

export default {
  name: 'contacts',
  data () {
    return {
      contacts: '',
      domen: process.env.VUE_APP_DOMEN
    }
  },
  computed: {
    phoneCall () {
      if (this.contacts.phone) {
        return this.contacts.phone.split(' ').join('')
      }
    }
  },
  created () {
    this.fetch()
  },
  beforeDestroy () {
    this.scroll(0)
  },
  methods: {
    fetch () {
      var context = this

      axios.get(context.domen + '/api/info/contacts')
        .then(res => {
          console.log(res)
          context.contacts = res.data
        })
        .catch(error => console.log(error))
    }
  },
  mixins: [scrollMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.contacts__data
  // margin-top: 55px
  // margin-bottom: 39px
  margin-top: 2.865vw
  margin-bottom: 2.031vw

.contacts__data-item
  // margin-right: 55px
  margin-right: 2.865vw
  transition: opacity 0.3s
  &:hover
    text-decoration: none
    opacity: 0.7

.contacts__data-icon
  // margin-right: 25px
  margin-right: 1.302vw
  &::before
    // font-size: 30px
    font-size: 1.563vw
    color: $color-brown

.contacts__data-text
  font-family: $font-cormorant
  // font-size: 24px
  font-size: 1.250vw
  font-weight: 700
  line-height: 1
  color: $color-brown

.contacts__map
  position: relative
  &::before
    content: ''
    position: absolute
    top: 50%
    left: 50%
    // width: 91px
    // height: 91px
    // margin-top: -45.5px
    // margin-left: -45.5px
    width: 4.740vw
    height: 4.740vw
    margin-top: -2.370vw
    margin-left: -2.370vw
    background-image: url(../assets/img/map-pin.png)
    background-position: center
    background-size: cover
    background-repeat: no-repeat

@media(max-width: 1199px)
  .contacts__data
    margin-top: calc(55px / #{$lose-m})
    margin-bottom: calc(39px / #{$lose-m})

  .contacts__data-item
    margin-right: calc(55px / #{$lose-m})

  .contacts__data-icon
    margin-right: calc(25px / #{$lose-m})
    &::before
      font-size: calc(30px / #{$lose-m})

  .contacts__data-text
    font-size: calc(24px / #{$lose-m})

  .contacts__map
    &::before
      width: calc(91px / #{$lose-m})
      height: calc(91px / #{$lose-m})
      margin-top: calc(-45.5px / #{$lose-m})
      margin-left: calc(-45.5px / #{$lose-m})

@media(max-width: 991px)
  .contacts__data
    margin-top: calc(55px / #{$lose-s})
    margin-bottom: calc(39px / #{$lose-s})

  .contacts__data-item
    margin-right: calc(55px / #{$lose-s})

  .contacts__data-icon
    margin-right: calc(25px / #{$lose-s})
    &::before
      font-size: calc(30px / #{$lose-s})

  .contacts__data-text
    font-size: calc(24px / #{$lose-s})

  .contacts__map
    &::before
      width: calc(91px / #{$lose-s})
      height: calc(91px / #{$lose-s})
      margin-top: calc(-45.5px / #{$lose-s})
      margin-left: calc(-45.5px / #{$lose-s})

@media(max-width: 767px)
  .contacts__data
    margin-top: calc(55px / #{$lose-xs})
    margin-bottom: calc(39px / #{$lose-xs})

  .contacts__data-item
    margin-right: calc(55px / #{$lose-xs})

  .contacts__data-icon
    margin-right: calc(25px / #{$lose-xs})
    &::before
      font-size: calc(30px / #{$lose-xs} * 1.1)

  .contacts__data-text
    font-size: calc(24px / #{$lose-xs} * 1.1)

  .contacts__map
    &::before
      width: calc(91px / #{$lose-xs})
      height: calc(91px / #{$lose-xs})
      margin-top: calc(-45.5px / #{$lose-xs})
      margin-left: calc(-45.5px / #{$lose-xs})

@media(max-width: 575px)
  .contacts
    .container-inner
      padding-top: calc(0.625vw * #{$gain-xs} / 1.5)
      padding-bottom: calc(5.990vw * #{$gain-xs} / 1.5)

  .contacts__data
    margin-top: calc(2.865vw * #{$gain-xs})
    margin-bottom: calc(2.031vw * #{$gain-xs})

  .contacts__data-item
    margin-right: calc(2.865vw * #{$gain-xs})
    margin-bottom: calc(2.865vw * #{$gain-xs} / 3)
    &:last-child
      margin-bottom: 0

  .contacts__data-icon
    margin-right: calc(1.302vw * #{$gain-xs})
    &::before
      font-size: calc(1.563vw * #{$gain-xs} * 1.1)

  .contacts__data-text
    font-size: calc(1.250vw * #{$gain-xs} * 1.3)

  .contacts__map
    &::before
      width: calc(4.740vw * #{$gain-xs})
      height: calc(4.740vw * #{$gain-xs})
      margin-top: calc(-2.370vw * #{$gain-xs})
      margin-left: calc(-2.370vw * #{$gain-xs})

</style>
