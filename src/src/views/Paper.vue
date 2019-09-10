<template>
  <div class="privacy paper d-flex flex-column">

    <div class="container container-main d-flex flex-grow-1">
      <div class="container-inner d-flex flex-column flex-sm-row">

        <ul class="paper__nav d-flex flex-column justify-content-center">
          <li class="paper__nav-item"
            v-for="paper in papers"
            v-bind:key="paper.id">
            <p class="paper__nav-link d-block mb-0"
              :class="{active: paper.id === shownPaper.id}"
              @click="showPaper(paper)">{{ paper.title }}</p>
          </li>
        </ul>

        <div class="paper__content">
          <h2 class="title privacy__title text-left">{{ shownPaper.title }}</h2>
          <!-- <p class="subtitle privacy__subtitle">{{ shownPaper.subtitle }}</p> -->
          <div class="text privacy__text" v-html="shownPaper.txt"></div>
        </div>

      </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import { scrollMixin, domenMixin } from '@/mixins'

export default {
  name: 'paper',
  data () {
    return {
      papers: '',
      shownPaper: '',
      domen: process.env.VUE_APP_DOMEN
    }
  },
  computed: {
    ...mapGetters([
      // 'papers'
    ])
  },
  created () {
    this.domen = location.origin
    this.fetch()
  },
  beforeDestroy () {
    this.scroll(0)
  },
  methods: {
    showPaper (paper) {
      this.shownPaper = paper
    },
    fetch () {
      var context = this

      axios.get(context.domen + '/api/info/articles')
        .then(res => {
          console.log(res)
          context.papers = res.data
          context.shownPaper = context.papers[0]
        })
        .catch(error => console.log(error))
    }
  },
  mixins: [scrollMixin, domenMixin]
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.paper
  .container-inner
    // padding-top: 68px
    // padding-bottom: 81px
    padding-top: 3.542vw
    padding-bottom: 4.219vw
  .title
    // margin-top: 32px
    margin-top: 1.667vw
    padding: 0
  .subtitle,
  .text
    padding-right: 0

.paper__nav
  z-index: 10
  // width: 460px
  // height: 906px
  // margin-right: 39px
  // padding: 60px
  width: 23.958vw
  height: 47.188vw
  margin-right: 2.031vw
  padding: 3.125vw
  background-image: url('../assets/img/paper.jpg')
  background-size: cover
  background-position: center
  background-repeat: no-repeat
  list-style: none
  overflow-y: scroll

.paper__nav-item
  // margin-bottom: 35px
  margin-bottom: 1.823vw
  &:last-child
    margin-bottom: 0

.paper__nav-link
  // padding: 20px 35px
  padding: 1.042vw 1.823vw
  font-family: $font-cormorant
  // font-size: 20px
  font-size: 1.042vw
  font-weight: 700
  line-height: 1
  color: $color-white
  border: 1px solid transparent
  transition: border 0.3s
  &:hover,
  &.active
    text-decoration: none
    color: $color-white
    border: 1px solid $color-text
  &:hover
    cursor: pointer

.paper__content
  // width: 561px
  // height: 906px
  width: 29.219vw
  height: 47.188vw
  overflow-y: scroll

@media(max-width: 1199px)
  .paper
    .container-inner
      padding-top: calc(68px / #{$lose-m})
      padding-bottom: calc(81px / #{$lose-m})
    .title
      margin-top: calc(32px / #{$lose-m})

  .paper__nav
    width: calc(460px / #{$lose-m})
    height: calc(906px / #{$lose-m})
    margin-right: calc(39px / #{$lose-m})
    padding: calc(60px / #{$lose-m})

  .paper__nav-item
    margin-bottom: calc(35px / #{$lose-m})

  .paper__nav-link
    padding: calc(20px / #{$lose-m}) calc(35px / #{$lose-m})
    font-size: calc(20px / #{$lose-m})

  .paper__content
    flex-grow: 1
    width: calc(561px / #{$lose-m})
    height: calc(906px / #{$lose-m})

@media(max-width: 991px)
  .paper
    .container-inner
      padding-top: calc(68px / #{$lose-s})
      padding-bottom: calc(81px / #{$lose-s})
    .title
      margin-top: calc(32px / #{$lose-s})

  .paper__nav
    width: calc(460px / #{$lose-s})
    height: calc(906px / #{$lose-s})
    margin-right: calc(39px / #{$lose-s})
    padding: calc(60px / #{$lose-s})

  .paper__nav-item
    margin-bottom: calc(35px / #{$lose-s})

  .paper__nav-link
    padding: calc(20px / #{$lose-s}) calc(35px / #{$lose-s})
    font-size: calc(20px / #{$lose-s})

  .paper__content
    flex-grow: 1
    width: calc(561px / #{$lose-s})
    height: calc(906px / #{$lose-s})

@media(max-width: 767px)
  .paper
    .container-inner
      padding-top: calc(68px / #{$lose-xs})
      padding-bottom: calc(81px / #{$lose-xs})
    .title
      margin-top: calc(32px / #{$lose-xs})

  .paper__nav
    width: calc(460px / #{$lose-xs})
    height: calc(906px / #{$lose-xs})
    margin-right: calc(39px / #{$lose-xs})
    padding: calc(60px / #{$lose-xs})

  .paper__nav-item
    margin-bottom: calc(35px / #{$lose-xs})

  .paper__nav-link
    padding: calc(20px / #{$lose-xs}) calc(35px / #{$lose-xs})
    font-size: calc(20px / #{$lose-xs})

  .paper__content
    width: calc(561px / #{$lose-xs})
    height: calc(906px / #{$lose-xs})

@media(max-width: 575px)
  .paper
    .container-main
      padding: 0
    .container-inner
      // min-height: 100vh
      padding-top: calc(3.542vw * #{$gain-xs})
      padding-bottom: calc(4.219vw * #{$gain-xs})
      padding-left: 15px
      padding-right: 15px
    .title
      margin-top: calc(1.667vw * #{$gain-xs})

  .paper__nav
    width: 100%
    max-height: calc(47.188vw * #{$gain-xs})
    height: auto
    margin-right: calc(2.031vw * #{$gain-xs})
    padding: calc(3.125vw * #{$gain-xs})

  .paper__nav-item
    margin-bottom: calc(1.823vw * #{$gain-xs})

  .paper__nav-link
    padding: calc(1.042vw * #{$gain-xs} * 1.3) calc(1.823vw * #{$gain-xs} * 1.3)
    font-size: calc(1.042vw * #{$gain-xs} * 1.4)

  .paper__content
    width: 100%
    height: auto

</style>
