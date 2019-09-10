<template>
  <div id="js-header" class="header">

    <app-banner-content></app-banner-content>

    <div class="container container-main d-flex justify-content-between align-items-center">
      <div class="hamburger d-flex align-items-center">
        <button
          id="js-navOpen"
          class="hamburger__button"
          type="button"
          @click="toggleNav">
          <span class="hamburger__icon icon-burger d-flex align-items-center justify-content-center"></span>
        </button>
      </div>

      <router-link class="header__logo d-flex align-items-center justify-content-center"
        :to="{name: 'index'}"
        tag="a">
        <!-- <img src="../assets/img/logo-white.svg" alt="logo"> -->
        <svg class="svg-logo svg-logo_location_header" xmlns="http://www.w3.org/2000/svg" width="277" height="52" viewBox="0 0 277 52">
          <g fill="none" fill-rule="evenodd">
              <path class="svg-logo__path" fill="#FFF" d="M0 49.97h7.734V2.961H0V2h15.678L28.57 38.974h.14L41.6 2H57v.962h-7.735V49.97H57v.963H34.562v-.963h7.735V3.375h-.14L25.505 51 8.919 3.856H8.78v46.113h7.735v.963H0v-.963M66 50.036h7.825V2.964H66V2h40.321v11.906h-.775c-.611-1.79-1.27-3.36-1.974-4.714-.705-1.353-1.55-2.5-2.538-3.441-.986-.94-2.162-1.64-3.524-2.1-1.364-.457-3.008-.687-4.935-.687H80.874v21.265h4.582c1.55 0 2.866-.138 3.947-.413a6.051 6.051 0 0 0 2.784-1.548c.776-.757 1.433-1.79 1.975-3.097.539-1.308 1.068-2.994 1.585-5.058h.776v21.403h-.776c-.33-1.33-.67-2.616-1.022-3.855-.352-1.238-.846-2.34-1.48-3.303-.635-.964-1.48-1.731-2.538-2.305-1.057-.573-2.432-.86-4.123-.86h-5.71v24.843h13.323c2.583 0 4.734-.538 6.45-1.617 1.715-1.077 3.112-2.362 4.194-3.854 1.08-1.49 1.879-3.039 2.397-4.645.516-1.605.845-2.935.986-3.992H109V51H66v-.964"/>
              <path d="M121.375.389h93.424v51.588h-93.424z"/>
              <path class="svg-logo__path" fill="#FFF" d="M136.141 24.012h6.438c1.306 0 2.496-.161 3.57-.485a6.228 6.228 0 0 0 2.764-1.697c.77-.808 1.364-1.905 1.784-3.29.42-1.386.63-3.14.63-5.266 0-2.4-.315-4.33-.944-5.784-.63-1.455-1.448-2.552-2.45-3.29a8.119 8.119 0 0 0-3.36-1.456 20.036 20.036 0 0 0-3.673-.346c-.84 0-1.692.012-2.555.035-.863.024-1.598.081-2.204.173v21.406zm-14.766 25.979h7.768V2.606h-7.768v-.97h13.296a39.446 39.446 0 0 0 3.36-.139c.56 0 1.12-.01 1.68-.034.559-.023 1.119-.035 1.679-.035 2.752 0 5.178.15 7.278.45 2.1.301 4.059 1.167 5.879 2.598 1.632 1.248 2.787 2.657 3.463 4.226.676 1.57 1.015 3.048 1.015 4.434 0 .693-.13 1.582-.385 2.667-.256 1.086-.816 2.194-1.68 3.325-.863 1.132-2.11 2.172-3.743 3.118-1.634.947-3.803 1.582-6.509 1.905v.138c.746.094 1.76.266 3.044.52 1.283.254 2.59.682 3.92 1.281 1.329.601 2.554 1.398 3.673 2.39 1.12.994 1.913 2.276 2.38 3.846.28.924.477 1.974.595 3.151.115 1.178.21 2.39.28 3.638.07 1.246.14 2.448.21 3.602.07 1.155.197 2.125.384 2.91.28 1.2.723 2.286 1.33 3.255.606.97 1.586 1.455 2.94 1.455.605 0 1.235-.114 1.889-.346.652-.23 1.235-.6 1.75-1.109l.63.762a14.87 14.87 0 0 1-.806.59 5.894 5.894 0 0 1-1.154.588c-.467.184-1.04.335-1.715.45-.677.115-1.505.174-2.485.174-1.865 0-3.418-.232-4.653-.693-1.237-.461-2.228-1.143-2.974-2.044-.747-.9-1.294-2.01-1.645-3.325-.35-1.316-.595-2.851-.735-4.607l-.49-6.304c-.186-2.309-.653-4.11-1.4-5.404-.746-1.292-1.62-2.24-2.623-2.84-1.004-.6-2.041-.958-3.115-1.074a26.797 26.797 0 0 0-2.799-.173h-6.998V49.99h7.768v.97h-22.534v-.97zM179.248 36.066h.77c.513 2.494 1.178 4.596 1.995 6.304.815 1.71 1.714 3.118 2.694 4.226.98 1.109 2.005 1.964 3.08 2.564 1.072.6 2.156 1.038 3.253 1.316 1.096.277 2.146.439 3.15.485 1.002.045 1.947.069 2.834.069 2.472 0 4.501-.37 6.088-1.109 1.586-.738 2.845-1.673 3.78-2.805.932-1.131 1.584-2.356 1.959-3.672.373-1.316.56-2.529.56-3.637 0-1.616-.305-3.001-.91-4.156a10.03 10.03 0 0 0-2.31-2.945 13.026 13.026 0 0 0-3.044-1.974 21.257 21.257 0 0 0-3.114-1.178l-8.048-2.424c-3.779-1.154-6.637-2.678-8.573-4.573-1.936-1.893-2.904-4.433-2.904-7.62 0-2.078.373-4.006 1.12-5.785a13.538 13.538 0 0 1 3.149-4.606c1.353-1.293 2.974-2.31 4.864-3.049C191.53.76 193.594.39 195.834.39c1.633 0 2.997.138 4.094.416 1.096.277 2.04.588 2.834.935.793.346 1.505.658 2.135.935.63.277 1.27.416 1.924.416.606 0 1.015-.08 1.225-.243.21-.16.5-.565.874-1.212h.98v12.539h-.84a20.496 20.496 0 0 0-1.434-4.815c-.677-1.546-1.552-2.91-2.624-4.087-1.074-1.178-2.369-2.124-3.884-2.84-1.517-.716-3.279-1.074-5.284-1.074-1.12 0-2.356.15-3.709.45-1.354.301-2.614.82-3.78 1.559a9.4 9.4 0 0 0-2.903 2.91c-.77 1.201-1.155 2.725-1.155 4.572 0 1.478.303 2.736.91 3.775a8.764 8.764 0 0 0 2.344 2.633c.956.716 2.03 1.316 3.22 1.801 1.189.485 2.39.913 3.603 1.282l8.468 2.632c.886.277 2.005.648 3.36 1.108 1.352.463 2.67 1.155 3.953 2.079 1.283.924 2.38 2.148 3.29 3.672.909 1.524 1.364 3.463 1.364 5.819a15.99 15.99 0 0 1-1.225 6.2 15.505 15.505 0 0 1-3.534 5.196c-1.54 1.501-3.406 2.701-5.598 3.602-2.194.9-4.666 1.351-7.418 1.351-.98 0-1.844-.012-2.59-.035a19.584 19.584 0 0 1-2.1-.173 62.192 62.192 0 0 1-1.958-.312 20.945 20.945 0 0 1-2.17-.52c-.934-.276-1.937-.599-3.01-.97-1.073-.368-2.006-.554-2.798-.554-.7 0-1.18.14-1.435.416-.257.278-.479.647-.665 1.109h-1.05V36.066M224 50.036h7.792V2.964H224V2h22.604v.964h-7.792v22.504h23.376V2.964h-7.792V2H277v.964h-7.792v47.072H277V51h-22.604v-.964h7.792V26.431h-23.376v23.605h7.792V51H224v-.964"/>
          </g>
        </svg>
      </router-link>

      <div class="info d-flex flex-wrap justify-content-end">

        <div id="js-callOpen"
          class="info__call icon-3d-wrapper d-flex flex-nowrap justify-content-end align-items-center"
          data-toggle="modal"
          data-target="#js-call">
          <div class="info__call-text-wrapper icon-3d-text d-none d-lg-flex flex-column justify-content-between h-100">
            <span class="info__text">Заказать звонок</span>
            <span class="info__text info__text_font-weight_bold">{{ phone }}</span>
          </div>
          <span class="info__icon info__icon_type_call icon-phone icon-3d d-flex justify-content-center align-items-center"></span>
          <!-- <span class="info__icon info__icon_type_call d-flex justify-content-center align-items-center">
            <svg id="svgPhone" xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25">
              <g fill="#fff" fill-rule="evenodd" stroke="#fff" stroke-width="0">
                  <path d="M20.743 3.256A11.046 11.046 0 0 0 12.881 0a.881.881 0 1 0 0 1.762c2.5 0 4.85.973 6.616 2.74a9.295 9.295 0 0 1 2.741 6.617.881.881 0 0 0 1.762 0c0-2.97-1.156-5.762-3.257-7.863z"/>
                  <path d="M17.208 11.104a.896.896 0 1 0 1.792 0A6.112 6.112 0 0 0 12.896 5a.896.896 0 0 0 0 1.793 4.317 4.317 0 0 1 4.312 4.31zM15.249 15.804c-1.335-.069-2.016.924-2.342 1.401a.876.876 0 1 0 1.446.99c.386-.564.56-.653.797-.641.758.089 3.745 2.277 4.044 2.961.075.202.072.4-.009.64-.313.93-.832 1.584-1.5 1.89-.636.292-1.415.265-2.252-.076-3.128-1.274-5.86-3.054-8.122-5.288l-.003-.002c-2.229-2.26-4.005-4.988-5.277-8.111-.341-.839-.368-1.618-.077-2.253.307-.668.96-1.187 1.89-1.5.242-.081.439-.084.638-.01.687.3 2.875 3.287 2.964 4.036.012.246-.077.42-.64.805a.876.876 0 1 0 .988 1.447c.477-.326 1.47-1.004 1.401-2.344-.076-1.4-2.798-5.106-4.1-5.585-.578-.215-1.186-.219-1.809-.01-1.4.472-2.411 1.312-2.924 2.431-.498 1.086-.482 2.345.046 3.643 1.362 3.342 3.268 6.267 5.664 8.692a.632.632 0 0 0 .018.018c2.424 2.391 5.344 4.294 8.682 5.654a5.197 5.197 0 0 0 1.956.408c.593 0 1.16-.12 1.686-.362 1.12-.513 1.96-1.524 2.432-2.925.208-.621.205-1.23-.009-1.806-.48-1.304-4.186-4.026-5.588-4.103z"/>
                  <animate attributeName="stroke-width" to="1.5" dur="0.5s" repeatCount="1" begin="svgPhone.mouseenter" fill="freeze"/>
                  <animate attributeName="stroke-width" to="0" dur="0.5s" repeatCount="1" begin="svgPhone.mouseleave" fill="freeze"/>
              </g>
            </svg>
          </span> -->
        </div>

        <div id="js-searchOpen"
          class="info__search icon-3d-wrapper d-flex flex-nowrap justify-content-end align-items-center"
          @click="switchShowPopup('js-search')">
          <span class="info__text info__text_type_call icon-3d-text info__text_font-weight_medium d-none d-lg-flex">Поиск</span>
          <span class="info__icon info__icon_type_search icon-search icon-3d d-flex justify-content-center align-items-center"></span>
          <!-- <span class="info__icon info__icon_type_search d-flex justify-content-center align-items-center">
            <svg id="svgSearch" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30">
              <path fill="#FFF" fill-rule="evenodd" stroke="#fff" stroke-width="0"
               d="M21.406 18.828L30 27.422 27.422 30l-8.516-8.594v-1.328l-.547-.469c-2.083 1.771-4.505 2.657-7.265 2.657-3.073 0-5.69-1.081-7.852-3.243C1.081 16.862 0 14.245 0 11.172c0-3.073 1.08-5.703 3.242-7.89C5.404 1.093 7.995 0 11.016 0c3.073 0 5.69 1.094 7.851 3.281C21.03 5.47 22.11 8.1 22.11 11.171c0 2.761-.885 5.183-2.656 7.267l.547.39h1.406zm-15.274-1.96C7.604 18.289 9.381 19 11.462 19s3.858-.723 5.33-2.17S19 13.62 19 11.538c0-2.081-.736-3.858-2.208-5.33C15.32 4.736 13.543 4 11.462 4s-3.845.736-5.292 2.208C4.723 7.68 4 9.457 4 11.538s.71 3.858 2.132 5.33z">
                <animate attributeName="stroke-width" to="1.5" dur="0.5s" repeatCount="1" begin="svgSearch.mouseenter" fill="freeze"/>
                <animate attributeName="stroke-width" to="0" dur="0.5s" repeatCount="1" begin="svgSearch.mouseleave" fill="freeze"/>
              </path>
            </svg>
          </span> -->
        </div>

        <a href="#" class="info__cart icon-3d-wrapper d-flex flex-nowrap justify-content-end align-items-center"
          @click="showCart"
          :class="{'disabled': totalQuantity === 0}">
          <div v-if="totalQuantity !== 0" class="info__cart-text-wrapper_small icon-3d-text justify-content-center align-items-center">
            <span class="info__text info__text_font-weight_bold">{{ totalQuantity }}</span>
          </div>
          <div class="info__cart-text-wrapper icon-3d-text d-none d-lg-flex flex-column justify-content-between align-items-end h-100">
            <span id="js-cartPrice" class="info__text info__text_font-weight_bold">{{ totalPrice }} руб.</span>
            <span id="js-cartQuantity" class="info__text info__text_font-weight_bold">{{ totalQuantity }} ед.</span>
          </div>
          <span class="info__icon info__icon_type_cart icon-cart icon-3d d-flex justify-content-center align-items-center"></span>
          <!-- <span class="info__icon info__icon_type_cart d-flex justify-content-center align-items-center">
            <svg id="svgCart" xmlns="http://www.w3.org/2000/svg" width="33" height="36" viewBox="0 0 33 36">
              <path fill="#FFF" fill-rule="nonzero" stroke="#fff" stroke-width="0"
              d="M9.405 23.703h19.566c2.22 0 4.029-1.835 4.029-4.084v-8.346-.03-.058c0-.015 0-.03-.007-.045 0-.015-.008-.037-.008-.052 0-.014-.007-.03-.007-.044-.007-.015-.007-.03-.014-.052-.008-.015-.008-.03-.015-.044-.007-.015-.007-.03-.015-.045a.363.363 0 0 1-.022-.051c-.007-.015-.014-.03-.021-.037l-.022-.045c-.008-.015-.015-.022-.022-.037-.008-.015-.022-.03-.03-.044a.13.13 0 0 0-.029-.037c-.007-.015-.022-.022-.029-.037-.007-.015-.022-.022-.029-.037-.007-.015-.022-.022-.03-.03l-.036-.037c-.014-.007-.022-.022-.036-.03-.015-.007-.03-.021-.044-.029-.015-.007-.022-.015-.036-.022a.153.153 0 0 1-.044-.03l-.044-.022-.044-.022-.044-.022c-.014-.008-.029-.008-.043-.015a.134.134 0 0 0-.052-.015c-.014 0-.029-.007-.036-.007-.022-.008-.036-.008-.058-.008-.008 0-.015-.007-.03-.007L7.354 6.812V3.305c0-.037 0-.074-.007-.104 0-.007 0-.014-.007-.03 0-.021-.008-.044-.008-.066-.007-.022-.007-.037-.014-.059 0-.015-.008-.022-.008-.037l-.021-.067c0-.007-.008-.022-.008-.03a.223.223 0 0 0-.029-.058c-.007-.008-.007-.023-.015-.03a.155.155 0 0 0-.029-.044c-.007-.015-.014-.023-.022-.037-.007-.015-.014-.023-.021-.037-.008-.015-.022-.03-.03-.045l-.022-.022-.043-.044-.022-.023a.319.319 0 0 0-.051-.044l-.03-.022c-.014-.015-.029-.022-.043-.037a.672.672 0 0 0-.059-.037c-.007-.008-.014-.008-.022-.015-.029-.015-.065-.03-.094-.044L1.369.079A.98.98 0 0 0 .079.612c-.212.51.022 1.095.525 1.31l4.773 2.041V25.85c0 2.072 1.533 3.788 3.51 4.047a4.077 4.077 0 0 0-.568 2.072c0 2.227 1.788 4.032 3.977 4.032 2.19 0 3.978-1.813 3.978-4.032 0-.74-.197-1.443-.548-2.035h8.86c-.35.6-.547 1.295-.547 2.035 0 2.227 1.788 4.032 3.977 4.032 2.19 0 3.978-1.813 3.978-4.032 0-2.22-1.788-4.033-3.978-4.033H9.405c-1.138 0-2.058-.94-2.058-2.086V23.14a4.032 4.032 0 0 0 2.058.562zm4.904 8.257c0 1.125-.905 2.035-2.007 2.035s-2.007-.918-2.007-2.035.905-2.034 2.007-2.034 2.007.91 2.007 2.034zm15.72 0c0 1.125-.904 2.035-2.006 2.035-1.102 0-2.007-.918-2.007-2.035s.905-2.034 2.007-2.034 2.007.91 2.007 2.034zm-1.058-10.254H9.405c-1.138 0-2.058-.94-2.058-2.087V8.824l23.682 3.308v7.48c0 1.161-.926 2.094-2.058 2.094z">
              <animate attributeName="stroke-width" to="1.5" dur="0.5s" repeatCount="1" begin="svgCart.mouseenter" fill="freeze"/>
              <animate attributeName="stroke-width" to="0" dur="0.5s" repeatCount="1" begin="svgCart.mouseleave" fill="freeze"/></path>
            </svg>
          </span> -->
        </a>

      </div>
    </div>

    <app-search></app-search>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters, mapActions } from 'vuex'
