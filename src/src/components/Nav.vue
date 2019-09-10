<template>
  <transition name="slide-left">
    <div
      id="js-nav"
      class="header__nav nav"
      v-show="showNav">
      <div class="nav__header d-flex justify-content-start align-items-center">
        <div class="nav__close-wrapper d-flex align-items-end">
          <button
            id="js-navClose"
            class="nav__close d-flex justify-content-between align-items-center"
            @click="toggleNav">
            <span class="nav__close-icon icon-left-arrow d-flex justify-content-start align-items-center"></span>
            <!-- <img src="../assets/img/logo-orange.svg" class="nav__close-logo" alt="logo"> -->
            <svg class="nav__close-logo svg-logo svg-logo_location_nav" xmlns="http://www.w3.org/2000/svg" width="277" height="52" viewBox="0 0 277 52">
              <g fill="none" fill-rule="evenodd" >
                <path class="svg-logo__path" fill="#371005" d="M0 49.97h7.734V2.961H0V2h15.678L28.57 38.974h.14L41.6 2H57v.962h-7.735V49.97H57v.963H34.562v-.963h7.735V3.375h-.14L25.505 51 8.919 3.856H8.78v46.113h7.735v.963H0v-.963M66 50.036h7.825V2.964H66V2h40.321v11.906h-.775c-.611-1.79-1.27-3.36-1.974-4.714-.705-1.353-1.55-2.5-2.538-3.441-.986-.94-2.162-1.64-3.524-2.1-1.364-.457-3.008-.687-4.935-.687H80.874v21.265h4.582c1.55 0 2.866-.138 3.947-.413a6.051 6.051 0 0 0 2.784-1.548c.776-.757 1.433-1.79 1.975-3.097.539-1.308 1.068-2.994 1.585-5.058h.776v21.403h-.776c-.33-1.33-.67-2.616-1.022-3.855-.352-1.238-.846-2.34-1.48-3.303-.635-.964-1.48-1.731-2.538-2.305-1.057-.573-2.432-.86-4.123-.86h-5.71v24.843h13.323c2.583 0 4.734-.538 6.45-1.617 1.715-1.077 3.112-2.362 4.194-3.854 1.08-1.49 1.879-3.039 2.397-4.645.516-1.605.845-2.935.986-3.992H109V51H66v-.964"/>
                <!-- <path d="M121.375.389h93.424v51.588h-93.424z"/> -->
                <path class="svg-logo__path" fill="#371005" d="M136.141 24.012h6.438c1.306 0 2.496-.161 3.57-.485a6.228 6.228 0 0 0 2.764-1.697c.77-.808 1.364-1.905 1.784-3.29.42-1.386.63-3.14.63-5.266 0-2.4-.315-4.33-.944-5.784-.63-1.455-1.448-2.552-2.45-3.29a8.119 8.119 0 0 0-3.36-1.456 20.036 20.036 0 0 0-3.673-.346c-.84 0-1.692.012-2.555.035-.863.024-1.598.081-2.204.173v21.406zm-14.766 25.979h7.768V2.606h-7.768v-.97h13.296a39.446 39.446 0 0 0 3.36-.139c.56 0 1.12-.01 1.68-.034.559-.023 1.119-.035 1.679-.035 2.752 0 5.178.15 7.278.45 2.1.301 4.059 1.167 5.879 2.598 1.632 1.248 2.787 2.657 3.463 4.226.676 1.57 1.015 3.048 1.015 4.434 0 .693-.13 1.582-.385 2.667-.256 1.086-.816 2.194-1.68 3.325-.863 1.132-2.11 2.172-3.743 3.118-1.634.947-3.803 1.582-6.509 1.905v.138c.746.094 1.76.266 3.044.52 1.283.254 2.59.682 3.92 1.281 1.329.601 2.554 1.398 3.673 2.39 1.12.994 1.913 2.276 2.38 3.846.28.924.477 1.974.595 3.151.115 1.178.21 2.39.28 3.638.07 1.246.14 2.448.21 3.602.07 1.155.197 2.125.384 2.91.28 1.2.723 2.286 1.33 3.255.606.97 1.586 1.455 2.94 1.455.605 0 1.235-.114 1.889-.346.652-.23 1.235-.6 1.75-1.109l.63.762a14.87 14.87 0 0 1-.806.59 5.894 5.894 0 0 1-1.154.588c-.467.184-1.04.335-1.715.45-.677.115-1.505.174-2.485.174-1.865 0-3.418-.232-4.653-.693-1.237-.461-2.228-1.143-2.974-2.044-.747-.9-1.294-2.01-1.645-3.325-.35-1.316-.595-2.851-.735-4.607l-.49-6.304c-.186-2.309-.653-4.11-1.4-5.404-.746-1.292-1.62-2.24-2.623-2.84-1.004-.6-2.041-.958-3.115-1.074a26.797 26.797 0 0 0-2.799-.173h-6.998V49.99h7.768v.97h-22.534v-.97zM179.248 36.066h.77c.513 2.494 1.178 4.596 1.995 6.304.815 1.71 1.714 3.118 2.694 4.226.98 1.109 2.005 1.964 3.08 2.564 1.072.6 2.156 1.038 3.253 1.316 1.096.277 2.146.439 3.15.485 1.002.045 1.947.069 2.834.069 2.472 0 4.501-.37 6.088-1.109 1.586-.738 2.845-1.673 3.78-2.805.932-1.131 1.584-2.356 1.959-3.672.373-1.316.56-2.529.56-3.637 0-1.616-.305-3.001-.91-4.156a10.03 10.03 0 0 0-2.31-2.945 13.026 13.026 0 0 0-3.044-1.974 21.257 21.257 0 0 0-3.114-1.178l-8.048-2.424c-3.779-1.154-6.637-2.678-8.573-4.573-1.936-1.893-2.904-4.433-2.904-7.62 0-2.078.373-4.006 1.12-5.785a13.538 13.538 0 0 1 3.149-4.606c1.353-1.293 2.974-2.31 4.864-3.049C191.53.76 193.594.39 195.834.39c1.633 0 2.997.138 4.094.416 1.096.277 2.04.588 2.834.935.793.346 1.505.658 2.135.935.63.277 1.27.416 1.924.416.606 0 1.015-.08 1.225-.243.21-.16.5-.565.874-1.212h.98v12.539h-.84a20.496 20.496 0 0 0-1.434-4.815c-.677-1.546-1.552-2.91-2.624-4.087-1.074-1.178-2.369-2.124-3.884-2.84-1.517-.716-3.279-1.074-5.284-1.074-1.12 0-2.356.15-3.709.45-1.354.301-2.614.82-3.78 1.559a9.4 9.4 0 0 0-2.903 2.91c-.77 1.201-1.155 2.725-1.155 4.572 0 1.478.303 2.736.91 3.775a8.764 8.764 0 0 0 2.344 2.633c.956.716 2.03 1.316 3.22 1.801 1.189.485 2.39.913 3.603 1.282l8.468 2.632c.886.277 2.005.648 3.36 1.108 1.352.463 2.67 1.155 3.953 2.079 1.283.924 2.38 2.148 3.29 3.672.909 1.524 1.364 3.463 1.364 5.819a15.99 15.99 0 0 1-1.225 6.2 15.505 15.505 0 0 1-3.534 5.196c-1.54 1.501-3.406 2.701-5.598 3.602-2.194.9-4.666 1.351-7.418 1.351-.98 0-1.844-.012-2.59-.035a19.584 19.584 0 0 1-2.1-.173 62.192 62.192 0 0 1-1.958-.312 20.945 20.945 0 0 1-2.17-.52c-.934-.276-1.937-.599-3.01-.97-1.073-.368-2.006-.554-2.798-.554-.7 0-1.18.14-1.435.416-.257.278-.479.647-.665 1.109h-1.05V36.066M224 50.036h7.792V2.964H224V2h22.604v.964h-7.792v22.504h23.376V2.964h-7.792V2H277v.964h-7.792v47.072H277V51h-22.604v-.964h7.792V26.431h-23.376v23.605h7.792V51H224v-.964"/>
              </g>
            </svg>
          </button>
        </div>
      </div>

      <transition-group
        name="nav-transition-group"
        tag="ul"
        class="nav__list">
        <transition-group
          name="nav-transition-group"
          tag="li"
          class="nav__list-item nav-transition-group__item position-relative"
          v-for="(navItem) in nav"
          v-bind:key="navItem.id">
          <a href="#"
            :id="'js-nav__list-link-' + navItem.id"
            class="nav__list-link nav-transition-group__item d-inline-block"
            v-bind:key="'nav__list-link-' + navItem.id"
            :data-toggle="navItem.name === 'Изготовление на заказ' ? 'modal' : ''"
            :data-target="navItem.name === 'Изготовление на заказ' ? '#js-order' : ''"
            @click="toggleDropdown(navItem)">
            <span class="hover-mersh d-flex flex-nowrap"
              :class="{'hover-mersh_type_dropdown': navItem.childs}"
              :data-length="navItem.name.split('').length"
              @mouseenter="hoverMershAddDelay"
              @mouseleave="hoverMershRemoveDelay">
              <span
                class="hover-mersh__word d-flex"
                v-for="(word, wordIndex) in navItem.name.split(' ')"
                v-bind:key="word + '-' + wordIndex">
                  <span
                    class="hover-mersh__letter"
                    v-for="(letter, letterIndex) in word.split('')"
                    v-bind:key="letter + '-' + letterIndex">
                    {{ letter }}
                  </span>
                  &nbsp;
              </span>
              <span
                class="hover-mersh__letter hover-mersh__dropdown"
                :class="{'open': showDropdownById === navItem.id}"
                v-if="navItem.childs"></span>
            </span>
          </a>

          <ul class="nav__dropdown nav-transition-group__item w-100"
              v-if="showDropdownById === navItem.id && navItem.childs"
              v-bind:key="'nav__dropdown-' + navItem.id">
              <li
                  class="nav__dropdown-item d-flex"
                  v-for="(dropdownItem, i) in navItem.childs"
                  v-bind:key="navItem.id + i">
                  <!-- <router-link class="nav__dropdown-link d-inline-block"
                    :to="{name: dropdownItem.link, params: { name: dropdownItem.name.split(' ').join('-').toLowerCase() }}"
                    tag="a"
                    @click.native="closeNav"> -->
                  <a href="#"
                     class="nav__dropdown-link d-inline-block"
                    @click="navigateToPage(dropdownItem, navItem.name)">
                    <span class="hover-mersh d-flex flex-nowrap"
                      :class="{'hover-mersh_type_dropdown': dropdownItem.childs}"
                      :data-length="dropdownItem.name.split('').length"
                      @mouseenter="hoverMershAddDelay"
                      @mouseleave="hoverMershRemoveDelay">
                      <span
                        class="hover-mersh__word d-flex"
                        v-for="(word, wordIndex) in dropdownItem.name.split(' ')"
                        v-bind:key="word + '-' + wordIndex">
                          <span
                            class="hover-mersh__letter"
                            v-for="(letter, letterIndex) in word.split('')"
                            v-bind:key="letter + '-' + letterIndex">
                            {{ letter }}
                          </span>
                          &nbsp;
                      </span>
                      <span
                        class="hover-mersh__letter hover-mersh__dropdown"
                        :class="{'open': showDropdownById === navItem.id}"
                        v-if="dropdownItem.childs">
                      </span>
                    </span>
                  </a>
                  <!-- </router-link> -->
              </li>
          </ul>
        </transition-group>
      </transition-group>
    </div>
  </transition>
