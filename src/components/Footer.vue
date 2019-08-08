<template>
  <div class="footer">
    <div class="container d-flex flex-column align-items-center">

      <ul class="footer__nav d-flex flex-wrap flex-column flex-md-row justify-content-center align-items-center w-100">
        <li
          class="footer__nav-item"
          v-for="(navItem) in navFooter"
          v-bind:key="navItem.id">
          <router-link
            class="footer__nav-link d-block"
            :to="{name: navItem.link}"
            tag="a"
            :data-toggle="navItem.name === 'Изготовление на заказ' ? 'modal' : ''"
            :data-target="navItem.name === 'Изготовление на заказ' ? '#js-order' : ''">
            <span
              class="hover-mersh d-flex flex-nowrap"
              :class="{'hover-mersh_type_dropdown': navItem.children}"
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
            </span>
          </router-link>
        </li>
      </ul>

      <router-link class="footer__logo d-flex align-items-center justify-content-center"
        :to="{name: 'index'}"
        tag="a">
        <!-- <img src="../assets/img/logo-orange.svg" alt="logo"> -->
        <svg class="svg-logo svg-logo_location_footer" xmlns="http://www.w3.org/2000/svg" width="277" height="52" viewBox="0 0 277 52">
          <g fill="none" fill-rule="evenodd">
              <path class="svg-logo__path" fill="#cc8c65" d="M0 49.97h7.734V2.961H0V2h15.678L28.57 38.974h.14L41.6 2H57v.962h-7.735V49.97H57v.963H34.562v-.963h7.735V3.375h-.14L25.505 51 8.919 3.856H8.78v46.113h7.735v.963H0v-.963M66 50.036h7.825V2.964H66V2h40.321v11.906h-.775c-.611-1.79-1.27-3.36-1.974-4.714-.705-1.353-1.55-2.5-2.538-3.441-.986-.94-2.162-1.64-3.524-2.1-1.364-.457-3.008-.687-4.935-.687H80.874v21.265h4.582c1.55 0 2.866-.138 3.947-.413a6.051 6.051 0 0 0 2.784-1.548c.776-.757 1.433-1.79 1.975-3.097.539-1.308 1.068-2.994 1.585-5.058h.776v21.403h-.776c-.33-1.33-.67-2.616-1.022-3.855-.352-1.238-.846-2.34-1.48-3.303-.635-.964-1.48-1.731-2.538-2.305-1.057-.573-2.432-.86-4.123-.86h-5.71v24.843h13.323c2.583 0 4.734-.538 6.45-1.617 1.715-1.077 3.112-2.362 4.194-3.854 1.08-1.49 1.879-3.039 2.397-4.645.516-1.605.845-2.935.986-3.992H109V51H66v-.964"/>
              <path d="M121.375.389h93.424v51.588h-93.424z"/>
              <path class="svg-logo__path" fill="#cc8c65" d="M136.141 24.012h6.438c1.306 0 2.496-.161 3.57-.485a6.228 6.228 0 0 0 2.764-1.697c.77-.808 1.364-1.905 1.784-3.29.42-1.386.63-3.14.63-5.266 0-2.4-.315-4.33-.944-5.784-.63-1.455-1.448-2.552-2.45-3.29a8.119 8.119 0 0 0-3.36-1.456 20.036 20.036 0 0 0-3.673-.346c-.84 0-1.692.012-2.555.035-.863.024-1.598.081-2.204.173v21.406zm-14.766 25.979h7.768V2.606h-7.768v-.97h13.296a39.446 39.446 0 0 0 3.36-.139c.56 0 1.12-.01 1.68-.034.559-.023 1.119-.035 1.679-.035 2.752 0 5.178.15 7.278.45 2.1.301 4.059 1.167 5.879 2.598 1.632 1.248 2.787 2.657 3.463 4.226.676 1.57 1.015 3.048 1.015 4.434 0 .693-.13 1.582-.385 2.667-.256 1.086-.816 2.194-1.68 3.325-.863 1.132-2.11 2.172-3.743 3.118-1.634.947-3.803 1.582-6.509 1.905v.138c.746.094 1.76.266 3.044.52 1.283.254 2.59.682 3.92 1.281 1.329.601 2.554 1.398 3.673 2.39 1.12.994 1.913 2.276 2.38 3.846.28.924.477 1.974.595 3.151.115 1.178.21 2.39.28 3.638.07 1.246.14 2.448.21 3.602.07 1.155.197 2.125.384 2.91.28 1.2.723 2.286 1.33 3.255.606.97 1.586 1.455 2.94 1.455.605 0 1.235-.114 1.889-.346.652-.23 1.235-.6 1.75-1.109l.63.762a14.87 14.87 0 0 1-.806.59 5.894 5.894 0 0 1-1.154.588c-.467.184-1.04.335-1.715.45-.677.115-1.505.174-2.485.174-1.865 0-3.418-.232-4.653-.693-1.237-.461-2.228-1.143-2.974-2.044-.747-.9-1.294-2.01-1.645-3.325-.35-1.316-.595-2.851-.735-4.607l-.49-6.304c-.186-2.309-.653-4.11-1.4-5.404-.746-1.292-1.62-2.24-2.623-2.84-1.004-.6-2.041-.958-3.115-1.074a26.797 26.797 0 0 0-2.799-.173h-6.998V49.99h7.768v.97h-22.534v-.97zM179.248 36.066h.77c.513 2.494 1.178 4.596 1.995 6.304.815 1.71 1.714 3.118 2.694 4.226.98 1.109 2.005 1.964 3.08 2.564 1.072.6 2.156 1.038 3.253 1.316 1.096.277 2.146.439 3.15.485 1.002.045 1.947.069 2.834.069 2.472 0 4.501-.37 6.088-1.109 1.586-.738 2.845-1.673 3.78-2.805.932-1.131 1.584-2.356 1.959-3.672.373-1.316.56-2.529.56-3.637 0-1.616-.305-3.001-.91-4.156a10.03 10.03 0 0 0-2.31-2.945 13.026 13.026 0 0 0-3.044-1.974 21.257 21.257 0 0 0-3.114-1.178l-8.048-2.424c-3.779-1.154-6.637-2.678-8.573-4.573-1.936-1.893-2.904-4.433-2.904-7.62 0-2.078.373-4.006 1.12-5.785a13.538 13.538 0 0 1 3.149-4.606c1.353-1.293 2.974-2.31 4.864-3.049C191.53.76 193.594.39 195.834.39c1.633 0 2.997.138 4.094.416 1.096.277 2.04.588 2.834.935.793.346 1.505.658 2.135.935.63.277 1.27.416 1.924.416.606 0 1.015-.08 1.225-.243.21-.16.5-.565.874-1.212h.98v12.539h-.84a20.496 20.496 0 0 0-1.434-4.815c-.677-1.546-1.552-2.91-2.624-4.087-1.074-1.178-2.369-2.124-3.884-2.84-1.517-.716-3.279-1.074-5.284-1.074-1.12 0-2.356.15-3.709.45-1.354.301-2.614.82-3.78 1.559a9.4 9.4 0 0 0-2.903 2.91c-.77 1.201-1.155 2.725-1.155 4.572 0 1.478.303 2.736.91 3.775a8.764 8.764 0 0 0 2.344 2.633c.956.716 2.03 1.316 3.22 1.801 1.189.485 2.39.913 3.603 1.282l8.468 2.632c.886.277 2.005.648 3.36 1.108 1.352.463 2.67 1.155 3.953 2.079 1.283.924 2.38 2.148 3.29 3.672.909 1.524 1.364 3.463 1.364 5.819a15.99 15.99 0 0 1-1.225 6.2 15.505 15.505 0 0 1-3.534 5.196c-1.54 1.501-3.406 2.701-5.598 3.602-2.194.9-4.666 1.351-7.418 1.351-.98 0-1.844-.012-2.59-.035a19.584 19.584 0 0 1-2.1-.173 62.192 62.192 0 0 1-1.958-.312 20.945 20.945 0 0 1-2.17-.52c-.934-.276-1.937-.599-3.01-.97-1.073-.368-2.006-.554-2.798-.554-.7 0-1.18.14-1.435.416-.257.278-.479.647-.665 1.109h-1.05V36.066M224 50.036h7.792V2.964H224V2h22.604v.964h-7.792v22.504h23.376V2.964h-7.792V2H277v.964h-7.792v47.072H277V51h-22.604v-.964h7.792V26.431h-23.376v23.605h7.792V51H224v-.964"/>
          </g>
        </svg>
      </router-link>

      <div class="footer__contacts d-flex flex-column-reverse flex-md-row justify-content-between align-items-center w-100">
        <p class="footer__contacts-copyright d-flex flex-nowrap m-0">
          <span class="footer__text footer__text_font-weight_bold">Copyright&#160;</span>
          <span class="footer__text">2019  Mersh</span>
        </p>

        <div class="social d-flex flex-wrap justify-content-center align-items-center">
          <a v-if="facebookVisible" :href="facebook" class="social__item social__item_type_fb">
            <span class="social__icon icon-fb d-flex justify-content-center align-items-center"></span>
          </a>
          <a v-if="instagramVisible" :href="instagram" class="social__item social__item_type_insta">
            <span class="social__icon icon-insta d-flex justify-content-center align-items-center"></span>
          </a>
          <a v-if="youtubeVisible" :href="youtube" class="social__item social__item_type_youtube">
            <span class="social__icon icon-youtube d-flex justify-content-center align-items-center"></span>
          </a>
        </div>

        <div class="footer__contacts-phone d-flex justify-content-end align-items-center">
          <a :href="'tel:' + phoneCall" class="footer__text">{{ phone }}</a>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { hoverMershToggleDelay } from '@/mixins'