import BannerContent from '@/components/BannerContent.vue'
import Search from '@/components/Search.vue'
import { domenMixin } from '@/mixins'

export default {
  data () {
    return {
      phone: '',
      domen: process.env.VUE_APP_DOMEN
    }
  },
  computed: {
    ...mapGetters([
      'totalPrice',
      'totalQuantity'
    ])
  },
  created: function () {
    this.domen = location.origin
    this.fetch()
    window.addEventListener('scroll', this.stickHeader)
  },
  beforeDestroy () {
    window.removeventListener('scroll', this.stickHeader)
  },
  methods: {
    ...mapActions({
      'switchShowNav': 'switchShowNav',
      'switchShowPopup': 'switchShowPopup'
    }),
    fetch () {
      var context = this

      axios.get(context.domen + '/api/info/contacts')
        .then(res => {
          // console.log(res)
          context.phone = res.data.phone
        })
        .catch(error => console.log(error))
    },
    toggleNav () {
      var app = document.getElementById('app')
      app.classList.toggle('fixed')
      this.switchShowNav()
    },
    showCart () {
      this.totalQuantity === 0 ? '' : this.$router.push({ name: 'cart' })
    },
    stickHeader () {
      var header = document.getElementById('js-header')
      var scrolled = window.pageYOffset
      scrolled > 1 ? header.classList.add('sticky') : header.classList.remove('sticky')
    }
  },
  components: {
    'app-banner-content': BannerContent,
    'app-search': Search
  },
  mixins: [domenMixin]
}
</script>