</template>

<script>
import axios from 'axios'
import { hideMixin, hoverMershToggleDelay, domenMixin } from '@/mixins'
import { mapGetters, mapActions } from 'vuex'

export default {
  data () {
    return {
      clicked: 0,
      clickedId: '',
      showDropdownById: '',
      nav: '',
      domen: process.env.VUE_APP_DOMEN
    }
  },
  computed: {
    ...mapGetters([
      // 'nav',
      'showNav'
    ])
  },
  created () {
    this.domen = location.origin
    this.fetch()
  },
  methods: {
    ...mapActions({
      'hideNav': 'hideNav',
      'switchShowNav': 'switchShowNav'
    }),
    fetch () {
      var context = this

      axios.get(context.domen + '/api/info/header')
        .then(res => {
          // console.log(res)
          context.nav = res.data.nav
          // context.getCategoriesChildren(res.data.nav)
        })
        .catch(error => console.log(error))
    },
    // getCategoriesChildren (array) {
    //   var context = this
    //   var elems = []
    //   array.forEach(function (elem, i) {
    //     if (elem.parent_id !== '0') {
    //       if (array[elem.parent_id - 1].children === undefined) {
    //         array[elem.parent_id - 1].children = []
    //         array[elem.parent_id - 1].children.push(elem)
    //         elems.push(elem)
    //       } else {
    //         array[elem.parent_id - 1].children.push(elem)
    //         elems.push(elem)
    //       }
    //     }
    //   })
    //   elems.forEach(function (elem) {
    //     array.forEach(function (item, i) {
    //       if (elem === item) {
    //         array.splice(i, 1)
    //       }
    //     })
    //   })
    //   context.nav = array
    // },
    toggleNav () {
      var app = document.getElementById('app')
      app.classList.toggle('fixed')
      this.switchShowNav()
    },
    closeNav () {
      var app = document.getElementById('app')
      app.classList.remove('fixed')
      this.clickedId = ''
      this.hideNav()
    },
    navigateToPage (elem, parent) {
      var category = parent === undefined ? elem.name.split(' ').join('-').toLowerCase() : parent.split(' ').join('-').toLowerCase()
      var name
      var param = parent === undefined ? category : elem.name.split(' ').join('-').toLowerCase()
      if (category === 'каталог' && parent !== undefined) {
        name = 'category'
        this.routeTo(name, param)
      } else if (category === 'коллекция' && parent !== undefined) {
        name = 'collection'
        this.routeTo(name, param)
      } else if (category === 'главная') {
        name = 'index'
        this.routeTo(name, param)
      } else if (category === 'лукбук') {
        name = 'lookbook'
        this.routeTo(name, param)
      } else if (category === 'статьи') {
        name = 'paper'
        this.routeTo(name, param)
      } else if (category === 'оплата-и-доставка') {
        name = 'pay'
        this.routeTo(name, param)
      } else if (category === 'о-нас') {
        name = 'about'
        this.routeTo(name, param)
      } else if (category === 'контакты') {
        name = 'contacts'
        this.routeTo(name, param)
      }
    },
    routeTo (name, param) {
      this.$router.push({ name: name, params: { name: param } })
      this.closeNav()
      this.clickedId = ''
      this.clicked = 0
    },
    toggleDropdown (elem) {
      if (elem.name.toLowerCase() === 'изготовление на заказ') {
        this.closeNav()
        // var item = document.querySelector('.nav__list-link[data-target="#js-order"]')
        // item.setAttribute('data-toggle', 'modal')
      } else {
        this.clicked = this.clickedId === elem.id ? 1 : 0
        this.clickedId = elem.id
        this.showDropdownById = this.showDropdownById === elem.id ? '' : elem.id
        if (elem.childs === undefined) {
          this.navigateToPage(elem)
        } else if (elem.childs !== undefined && this.clicked) {
          this.navigateToPage(elem)
        }
      }
    },
    hide (e) {
      var nav = document.querySelector('#js-nav')
      if (!nav.contains(e.target)) {
        this.closeNav()
        this.showDropdownById = ''
      }
    }
  },
  mixins: [hideMixin, hoverMershToggleDelay, domenMixin]
}
</script>