import { mapGetters } from 'vuex'

export default {
  data () {
    return {
      phone: '',
      facebook: '',
      instagram: '',
      youtube: '',
      facebookVisible: 1,
      instagramVisible: 1,
      youtubeVisible: 1,
      domen: process.env.VUE_APP_DOMEN
    }
  },
  computed: {
    ...mapGetters([
      'navFooter'
    ]),
    phoneCall () {
      if (this.phone) {
        return this.phone.split(' ').join('')
      }
    }
  },
  created: function () {
    this.fetch()
  },
  methods: {
    fetch () {
      var context = this

      axios.get(context.domen + '/api/info/contacts')
        .then(res => {
          // console.log(res)
          context.phone = res.data.phone
        })
        .catch(error => console.log(error))

      axios.get(context.domen + '/api/info/social')
        .then(res => {
          // console.log(res)
          res.data.forEach(function (elem) {
            if (elem.title === 'Facebook') {
              context.facebook = elem.link
              context.facebookVisible = elem['is_display']
            }
            if (elem.title === 'Instagram') {
              context.instagram = elem.link
              context.instagramVisible = elem['is_display']
            }
            if (elem.title === 'YouTube') {
              context.youtube = elem.link
              context.youtubeVisible = elem['is_display']
            }
          })
        })
        .catch(error => console.log(error))
    }
  },
  mixins: [hoverMershToggleDelay]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.footer
  background-color: transparent
  .container
    // padding-top: 86px
    // padding-bottom: 80px
    padding-top: 4.479vw
    padding-bottom: 4.167vw

.footer__nav
  margin: 0
  padding: 0
  list-style: none

.footer__nav-item
  // margin: 5px 15px
  margin: 0.260vw 0.781vw

.footer__nav-link
  // padding: 10px
  padding: 0.521vw
  font-family: $font-cormorant-sc
  // font-size: 18px
  font-size: 0.938vw
  line-height: 1
  font-weight: 700
  // letter-spacing: 5.14px
  // letter-spacing: 0.268vw
  text-transform: uppercase
  color: $color-brown
  white-space: nowrap
  .hover-mersh
    // margin-left: calc(-8.5px / 3)
    margin-left: calc(-0.443vw / 3)
  .hover-mersh__letter
    // padding: 0 calc(8.5px / 3)
    padding: 0 calc(0.443vw / 3)
  &:hover
    text-decoration: none
    color: $color-brown

.footer__logo
  // width: 277px
  // height: 53px
  // margin-top: 55px
  // margin-bottom: 75px
  width: 14.427vw
  height: 2.760vw
  margin-top: 2.865vw
  margin-bottom: 3.906vw
  &:hover
    cursor: pointer

.footer__contacts-copyright,
.footer__contacts-phone
  width: 20%

.footer__contacts-phone
  & .footer__text
    &:hover
      text-decoration: none
      color: $color-brown
      cursor: pointer

.footer__text
  font-family: $font-montserrat
  // font-size: 14px
  font-size: 0.729vw
  line-height: 1
  font-weight: 500
  color: $color-orange
  white-space: nowrap
  transition: color 0.3s linear

.footer__text_font-weight_bold
  font-weight: 700

.social__item
  // margin: 5px 10px
  // padding: 10px
  margin: 0.260vw 0.521vw
  padding: 0.521vw
  &:hover
    text-decoration: none
    cursor: pointer
    & .social__icon
      &::before
        color: $color-brown

.social__icon
  &::before
    // font-size: 19px
    font-size: 0.990vw
    transition: color 0.3s linear

@media(max-width: 1199px)
  .footer
    .container
      padding-top: calc(4.479vw * #{$gain-m} / 2)
      padding-bottom: calc(4.167vw * #{$gain-m} / 2)

  .footer__nav-item
    margin: calc(0.260vw * #{$gain-m}) calc(0.781vw * #{$gain-m})

  .footer__nav-link
    padding: calc(0.521vw * #{$gain-m})
    font-size: calc(0.938vw * #{$gain-m})
    // letter-spacing: calc(0.268vw * #{$gain-m})
    .hover-mersh
      margin-left: calc(-0.443vw * #{$gain-m} / 3)
    .hover-mersh__letter
      padding: 0 calc(0.443vw * #{$gain-m} / 3)

  .footer__logo
    width: calc(14.427vw * #{$gain-m})
    height: calc(2.760vw * #{$gain-m})
    margin-top: calc(2.865vw * #{$gain-m} / 2)
    margin-bottom: calc(3.906vw * #{$gain-m} / 2)

  .footer__text
    font-size: calc(0.729vw * #{$gain-m})

  .social__item
    margin: calc(0.260vw * #{$gain-m}) calc(0.521vw * #{$gain-m})
    padding: calc(0.521vw * #{$gain-m})

  .social__icon
    &::before
      font-size: calc(0.990vw * #{$gain-m})

@media(max-width: 767px)
  .footer
    .container
      padding-top: calc(4.479vw * #{$gain-xs} / 2)
      padding-bottom: calc(4.167vw * #{$gain-xs} / 2)

  .footer__nav-item
    margin: calc(0.260vw * #{$gain-xs} * 1.5) calc(0.781vw * #{$gain-xs})

  .footer__nav-link
    padding: calc(0.521vw * #{$gain-xs})
    font-size: calc(0.938vw * #{$gain-xs})
    // letter-spacing: calc(0.268vw * #{$gain-xs})
    .hover-mersh
      margin-left: calc(-0.443vw * #{$gain-xs} / 3)
    .hover-mersh__letter
      padding: 0 calc(0.443vw * #{$gain-xs} / 3)

  .footer__logo
    width: calc(14.427vw * #{$gain-xs})
    height: calc(2.760vw * #{$gain-xs})
    margin-top: calc(2.865vw * #{$gain-xs} / 1.5)
    margin-bottom: calc(3.906vw * #{$gain-xs} / 1.5)

  .footer__text
    font-size: calc(0.729vw * #{$gain-xs})

  .footer__contacts-copyright,
  .footer__contacts-phone
    width: auto

  .social__item
    margin: calc(0.260vw * #{$gain-xs} * 3) calc(0.521vw * #{$gain-xs})
    padding: calc(0.521vw * #{$gain-xs})

  .social__icon
    &::before
      font-size: calc(0.990vw * #{$gain-xs})

@media(max-width: 575px)
  .footer__nav-item
    margin: calc(0.260vw * #{$gain-xs} * 1.5 * 1.5) calc(0.781vw * #{$gain-xs})

  .footer__nav-link
    padding: calc(0.521vw * #{$gain-xs} * 1.2)
    font-size: calc(0.938vw * #{$gain-xs} * 1.2)

  .footer__logo
    margin-top: calc(2.865vw * #{$gain-xs})
    margin-bottom: calc(3.906vw * #{$gain-xs})

  .footer__text
    font-size: calc(0.729vw * #{$gain-xs} * 1.5)

  .social__item
    margin: calc(0.260vw * #{$gain-xs} * 5) calc(0.521vw * #{$gain-xs})
    padding: calc(0.521vw * #{$gain-xs} * 1.5)

  .social__icon
    &::before
      font-size: calc(0.990vw * #{$gain-xs} * 1.5)
</style>