<style lang="sass">
@import '@/sass/_fonts.sass'
@import '@/sass/_variables.sass'
.header
  z-index: 50
  position: relative
  width: 100%
  color: $color-white
  background-color: transparent
  // box-shadow: 0px 10px 32px -3px transparent
  box-shadow: 0vw 0.521vw 1.667vw -0.156vw transparent
  // transition: background-color 0.3s linear, box-shadow 0.3s linear
  &>.container
    // padding: 48px 117px
    padding: 2.500vw 6.094vw
    transition: padding 0.3s linear
  &.sticky
    position: fixed
    background-color: #FFF
    // box-shadow: 0px 10px 32px -3px rgba(55,16,5,0.75)
    box-shadow: 0vw 0.521vw 1.667vw -0.156vw rgba(55,16,5,0.75)
    & .banner_content
      display: none
    & .info
      flex-wrap: nowrap !important
    .info__text,
    .info__icon::before
      text-shadow: none
    & .info__call
      margin-bottom: 0
    & .info__call,
    & .info__search,
    & .info__cart
      min-width: auto
      width: auto
      &:hover
        .info__cart-text-wrapper_small
          .info__text
            color: $color-white
    & .info__call-text-wrapper,
    & .info__text_type_call,
    & .info__cart-text-wrapper
      display: none !important
    &>.container
      padding: calc(2.500vw / 4) 6.094vw
    & .info__icon_type_call::before
      font-size: calc(1.198vw * 1.4)
    & .info__icon::before,
    & .hamburger__icon::before
      text-shadow: none
      color: $color-brown
    & .svg-logo_location_header
        .svg-logo__path
          fill: $color-brown
    .info__cart-text-wrapper_small
      display: flex
      background-color: $color-brown
      .info__text
        color: $color-white

