<template>
  <div class="index d-flex flex-column">

    <app-banner-main></app-banner-main>

    <div class="container container-main flex-grow-1 d-flex flex-column">
      <div class="container-inner flex-grow-1">
        <div v-if="info !== ''" class="index__about clearfix d-flex flex-column d-sm-inline-block">
          <div v-if="info.img && info.img !== ''" class="index__about-img-wrapper order-2">
            <img :src="info.img" alt="about">
          </div>

          <h2 class="title index__about-title">{{ info.title }}</h2>

          <div class="text index__about-text" v-html="info.txt"></div>
        </div>

        <div class="catalog">
          <h2 class="title catalog__title">КАТАЛОГ</h2>
          <div class="d-flex flex-wrap align-items-start justify-content-start">
            <router-link class="product product_type_category"
              :to="{name: 'category', params: { name: category.name.split(' ').join('-').toLowerCase() }}"
              tag="a"
              v-for="category in categories"
              v-bind:key="category.id">
              <app-product
                :element="category"
                :hoverText="catalogHoverText">
              </app-product>
            </router-link>
           </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios'
import BannerMain from '@/components/BannerMain.vue'
import Product from '@/components/Product.vue'
import { mapGetters } from 'vuex'
import { scrollMixin } from '@/mixins'

export default {
  name: 'index',
  data () {
    return {
      info: '',
      categories: '',
      catalogHoverText: 'Перейти в каталог',
      domen: process.env.VUE_APP_DOMEN
    }
  },
  computed: {
    ...mapGetters([
      // 'categories'
    ])
  },
  created () {
    this.fetch()
  },
  mounted () {
    var header = document.getElementById('js-header')
    header.classList.add('header_index')
  },
  beforeDestroy () {
    var header = document.getElementById('js-header')
    header.classList.remove('header_index')
    this.scroll(0)
  },
  methods: {
    fetch () {
      var context = this

      axios.get(context.domen + '/api/info/main')
        .then(res => {
          // console.log(res)
          context.info = res.data.info
          context.categories = res.data.categories
        })
        .catch(error => console.log(error))
    }
  },
  components: {
    'app-banner-main': BannerMain,
    'app-product': Product
  },
  mixins: [scrollMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.index
  .container-inner
    height: 100%
    // padding-bottom: 122px
    // padding-top: 128px
    padding-bottom: 4.479vw
    padding-top: 6.667vw

.index__about
  width: 100%
  // margin-bottom: 105px
  margin-bottom: 5.469vw

.index__about-img-wrapper
  float: left
  width: 50%
  height: auto
  // margin-right: 102px
  // margin-bottom: 61px
  margin-right: 5.313vw
  margin-bottom: 3.177vw

.index__about-title
  // padding-top: 102px
  // padding-bottom: 54px
  padding-top: 5.313vw
  padding-bottom: 2.813vw

.catalog__title
  // margin-bottom: 36px
  margin-bottom: 1.875vw

@media(max-width: 1199px)
  .index
    .container-main
      padding: 0 15px
    .container-inner
      padding-bottom: calc(122px / #{$lose-m})
      padding-top: calc(128px / #{$lose-m})

  .index__about
    margin-bottom: calc(105px / #{$lose-m})

  .index__about-img-wrapper
    margin-right: calc(102px / #{$lose-m})
    margin-bottom: calc(61px / #{$lose-m})

  .index__about-title
    padding-top: calc(102px / #{$lose-m})
    padding-bottom: calc(54px / #{$lose-m})

  .catalog__title
    margin-bottom: calc(36px / #{$lose-m})

@media(max-width: 991px)
  .index
    .container-inner
      padding-bottom: calc(122px / #{$lose-s} / 2)
      padding-top: calc(128px / #{$lose-s} / 2)

  .index__about
    margin-bottom: calc(105px / #{$lose-s} / 2)

  .index__about-img-wrapper
    margin-right: calc(102px / #{$lose-s} / 2)
    margin-bottom: calc(61px / #{$lose-s} / 2)

  .index__about-title
    padding-top: calc(102px / #{$lose-s} / 2)
    padding-bottom: calc(54px / #{$lose-s} / 2)

  .catalog__title
    margin-bottom: calc(36px / #{$lose-s})

@media(max-width: 767px)
  .index
    .container-inner
      padding-bottom: calc(122px / #{$lose-xs} / 2)
      padding-top: calc(128px / #{$lose-xs} / 2)

  .index__about
    margin-bottom: calc(105px / #{$lose-xs} / 2)

  .index__about-img-wrapper
    margin-right: calc(102px / #{$lose-xs} / 2)
    margin-bottom: calc(61px / #{$lose-xs} / 2)

  .index__about-title
    padding-top: calc(102px / #{$lose-xs} / 2)
    padding-bottom: calc(54px / #{$lose-xs} / 2)

  .catalog__title
    margin-bottom: calc(36px / #{$lose-xs})

@media(max-width: 575px)
  .index
    .container-main
      padding: 0
    .container-inner
      padding-bottom: calc(6.354vw * #{$gain-xs} / 2.3)
      padding-top: calc(6.667vw * #{$gain-xs} / 2)

  .index__about
    margin-bottom: calc(5.469vw * #{$gain-xs} / 2)
    & p,
    & h2
      padding-left: 15px
      padding-right: 15px

  .index__about-img-wrapper
    float: none
    width: 100%
    margin-top: calc(5.313vw * #{$gain-xs} / 2 / 1.5)
    margin-right: 0
    margin-bottom: 0

  .index__about-title
    padding-top: 0
    padding-bottom: calc(2.813vw * #{$gain-xs} / 2)

  .catalog
    padding-left: 15px
    padding-right: 15px

  .catalog__title
    margin-bottom: calc(1.875vw * #{$gain-xs})

</style>