<style lang="sass">
@import '@/sass/_fonts.sass'
@import '@/sass/_variables.sass'
.nav
  z-index: 100
  position: absolute
  top: 0
  left: 0
  display: flex
  flex-wrap: wrap
  justify-content: flex-end
  // flex-direction: column
  // width: 725px
  width: 37.760vw
  height: 100vh
  // overflow-y: scroll
  background-color: $color-nav

.nav__header
  width: 100%
  height: $height-header
  // padding-left: 128px
  padding-left: 6.667vw

.nav__close-wrapper
  width: auto
  height: 2.760vw

.nav__close
  padding: 0
  background-color: transparent
  border: none
  transition: opacity 0.3s linear
  &:hover
    opacity: 0.7
    & .nav__close-icon
      animation: slide-left-infinite 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940) infinite alternate-reverse both
      // &::before
      //   font-weight: 700
    & .nav__close-logo
      // transform: translateX(-0.521vw)
      // text-shadow: 1px 1px 3px $color-brown
      // filter: drop-shadow( 0 0 0.5px $color-brown)

.nav__close-icon
  // margin-right: 50px
  margin-right: 2.604vw
  // transform: translateX(10px)
  transform: translateX(0.521vw)
  transition: transform 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940)
  &::before
    // font-size: 24px
    font-size: 1.250vw