.header_index
  position: absolute
  top: 0
  left: 0
  .banner_content
    display: none

.hamburger
  width: 30%
  height: auto

.hamburger__button
  transition: opacity 0.3s linear
  &:hover
    opacity: 0.7
  // &:hover
  //   .hamburger__icon::before
  //     font-weight: 700

.hamburger__button,
.hamburger__icon
  // width: 30px
  // height: 30px
  width: 1.563vw
  height: 1.563vw
  padding: 0
  background-color: transparent
  border: none

.hamburger__icon::before
  // font-size: 30px
  font-size: 1.563vw
  text-shadow: 1px 1px 2px black
  // transition: color 0.3s linear

.header__logo
  // width: 277px
  // height: 53px
  width: 14.427vw
  height: 2.760vw
  &:hover
    cursor: pointer

.info
  // min-height: 50px
  width: 30%

.info__text
  font-family: $font-montserrat
  // font-size: 14px
  font-size: 0.729vw
  line-height: 1
  font-weight: 400
  text-shadow: 1px 1px 2px black
  color: $color-white
  white-space: nowrap

.info__text_font-weight_medium
  font-weight: 500

.info__text_font-weight_bold
  font-weight: 700

.info__icon
  // width: 35px
  // height: 35px
  // margin-left: 18px
  width: 1.823vw
  height: 1.823vw
  margin-left: 0.938vw
  &::before
    text-shadow: 1px 1px 2px black
    // transition: color 0.3s linear

