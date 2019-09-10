export const domenMixin = {
  created: function () {
    // this.domen = location.origin
  }
}

export const hideMixin = {
  created: function () {
    document.addEventListener('mouseup', this.hide)
  },
  beforeDestroy: function () {
    document.removeEventListener('mouseup', this.hide)
  }
}

export const hoverMershToggleDelay = {
  methods: {
    hoverMershAddDelay (event) {
      var letters = event.target.querySelectorAll('.hover-mersh__letter')
      letters.forEach(function (element, i) {
        element.setAttribute('style', 'transition-delay: ' + i / 50 + 's')
      })
    },
    hoverMershRemoveDelay (event) {
      var letters = event.target.querySelectorAll('.hover-mersh__letter')
      var length = parseInt(event.target.getAttribute('data-length'))
      letters.forEach(function (element, i) {
        element.setAttribute('style', 'transition-delay: ' + length / 50 + 's')
        length = length - 1
      })
    }
  }
}

export const scrollMixin = {
  methods: {
    scroll (to) {
      var smoothScrollFeature = 'scrollBehavior' in document.documentElement.style
      var i = parseInt(window.pageYOffset)
      if (i !== to) {
        if (!smoothScrollFeature) {
          to = parseInt(to)
          if (i < to) {
            let int = setInterval(function () {
              if (i > (to - 20)) i += 1
              else if (i > (to - 40)) i += 3
              else if (i > (to - 80)) i += 8
              else if (i > (to - 160)) i += 18
              else if (i > (to - 200)) i += 24
              else if (i > (to - 300)) i += 40
              else i += 60
              window.scroll(0, i)
              if (i >= to) clearInterval(int)
            }, 5)
          } else {
            let int = setInterval(function () {
              if (i < (to + 20)) i -= 1
              else if (i < (to + 40)) i -= 3
              else if (i < (to + 80)) i -= 8
              else if (i < (to + 160)) i -= 18
              else if (i < (to + 200)) i -= 24
              else if (i < (to + 300)) i -= 40
              else i -= 60
              window.scroll(0, i)
              if (i <= to) clearInterval(int)
            }, 5)
          }
        } else {
          window.scroll({
            top: to,
            left: 0,
            behavior: 'smooth'
          })
        }
      }
    }
  }
}

export const visible = {
  methods: {
    isVisible (elem) {
      var coords = elem.getBoundingClientRect()
      var windowHeight = document.documentElement.clientHeight
      var extendedBottom = 2 * windowHeight
      var bottomVisible = coords.bottom < extendedBottom
      return bottomVisible
    }
  }
}
