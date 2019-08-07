<template>
  <div class="category d-flex flex-column">

    <div class="container container-main d-flex flex-grow-1">
      <div class="container-inner">

        <div class="products">
          <h2 class="title products__title text-center">{{ $route.name === 'new' ? $route.path.split('-').join(' ').toUpperCase().split('/').pop() : $route.params.name.split('-').join(' ').toUpperCase() }}</h2>
          <div class="d-flex flex-wrap align-items-start justify-content-start">
            <router-link class="product"
              :to="{name: $route.name + '-product', params: { id: product.id }}"
              tag="a"
              v-for="product in products"
              v-bind:key="product.id">
              <transition name="show-product">
                <app-product
                  :element="product"
                  :hoverText="hoverText">
                </app-product>
              </transition>
            </router-link>
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
import { scrollMixin, visible } from '@/mixins'

export default {
  name: 'category',
  data () {
    return {
      categories: '',
      collections: '',
      categoryId: '',
      collectionId: '',
      products: [],
      total: '',
      page: 1,
      hoverText: 'Подробнее',
      domen: process.env.VUE_APP_DOMEN
    }
  },
  created () {
    this.page = 1
    this.getCategories()
    window.addEventListener('scroll', this.showVisible)
  },
  beforeDestroy () {
    this.scroll(0)
    window.removeEventListener('scroll', this.showVisible)
  },
  computed: {
    ...mapGetters([
      // 'products'
    ])
  },
  methods: {
    fetch () {
      var context = this
      if (context.$route.name === 'new') {
        var path = context.domen + '/api/products/' + context.$route.name + '/' + context.page
      } else if (context.$route.name === 'category') {
        var path = context.domen + '/api/products/' + context.$route.name + '/' + context.categoryId + '/' + context.page
      } else if (context.$route.name === 'collection') {
        var path = context.domen + '/api/products/' + context.$route.name + '/' + context.collectionId + '/' + context.page
      }
      axios.get(path)
        .then(res => {
          // console.log(res)
          // context.products = res.data.products
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
          context.collections = res.data.collections
          context.getCategoryId()
          context.fetch()
        })
        .catch(error => console.log(error))
    },
    getCategoryId () {
      var context = this
      context.products = []
      context.page = 1
      context.total = 0

      if (context.$route.name === 'category') {
        this.categories.forEach( function (elem) {
          if (elem.name.toLowerCase().split(' ').join('-') === context.$route.params.name) {
            context.categoryId = elem.id
          }
        })
      } else if (context.$route.name === 'collection') {
        this.collections.forEach( function (elem) {
          if (elem.name.toLowerCase().split(' ').join('-') === context.$route.params.name) {
            context.collectionId = elem.id
          }
        })
      }

    }
  },
  components: {
    'app-product': Product
  },
  mixins: [scrollMixin, visible]
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

.products__title
  // margin-bottom: 67px
  // margin-top: 67px
  margin-bottom: 3.490vw
  margin-top: 3.490vw

.show-product-enter-active,
.show-product-leave-active
  transition: opacity .5s

.show-product-enter,
.show-product-leave-to
  opacity: 0

@media(max-width: 1199px)
  .category
    .container-inner
      padding-top: calc(25px / #{$lose-m})
      padding-bottom: calc(69px / #{$lose-m})

  .products__title
    margin-bottom: calc(67px / #{$lose-m})
    margin-top: calc(67px / #{$lose-m})

@media(max-width: 991px)
  .category
    .container-inner
      padding-top: calc(25px / #{$lose-s})
      padding-bottom: calc(69px / #{$lose-s})

  .products__title
    margin-bottom: calc(67px / #{$lose-s})
    margin-top: calc(67px / #{$lose-s})

@media(max-width: 767px)
  .category
    .container-inner
      padding-top: calc(25px / #{$lose-xs})
      padding-bottom: calc(69px / #{$lose-xs})

  .products__title
    margin-bottom: calc(67px / #{$lose-xs})
    margin-top: calc(67px / #{$lose-xs})

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

  .products__title
    margin-bottom: calc(3.490vw * #{$gain-m})
    margin-top: calc(3.490vw * #{$gain-m})
</style>
