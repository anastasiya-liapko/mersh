<template>
  <div class="popup preview modal fade"
    :id="id"
    tabindex="-1"
    role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <button type="button" class="close d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
          <span class="icon-close d-flex align-items-center justify-content-center" aria-hidden="true"></span>
        </button>

        <app-slick class="product-slider"
          ref="slick"
          :options="options"
          @beforeChange="handleBeforeChange">
          <div
            class="position-relative"
            v-for="image in product.images"
            v-bind:key="image.id">
          <div>
            <a>
              <video
                v-if="image.is_video === 1"
                muted="muted"
                loop="loop"
                preload="auto"
                width="100%"
                autoplay="autoplay">
                <source
                  :src="image.content"
                  type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                Тег video не поддерживается вашим браузером.
              </video>
              <img
                v-if="image.is_video === 0"
                :src="image.content"
                alt="">
            </a>
            </div>
            <i
              class="product-slider__sound fas fa-volume-mute d-flex align-items-center justify-content-start"
              v-if="image.is_video === 1 && showMute"
              @click="showMute = !showMute">
            </i>
            <i
              class="product-slider__sound fas fa-volume-up d-flex align-items-center justify-content-start"
              v-if="image.is_video === 0 && !showMute"
              @click="showMute = !showMute">
            </i>
          </div>
        </app-slick>

      </div>
    </div>
  </div>
</template>

<script>
import Slick from 'vue-slick'

export default {
  data () {
    return {
      id: 'js-preview',
      showMute: true
    }
  },
  props: ['product', 'options'],
  mounted () {
    var self = this
    $('#' + this.id).on('shown.bs.modal', function () {
      self.$refs.slick.reSlick()
    })
  },
  methods : {
    handleBeforeChange (event, slick, currentSlide, nextSlide) {
      if (slick.$slides[currentSlide].querySelector('video')) {
        slick.$slides[currentSlide].querySelector('video').muted = true
        slick.$slides[currentSlide].querySelector('video').pause()
        this.showMute = true
      }

      if (slick.$slides[nextSlide].querySelector('video')) {
        slick.$slides[nextSlide].querySelector('video').currentTime = 0;
        slick.$slides[nextSlide].querySelector('video').play()
      }
    },
    handleInit (event, slick) {
      this.$refs.slick.reSlick()
      var video = document.querySelector('.slick-current video')
      video ? video.play() : ''
    }
  },
  watch: {
    showMute: function () {
      var video = document.querySelector('.slick-active video')
      if (video) {
        this.showMute ? video.muted = true : video.muted = false
      }
    },
    options: function () {
      this.$refs.slick.reSlick()
    }
  },
  components: {
    'app-slick': Slick
  }
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.preview
  display: block
  pointer-events: none !important
  .modal-dialog
    max-width: 100%
    width: 100%
    max-height: 100vh
    margin: 0
  .modal-content
    display: flex
    justify-content: center
    pointer-events: none !important
    max-width: 100%
    width: 100%
    max-height: 100vh
    height: 100vh
    padding: 0
    background-color: $color-popup-overlay
    img,
    video
      width: 100vw
      height: 100vh
      margin: 0 auto
      object-fit: contain
  .slick-slider
    height: 100vh
  &.show
    pointer-events: auto !important
    .modal-content
      pointer-events: auto !important
</style>