.info__icon_type_call::before
  // font-size: 23px
  font-size: 1.198vw

.info__icon_type_search::before
  // font-size: 30px
  font-size: 1.563vw

.info__icon_type_cart::before
  // font-size: 33px
  font-size: 1.719vw

.info__call
  width: 100%
  // margin-bottom: 30px
  margin-bottom: 1.563vw

.info__search
  // width: 50%

.info__cart
  position: relative
  min-width: 50%
  // width: 50%

.info__call,
.info__search,
.info__cart
  transition: opacity 0.3s linear
  &:hover
    text-decoration: none
    opacity: 0.7
    cursor: pointer
    .info__text
      color: $color-white
    .info__cart-text-wrapper_small
      .info__text
        color: $color-brown
  &.disabled
    &:hover
      cursor: default
      opacity: 1

.info__cart-text-wrapper_small
  position: absolute
  // top: -10px
  // right: -15px
  top: -0.521vw
  right: -0.781vw
  display: none
  // width: 26px
  // height: 26px
  width: 1.354vw
  height: 1.354vw
  background-color: $color-white
  border-radius: 50%
  .info__text
    color: $color-brown

.svg-logo
  .svg-logo__path
    // transition: fill 0.3s linear

.svg-logo_location_nav
  .svg-logo__path
    fill: $color-brown