.nav__close-logo
  // width: calc(277px / 1.7)
  // height: calc(53px / 1.7)
  width: calc(14.427vw / 1.7)
  height: calc(2.760vw / 1.7)
  // transition: transform 0.5s cubic-bezier(0.250, 0.460, 0.450, 0.940)

.nav__list
  width: 100%
  height: calc(100vh - #{$height-header})
  margin: 0
  padding: 0
  // padding-top: 92px
  // padding-bottom: 92px
  padding-top: 4.792vw
  padding-bottom: 4.792vw
  list-style: none
  overflow-y: scroll
  scrollbar-width: none
  scrollbar-base-color: transparent
  scrollbar-face-color: transparent
  scrollbar-highlight-color: transparent
  scrollbar-3dlight-color: transparent
  scrollbar-shadow-color: transparent
  scrollbar-darkshadow-color: transparent
  scrollbar-track-color: transparent
  scrollbar-arrow-color: transparent
  -ms-scrollbar-base-color: transparent
  -ms-scrollbar-face-color: transparent
  -ms-scrollbar-highlight-color: transparent
  -ms-scrollbar-3dlight-color: transparent
  -ms-scrollbar-shadow-color: transparent
  -ms-scrollbar-darkshadow-color: transparent
  -ms-scrollbar-base-color: transparent
  -ms-scrollbar-track-color: transparent
  &::-webkit-scrollbar
    display: none

.nav__list-item
  background-color: $color-nav

.nav__dropdown-item
  // margin-top: 5px
  // margin-bottom: 5px
  margin-top: 0.260vw
  margin-bottom: 0.260vw

.nav__list-link
  // margin-left: 128px
  // margin-right: 128px
  margin-left: 6.667vw
  margin-right: 6.667vw
  // margin-top: 25px
  // margin-bottom: 25px
  margin-top: 1.302vw
  margin-bottom: 1.302vw

.nav__list-link,
.nav__dropdown-link
  // padding: 10px
  padding: 0.521vw
  font-family: $font-cormorant-sc
  // font-size: 24px
  font-size: 1.250vw
  line-height: 1
  font-weight: 700
  color: $color-brown
  &:hover
    text-decoration: none
    color: $color-brown

.hover-mersh
  position: relative
  &:hover
    & .hover-mersh__letter
      transform: perspective(1000px) rotate3d(0,1,0,360deg)

.hover-mersh_type_dropdown
  // padding-right: 65px
  padding-right: 3.385vw

.hover-mersh__letter
  transform: perspective(1000px) rotate3d(0,1,0,0deg)
  transition: transform 0.3s, color 0.3s, opacity 0.3s

.hover-mersh__dropdown
  position: absolute
  top: 50%
  // right: 5px
  right: 0.260vw
  display: flex
  // width: 18px
  // height: 10px
  // margin-top: -5px
  width: calc(0.938vw / 2)
  height: 0.521vw
  margin-top: -0.260vw
  &::before,
  &::after
    content: ''
    position: absolute
    top: 0
    width: 2px
    height: 10px
    // width: 0.104vw
    // height: 0.521vw
    background-color: $color-brown
    // border-radius: 10px
    border-radius: 0.521vw
    transition: transform 0.3s linear
  &::before
    right: calc(10px / 1.7)
    // right: calc(0.521vw / 1.7)
    transform: rotate(-45deg)
  &::after
    right: 0
    transform: rotate(45deg)
  &.open
    &::before
      transform: rotate(-135deg)
    &::after
      transform: rotate(135deg)

.nav__dropdown
  // margin-bottom: 10px
  margin-bottom: 0.521vw
  // padding-left: 128px
  // padding-right: 128px
  padding-left: 6.667vw
  padding-right: 6.667vw
  // padding-top: 20px
  // padding-bottom: 20px
  padding-top: 1.042vw
  padding-bottom: 1.042vw
  list-style: none
  background-color: $color-nav-dropdown
  overflow: hidden
  transition: max-height 0.3s linear, padding 0.3s linear, margin 0.3s linear

.nav-transition-group__item
  transition: all 0.6s, opacity 0s linear 0.5s

.nav-transition-group-enter,
.nav-transition-group-leave-to
  // opacity: 0
  // transform: translateY(30px)

.nav-transition-group-leave-to
  opacity: 0

.nav-transition-group-leave-active
  position: absolute

@media(max-width: 1199px)
  .nav
    width: calc(37.760vw * #{$gain-m})

  .nav__header
    height: calc(#{$height-header} * #{$gain-m} / 1.3)
    padding-left: calc(6.667vw * #{$gain-m})

  .nav__close-wrapper
    height: calc(2.760vw * #{$gain-m})

  .nav__close
    &:hover
      & .nav__close-logo
        // transform: translateX(calc(-0.521vw * #{$gain-m}))

  .nav__close-icon
    margin-right: calc(2.604vw * #{$gain-m})
    transform: translateX(calc(0.521vw * #{$gain-m}))
    &::before
      font-size: calc(1.250vw * #{$gain-m})

  .nav__close-logo
    width: calc(14.427vw * #{$gain-m} / 1.7)
    height: calc(2.760vw * #{$gain-m} / 1.7)

  .nav__list
    height: calc(100vh - #{$height-header} * #{$gain-m} / 1.3)
    padding-top: calc(4.792vw * #{$gain-m} / 1.7)
    padding-bottom: calc(4.792vw * #{$gain-m} / 1.7)

  .nav__dropdown-item
    margin-top: calc(0.260vw * #{$gain-m})
    margin-bottom: calc(0.260vw * #{$gain-m})

  .nav__list-link
    margin-left: calc(6.667vw * #{$gain-m})
    margin-right: calc(6.667vw * #{$gain-m})
    margin-top: calc(1.302vw * #{$gain-m})
    margin-bottom: calc(1.302vw * #{$gain-m})

  .nav__list-link,
  .nav__dropdown-link
    padding: calc(0.521vw * #{$gain-m})
    font-size: calc(1.250vw * #{$gain-m})

  .hover-mersh_type_dropdown
    padding-right: calc(3.385vw * #{$gain-m})

  .hover-mersh__dropdown
    right: calc(0.260vw * #{$gain-m})
    width: calc(0.938vw * #{$gain-m} / 2)
    height: calc(0.521vw * #{$gain-m})
    margin-top: calc(-0.260vw * #{$gain-m})
    &::before,
    &::after
      width: calc(0.104vw * #{$gain-m})
      height: calc(0.521vw * #{$gain-m})
      border-radius: calc(0.521vw * #{$gain-m})
    &::before
      right: calc(0.521vw * #{$gain-m} / 1.7)

  .nav__dropdown
    margin-bottom: calc(0.521vw * #{$gain-m})
    padding-left: calc(6.667vw * #{$gain-m})
    padding-right: calc(6.667vw * #{$gain-m})
    padding-top: calc(1.042vw * #{$gain-m})
    padding-bottom: calc(1.042vw * #{$gain-m})

@media(max-width: 991px)
  .nav
    width: calc(37.760vw * #{$gain-s})

  .nav__header
    height: calc(#{$height-header} * #{$gain-s} / 2)
    padding-left: calc(6.667vw * #{$gain-s})

  .nav__close-wrapper
    height: calc(2.760vw * #{$gain-s})

  .nav__close
    &:hover
      & .nav__close-logo
        // transform: translateX(calc(-0.521vw * #{$gain-s}))

  .nav__close-icon
    margin-right: calc(2.604vw * #{$gain-s})
    transform: translateX(calc(0.521vw *#{$gain-s}))
    &::before
      font-size: calc(1.250vw * #{$gain-s})

  .nav__close-logo
    width: calc(14.427vw * #{$gain-s} / 1.7)
    height: calc(2.760vw * #{$gain-s} / 1.7)

  .nav__list
    height: calc(100vh - #{$height-header} * #{$gain-s} / 2)
    padding-top: calc(4.792vw * #{$gain-s} / 2)
    padding-bottom: calc(4.792vw * #{$gain-s} / 2)

  .nav__dropdown-item
    margin-top: calc(0.260vw * #{$gain-s})
    margin-bottom: calc(0.260vw * #{$gain-s})

  .nav__list-link
    margin-left: calc(6.667vw * #{$gain-s})
    margin-right: calc(6.667vw * #{$gain-s})
    margin-top: calc(1.302vw * #{$gain-s})
    margin-bottom: calc(1.302vw * #{$gain-s})

  .nav__list-link,
  .nav__dropdown-link
    padding: calc(0.521vw * #{$gain-s})
    font-size: calc(1.250vw * #{$gain-s})

  .hover-mersh_type_dropdown
    padding-right: calc(3.385vw * #{$gain-s})

  .hover-mersh__dropdown
    right: calc(0.260vw * #{$gain-s})
    width: calc(0.938vw * #{$gain-s} / 2)
    height: calc(0.521vw * #{$gain-s})
    margin-top: calc(-0.260vw * #{$gain-s})
    &::before,
    &::after
      width: calc(0.104vw * #{$gain-s})
      height: calc(0.521vw * #{$gain-s})
      border-radius: calc(0.521vw * #{$gain-s})
    &::before
      right: calc(0.521vw * #{$gain-s} / 1.6)

  .nav__dropdown
    margin-bottom: calc(0.521vw * #{$gain-s})
    padding-left: calc(6.667vw * #{$gain-s})
    padding-right: calc(6.667vw * #{$gain-s})
    padding-top: calc(1.042vw * #{$gain-s})
    padding-bottom: calc(1.042vw * #{$gain-s})

@media(max-width: 767px)
  .nav
    width: calc(37.760vw * #{$gain-xs})

  .nav__header
    height: calc(#{$height-header} * #{$gain-xs} / 2)
    padding-left: calc(6.667vw * #{$gain-xs})

  .nav__close-wrapper
    height: calc(2.760vw * #{$gain-xs})

  .nav__close
    &:hover
      & .nav__close-logo
        // transform: translateX(calc(-0.521vw * #{$gain-xs}))

  .nav__close-icon
    margin-right: calc(2.604vw * #{$gain-xs})
    transform: translateX(calc(0.521vw * #{$gain-xs}))
    &::before
      font-size: calc(1.250vw * #{$gain-xs})

  .nav__close-logo
    width: calc(14.427vw * #{$gain-xs} / 1.7)
    height: calc(2.760vw * #{$gain-xs} / 1.7)

  .nav__list
    height: calc(100vh - #{$height-header} * #{$gain-xs} / 2)
    padding-top: calc(4.792vw * #{$gain-xs} / 2)
    padding-bottom: calc(4.792vw * #{$gain-xs} / 2)

  .nav__dropdown-item
    margin-top: calc(0.260vw * #{$gain-xs})
    margin-bottom: calc(0.260vw * #{$gain-xs})

  .nav__list-link
    margin-left: calc(6.667vw * #{$gain-xs})
    margin-right: calc(6.667vw * #{$gain-xs})
    margin-top: calc(1.302vw * #{$gain-xs})
    margin-bottom: calc(1.302vw * #{$gain-xs})

  .nav__list-link,
  .nav__dropdown-link
    padding: calc(0.521vw * #{$gain-xs})
    font-size: calc(1.250vw * #{$gain-xs})

  .hover-mersh_type_dropdown
    padding-right: calc(3.385vw * #{$gain-xs})

  .hover-mersh__dropdown
    right: calc(0.260vw * #{$gain-xs})
    width: calc(0.938vw * #{$gain-xs} / 2)
    height: calc(0.521vw * #{$gain-xs})
    margin-top: calc(-0.260vw * #{$gain-xs})
    &::before,
    &::after
      width: calc(0.104vw * #{$gain-xs} * 1.1)
      height: calc(0.521vw * #{$gain-xs})
      border-radius: calc(0.521vw * #{$gain-xs})
    &::before
      // right: calc(0.521vw * #{$gain-xs} / 1.7)

  .nav__dropdown
    margin-bottom: calc(0.521vw * #{$gain-xs})
    padding-left: calc(6.667vw * #{$gain-xs})
    padding-right: calc(6.667vw * #{$gain-xs})
    padding-top: calc(1.042vw * #{$gain-xs})
    padding-bottom: calc(1.042vw * #{$gain-xs})

@media(max-width: 575px)
  .nav
    width: calc(37.760vw * #{$gain-xs})

  .nav__header
    height: calc(#{$height-header} * #{$gain-xs} / 2)
    padding-left: calc(6.667vw * #{$gain-xs})

  .nav__close-wrapper
    height: calc(2.760vw * #{$gain-xs})

  .nav__close
    &:hover
      & .nav__close-logo
        // transform: translateX(calc(-0.521vw * #{$gain-xs}))

  .nav__close-icon
    margin-right: calc(2.604vw * #{$gain-xs})
    transform: translateX(calc(0.521vw * #{$gain-xs}))
    &::before
      font-size: calc(1.250vw * #{$gain-xs} * 1.2)

  .nav__close-logo
    width: calc(14.427vw * #{$gain-xs} / 1.7 * 1.2)
    height: calc(2.760vw * #{$gain-xs} / 1.7 * 1.2)

  .nav__list
    height: calc(100vh - #{$height-header} * #{$gain-xs} / 2)
    padding-top: calc(4.792vw * #{$gain-xs} / 2)
    padding-bottom: calc(4.792vw * #{$gain-xs} / 2)

  .nav__dropdown-item
    margin-top: calc(0.260vw * #{$gain-xs})
    margin-bottom: calc(0.260vw * #{$gain-xs})

  .nav__list-link
    margin-left: calc(6.667vw * #{$gain-xs})
    margin-right: calc(6.667vw * #{$gain-xs})
    margin-top: calc(1.302vw * #{$gain-xs})
    margin-bottom: calc(1.302vw * #{$gain-xs})

  .nav__list-link,
  .nav__dropdown-link
    padding: calc(0.521vw * #{$gain-xs} * 1.2)
    font-size: calc(1.250vw * #{$gain-xs} * 1.2)

  .hover-mersh_type_dropdown
    padding-right: calc(3.385vw * #{$gain-xs})

  .hover-mersh__dropdown
    right: calc(0.260vw * #{$gain-xs})
    width: calc(0.938vw * #{$gain-xs} / 2)
    height: calc(0.521vw * #{$gain-xs})
    margin-top: calc(-0.260vw * #{$gain-xs})
    &::before,
    &::after
      width: calc(0.104vw * #{$gain-xs} * 1.5)
      height: calc(0.521vw * #{$gain-xs})
      border-radius: calc(0.521vw * #{$gain-xs})
    &::before
      right: calc(0.521vw * #{$gain-xs} / 1.4)

  .nav__dropdown
    margin-bottom: calc(0.521vw * #{$gain-xs})
    padding-left: calc(6.667vw * #{$gain-xs})
    padding-right: calc(6.667vw * #{$gain-xs})
    padding-top: calc(1.042vw * #{$gain-xs})
    padding-bottom: calc(1.042vw * #{$gain-xs})
</style>
