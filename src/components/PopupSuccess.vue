<template>
  <div class="popup success modal fade"
    :id="id"
    tabindex="-1"
    role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <button type="button" class="close d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
          <span class="icon-close d-flex align-items-center justify-content-center" aria-hidden="true"></span>
        </button>
        <form class="popup-form d-flex flex-column align-items-center justify-content-center">
          <h2 class="popup-form__title">Товар добавлен в корзину</h2>

          <div class="popup-form__img-wrapper d-flex align-items-center justify-content-center">
            <span class="popup-form__img icon-buy d-flex align-items-center justify-content-center"></span>
          </div>

          <p class="popup-form__descr mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>

          <div class="popup-form__submit d-flex align-items-center justify-content-between">
            <router-link class="button button_form"
              :to="{ name: 'cart' }"
              tag="a"
              data-dismiss="modal"
              aria-label="Close">
                Оформить
            </router-link>

            <button type="button" class="button button_form" data-dismiss="modal" aria-label="Close">
              Продолжить покупки
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      id: 'js-success'
    }
  }
}
</script>

<style lang="sass">
@import '@/sass/_variables.sass'
.success
  .popup-form__submit
    width: 100%
    // margin-top: 65px
    margin-top: 3.385vw
  .button_form
    // width: 283px
    width: 14.740vw
  .popup-form__img
    &::before
      // font-size: 147px
      font-size: 7.656vw

@media(max-width: 991px)
  .success
    .popup-form__submit
      margin-top: calc(3.385vw * #{$gain-m})
    .button_form
      width: calc(14.740vw * #{$gain-m})
    .popup-form__img
      &::before
        font-size: calc(7.656vw * #{$gain-m})

@media(max-width: 575px)
  .success
    .popup-form__submit
      margin-top: calc(3.385vw * #{$gain-xs})
    .button_form
      width: calc(14.740vw * #{$gain-xs})
    .popup-form__img
      &::before
        font-size: calc(7.656vw * #{$gain-xs})

// @media(max-width: 575px)
//   .success
//     .popup-form__submit
//       // margin-top: 65px
//       margin-top: 8.475vw
//     .button_form
//       // width: 283px
//       width: 36.897vw
//     .popup-form__img
//       &::before
//         // font-size: 147px
//         font-size: 19.166vw
</style>