.svg-logo_location_header
  .svg-logo__path
    stroke: black
    stroke-width: 0.5px
    // box-shadow: -5px -5px 5px black
    filter: drop-shadow( 5px 5px 5px black )

@media(max-width: 1199px)
  .header
    box-shadow: 0vw calc(0.521vw * #{$gain-m}) calc(1.667vw * #{$gain-m}) calc(-0.156vw * #{$gain-m}) transparent
    &>.container
      padding: calc(2.500vw * #{$gain-m} / 2) 15px
    &.sticky
      box-shadow: 0vw calc(0.521vw * #{$gain-m}) calc(1.667vw * #{$gain-m}) calc(-0.156vw * #{$gain-m}) rgba(55,16,5,0.75)
      &>.container
        padding: calc(2.500vw * #{$gain-m} / 4) 15px
      & .info__icon_type_call::before
        font-size: calc(1.198vw * #{$gain-m} * 1.4)

  .hamburger__button,
  .hamburger__icon
    width: calc(1.563vw * #{$gain-m})
    height: calc(1.563vw * #{$gain-m})

  .hamburger__icon::before
    font-size: calc(1.563vw * #{$gain-m})

  .header__logo
    width: calc(14.427vw * #{$gain-m})
    height: calc(2.760vw * #{$gain-m})

  .info__text
    font-size: calc(0.729vw * #{$gain-m})

  .info__icon
    width: calc(1.823vw * #{$gain-m})
    height: calc(1.823vw * #{$gain-m})
    margin-left: calc(0.938vw * #{$gain-m})

  .info__icon_type_call::before
    font-size: calc(1.198vw * #{$gain-m})

  .info__icon_type_search::before
    font-size: calc(1.563vw * #{$gain-m})

  .info__icon_type_cart::before
    font-size: calc(1.719vw * #{$gain-m})

  .info__call
    margin-bottom: calc(1.563vw * #{$gain-m})

  .info__cart-text-wrapper_small
    top: calc(-0.521vw * #{$gain-m})
    right: calc(-0.781vw * #{$gain-m})
    width: calc(1.354vw * #{$gain-m})
    height: calc(1.354vw * #{$gain-m})

@media(max-width: 991px)
  .hamburger,
  .info
    width: 30%

  .info__call,
  .info__search,
  .info__cart
    min-width: auto
    width: auto

  .info__cart-text-wrapper_small
    display: flex

  .header
    box-shadow: 0vw calc(0.521vw * #{$gain-s}) calc(1.667vw * #{$gain-s}) calc(-0.156vw * #{$gain-s}) transparent
    &>.container
      padding: calc(2.500vw * #{$gain-s} / 2) 15px
    &.sticky
      box-shadow: 0vw calc(0.521vw * #{$gain-s}) calc(1.667vw * #{$gain-s}) calc(-0.156vw * #{$gain-s}) rgba(55,16,5,0.75)
      &>.container
        padding: calc(2.500vw * #{$gain-s} / 4) 15px
      & .info__icon_type_call::before
        font-size: calc(1.198vw * #{$gain-s} * 1.4)

  .hamburger__button,
  .hamburger__icon
    width: calc(1.563vw * #{$gain-s})
    height: calc(1.563vw * #{$gain-s})

  .hamburger__icon::before
    font-size: calc(1.563vw * #{$gain-s})

  .header__logo
    width: calc(14.427vw * #{$gain-s})
    height: calc(2.760vw * #{$gain-s})

  .info__text
    font-size: calc(0.729vw * #{$gain-s})

  .info__icon
    width: calc(1.823vw * #{$gain-s})
    height: calc(1.823vw * #{$gain-s})
    margin-left: calc(0.938vw * #{$gain-s})

  .info__icon_type_call::before
    font-size: calc(1.198vw * #{$gain-s} * 1.4)

  .info__icon_type_search::before
    font-size: calc(1.563vw * #{$gain-s})

  .info__icon_type_cart::before
    font-size: calc(1.719vw * #{$gain-s})

  .info__call
    margin-bottom: 0

  .info__cart-text-wrapper_small
    top: calc(-0.521vw * #{$gain-s})
    right: calc(-0.781vw * #{$gain-s})
    width: calc(1.354vw * #{$gain-s})
    height: calc(1.354vw * #{$gain-s})

@media(max-width: 767px)
  .hamburger,
  .info
    width: 40%

  .header
    box-shadow: 0vw calc(0.521vw * #{$gain-xs}) calc(1.667vw * #{$gain-xs}) calc(-0.156vw * #{$gain-xs}) transparent
    &>.container
      padding: calc(2.500vw * #{$gain-xs} / 2) 15px
    &.sticky
      box-shadow: 0vw calc(0.521vw * #{$gain-xs}) calc(1.667vw * #{$gain-xs}) calc(-0.156vw * #{$gain-xs}) rgba(55,16,5,0.75)
      &>.container
        padding: calc(2.500vw * #{$gain-xs} / 2) 15px
      & .info__icon_type_call::before
        font-size: calc(1.198vw * #{$gain-xs} * 1.4)

  .hamburger__button,
  .hamburger__icon
    width: calc(1.563vw * #{$gain-xs})
    height: calc(1.563vw * #{$gain-xs})

  .hamburger__icon::before
    font-size: calc(1.563vw * #{$gain-xs})

  .header__logo
    width: calc(14.427vw * #{$gain-xs} / 1.3)
    height: calc(2.760vw * #{$gain-xs} / 1.3)

  .info__text
    font-size: calc(0.729vw * #{$gain-xs})

  .info__icon
    width: calc(1.823vw * #{$gain-xs})
    height: calc(1.823vw * #{$gain-xs})
    margin-left: calc(0.938vw * #{$gain-xs})

  .info__icon_type_call::before
    font-size: calc(1.198vw * #{$gain-xs} * 1.4)

  .info__icon_type_search::before
    font-size: calc(1.563vw * #{$gain-xs})

  .info__icon_type_cart::before
    font-size: calc(1.719vw * #{$gain-xs})

  .info__cart-text-wrapper_small
    top: calc(-0.521vw * #{$gain-xs})
    right: calc(-0.781vw * #{$gain-xs})
    width: calc(1.354vw * #{$gain-xs})
    height: calc(1.354vw * #{$gain-xs})

@media(max-width: 575px)
  .hamburger,
  .info
    width: 30%

  .header
    &.sticky
      & .info__icon_type_call::before
        font-size: calc(1.198vw * #{$gain-xs} * 1.4 * 1.3)

  .hamburger__button,
  .hamburger__icon
    width: calc(1.563vw * #{$gain-xs} * 1.5)
    height: calc(1.563vw * #{$gain-xs} * 1.5)

  .hamburger__icon::before
    font-size: calc(1.563vw * #{$gain-xs} * 1.5)

  .header__logo
    width: calc(14.427vw * #{$gain-xs})
    height: calc(2.760vw * #{$gain-xs})

  .info__icon
    width: calc(1.823vw * #{$gain-xs} * 1.3)
    height: calc(1.823vw * #{$gain-xs} * 1.3)

  .info__icon_type_call::before
    font-size: calc(1.198vw * #{$gain-xs} * 1.4 * 1.3)

  .info__icon_type_search::before
    font-size: calc(1.563vw * #{$gain-xs} * 1.3)

  .info__icon_type_cart::before
    font-size: calc(1.719vw * #{$gain-xs} * 1.3)

</style>
