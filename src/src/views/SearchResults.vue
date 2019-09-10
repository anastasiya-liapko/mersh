<template>
  <div class="category search-results d-flex flex-column">

    <div class="container container-main d-flex flex-grow-1">
      <div class="container-inner">

        <div class="products">
          <h2 class="search-title d-flex flex-column justify-content-center align-items-center">
              <span class="search-title__subtitle">Результаты по запросу:</span>
              <span class="title search-title__title text-center">{{ searchValue }}</span>
              <div class="seacr-title__quantity d-flex flex-nowrap justify-content-center align-items-end">
                <span class="search-title__quantity-text">Найдено&nbsp;</span>
                <span class="search-title__quantity-number">{{ total }}</span>
              </div>
          </h2>
          <div class="d-flex flex-wrap align-items-start justify-content-start">
            <a class="product"
              v-for="product in products"
              v-bind:key="product.id"
              @click="routeTo(product)">
              <app-product
                :element="product"
                :hoverText="hoverText">
              </app-product>
            </a>
           </div>
        </div>

      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios'
import Product from '@/components/Product.vue'
import { mapGetters } from 'vuex'
import { scrollMixin, visible, domenMixin } from '@/mixins'

export default {
  name: 'search',
  data () {
    return {
      categories: [],
      products: [],
      total: '',
      page: 1,
      hoverText: 'Подробнее',
      domen: process.env.VUE_APP_DOMEN
    }
  },
  computed: {
    ...mapGetters([
      // 'products'
    ]),
    searchValue () {
      return this.$route.params.name
    }
  },
  created () {
    this.domen = location.origin
    this.page = 1
    this.fetch()
    this.getCategories()
    window.addEventListener('scroll', this.showVisible)
  },
  beforeDestroy () {
    this.scroll(0)
    window.removeEventListener('scroll', this.showVisible)
  },
  methods: {
    fetch () {
      var context = this
      axios.get(context.domen + '/api/products/search/?s=' + context.searchValue + '&page=' + context.page)
        .then(res => {
          // console.log(res)
          for (let i = 0; i < res.data.products.length; i++) {
            context.products.push(res.data.products[i])
          }
          context.total = res.data.total
        })
        .catch(error => {
          console.log(error)
          context.products = []
          context.page = 1
          context.total = 0
        })
    },
    showVisible () {
      var elements = document.getElementsByClassName('product')
      var secondToLastElement = elements[elements.length - 1]
      if (this.isVisible(secondToLastElement) && this.page < Math.ceil(this.total / 12)) {
        this.page += 1
        this.fetch()
      }
    },
    getCategories () {
      var context = this
      axios.get(context.domen + '/api/info/main')
        .then(res => {
          // console.log(res)
          context.categories = res.data.categories
        })
        .catch(error => {
          console.log(error)
        })
    },
    routeTo (product) {
      var categoryName
      this.categories.forEach( function (elem) {
        if (elem.id === product.category_id) {
          return categoryName = elem.name
        }
      })
      this.$router.push({name: 'category-product', params: { name: categoryName.split(' ').join('-').toLowerCase(), id: product.id }})
    }
  },
  watch: {
    searchValue: function () {
      this.products = []
      this.page = 1
      this.fetch()
    }
  },
  components: {
    'app-product': Product
  },
  mixins: [scrollMixin, visible, domenMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.category
  .container-inner
    // padding-top: 25px
    // padding-bottom: 69px
    padding-top: 1.302vw
    padding-bottom: 3.594vw

.search-title
  // margin-top: 48px
  // margin-bottom: 42px
  margin-top: 2.500vw
  margin-bottom: 2.188vw

.search-title__subtitle
  // padding-left: 11px
  padding-left: 0.573vw
  font-family: $font-cormorant
  // font-size: 14px
  font-size: 0.729vw
  line-height: 1
  font-weight: 700
  // letter-spacing: 11px
  letter-spacing: 0.573vw
  text-transform: uppercase
  color: $color-brown

.search-title__title
  // margin-top: 12px
  // margin-bottom: 6px
  margin-top: 0.625vw
  margin-bottom: 0.313vw

.search-title__quantity-text,
.search-title__quantity-number
  // padding-left: 3.1px
  padding-left: 0.161vw
  font-family: $font-cormorant
  // font-size: 20px
  font-size: 1.042vw
  line-height: 1
  font-weight: 700
  // letter-spacing: 3.1px
  letter-spacing: 0.161vw
  text-transform: uppercase
  color: $color-text

@media(max-width: 1199px)
  .category
    .container-inner
      padding-top: calc(25px / #{$lose-m})
      padding-bottom: calc(69px / #{$lose-m})

  .search-title
    margin-top: calc(48px / #{$lose-m})
    margin-bottom: calc(42px / #{$lose-m})

  .search-title__subtitle
    padding-left: calc(11px / #{$lose-m})
    font-size: calc(14px / #{$lose-m})
    letter-spacing: calc(11px / #{$lose-m})

  .search-title__title
    margin-top: calc(12px / #{$lose-m})
    margin-bottom: calc(6px / #{$lose-m})

  .search-title__quantity-text,
  .search-title__quantity-number
    padding-left: calc(3.1px / #{$lose-m})
    font-size: calc(20px / #{$lose-m})
    letter-spacing: calc(3.1px / #{$lose-m})

@media(max-width: 991px)
  .category
    .container-inner
      padding-top: calc(25px / #{$lose-s})
      padding-bottom: calc(69px / #{$lose-s})

  .search-title
    margin-top: calc(48px / #{$lose-s})
    margin-bottom: calc(42px / #{$lose-s})

  .search-title__subtitle
    padding-left: calc(11px / #{$lose-s})
    font-size: calc(14px / #{$lose-s})
    letter-spacing: calc(11px / #{$lose-s})

  .search-title__title
    margin-top: calc(12px / #{$lose-s})
    margin-bottom: calc(6px / #{$lose-s})

  .search-title__quantity-text,
  .search-title__quantity-number
    padding-left: calc(3.1px / #{$lose-s})
    font-size: calc(20px / #{$lose-s})
    letter-spacing: calc(3.1px / #{$lose-s})

@media(max-width: 767px)
  .category
    .container-inner
      padding-top: calc(25px / #{$lose-xs})
      padding-bottom: calc(69px / #{$lose-xs})

  .search-title
    margin-top: calc(48px / #{$lose-xs})
    margin-bottom: calc(42px / #{$lose-xs})

  .search-title__subtitle
    padding-left: calc(11px / #{$lose-xs})
    font-size: calc(14px / #{$lose-xs})
    letter-spacing: calc(11px / #{$lose-xs})

  .search-title__title
    margin-top: calc(12px / #{$lose-xs})
    margin-bottom: calc(6px / #{$lose-xs})

  .search-title__quantity-text,
  .search-title__quantity-number
    padding-left: calc(3.1px / #{$lose-xs})
    font-size: calc(20px / #{$lose-xs})
    letter-spacing: calc(3.1px / #{$lose-xs})

@media(max-width: 575px)
  .category
    .container-main
      padding-left: 0
      padding-right: 0
    .container-inner
      padding-top: calc(1.302vw * #{$gain-m})
      padding-bottom: calc(3.594vw * #{$gain-m})
      padding-left: 15px
      padding-right: 15px

  .search-title
    margin-top: calc(2.500vw * #{$gain-xs})
    margin-bottom: calc(2.188vw * #{$gain-xs})

  .search-title__subtitle
    padding-left: calc(0.573vw * #{$gain-xs})
    font-size: calc(0.729vw * #{$gain-xs} * 1.3)
    letter-spacing: calc(0.573vw * #{$gain-xs})

  .search-title__title
    margin-top: calc(0.625vw * #{$gain-xs})
    margin-bottom: calc(0.313vw * #{$gain-xs} * 4)

  .search-title__quantity-text,
  .search-title__quantity-number
    padding-left: calc(0.161vw * #{$gain-xs})
    font-size: calc(1.042vw * #{$gain-xs} * 1.3)
    letter-spacing: calc(0.161vw * #{$gain-xs})
</style>
