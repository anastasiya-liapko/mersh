import Vue from 'vue'
import Router from 'vue-router'
import Index from './views/Index.vue'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'index',
      component: Index
    },
    {
      path: '/категория/:name',
      name: 'category',
      component: () => import('./views/Category.vue')
    },
    {
      path: '/коллекция/:name',
      name: 'collection',
      component: () => import('./views/Category.vue')
    },
    {
      path: '/новые-поступления',
      name: 'new',
      component: () => import('./views/Category.vue')
    },
    {
      path: '/категория/:name/:id',
      name: 'category-product',
      component: () => import('./views/Product.vue')
    },
    {
      path: '/коллекция/:name/:id',
      name: 'collection-product',
      component: () => import('./views/Product.vue')
    },
    {
      path: '/новые-поступления/:id',
      name: 'new-product',
      component: () => import('./views/Product.vue')
    },
    {
      path: '/поиск/:name',
      name: 'search',
      component: () => import('./views/SearchResults.vue')
    },
    {
      path: '/политика-конфиденциальности',
      name: 'privacy',
      component: () => import('./views/Privacy.vue')
    },
    {
      path: '/оплата-и-доставка',
      name: 'pay',
      component: () => import('./views/Pay.vue')
    },
    {
      path: '/о-нас',
      name: 'about',
      component: () => import('./views/About.vue')
    },
    {
      path: '/корзина',
      name: 'cart',
      component: () => import('./views/Cart.vue')
    },
    {
      path: '/оформление-заказа',
      name: 'order-register',
      component: () => import('./views/OrderRegister.vue')
    },
    {
      path: '/заказ-оформлен',
      name: 'order-accept',
      component: () => import('./views/OrderAccept.vue')
    },
    {
      path: '/контакты',
      name: 'contacts',
      component: () => import('./views/Contacts.vue')
    },
    {
      path: '/лукбук',
      name: 'lookbook',
      component: () => import('./views/Lookbook.vue')
    },
    {
      path: '/статья',
      name: 'paper',
      component: () => import('./views/Paper.vue')
    },
    {
      path: '*',
      redirect: '/'
    }
    // {
    //   path: '/категория/:id',
    //   name: 'product',
    //   component: () => import('./views/Product.vue')
    // }
  ],
  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
})
