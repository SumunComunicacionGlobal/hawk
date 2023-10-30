/*!
  * Understrap v1.0.1 (https://understrap.com)
  * Copyright 2013-2023 The Understrap Authors (https://github.com/understrap/understrap/graphs/contributors)
  * Licensed under GPL (http://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html)
  */
(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports, require('jquery')) :
  typeof define === 'function' && define.amd ? define(['exports', 'jquery'], factory) :
  (global = typeof globalThis !== 'undefined' ? globalThis : global || self, factory(global.understrap = {}, global.jQuery));
})(this, (function (exports, $) { 'use strict';

  function _interopDefaultLegacy (e) { return e && typeof e === 'object' && 'default' in e ? e : { 'default': e }; }

  var $__default = /*#__PURE__*/_interopDefaultLegacy($);

  /**
   * --------------------------------------------------------------------------
   * Bootstrap (v4.6.0): button.js
   * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
   * --------------------------------------------------------------------------
   */

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  const NAME$1 = 'button';
  const VERSION$1 = '4.6.0';
  const DATA_KEY$1 = 'bs.button';
  const EVENT_KEY$1 = `.${DATA_KEY$1}`;
  const DATA_API_KEY$1 = '.data-api';
  const JQUERY_NO_CONFLICT$1 = $__default["default"].fn[NAME$1];

  const CLASS_NAME_ACTIVE = 'active';
  const CLASS_NAME_BUTTON = 'btn';
  const CLASS_NAME_FOCUS = 'focus';

  const SELECTOR_DATA_TOGGLE_CARROT = '[data-toggle^="button"]';
  const SELECTOR_DATA_TOGGLES = '[data-toggle="buttons"]';
  const SELECTOR_DATA_TOGGLE$1 = '[data-toggle="button"]';
  const SELECTOR_DATA_TOGGLES_BUTTONS = '[data-toggle="buttons"] .btn';
  const SELECTOR_INPUT = 'input:not([type="hidden"])';
  const SELECTOR_ACTIVE = '.active';
  const SELECTOR_BUTTON = '.btn';

  const EVENT_CLICK_DATA_API$1 = `click${EVENT_KEY$1}${DATA_API_KEY$1}`;
  const EVENT_FOCUS_BLUR_DATA_API = `focus${EVENT_KEY$1}${DATA_API_KEY$1} ` +
                            `blur${EVENT_KEY$1}${DATA_API_KEY$1}`;
  const EVENT_LOAD_DATA_API = `load${EVENT_KEY$1}${DATA_API_KEY$1}`;

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  class Button {
    constructor(element) {
      this._element = element;
      this.shouldAvoidTriggerChange = false;
    }

    // Getters

    static get VERSION() {
      return VERSION$1
    }

    // Public

    toggle() {
      let triggerChangeEvent = true;
      let addAriaPressed = true;
      const rootElement = $__default["default"](this._element).closest(SELECTOR_DATA_TOGGLES)[0];

      if (rootElement) {
        const input = this._element.querySelector(SELECTOR_INPUT);

        if (input) {
          if (input.type === 'radio') {
            if (input.checked && this._element.classList.contains(CLASS_NAME_ACTIVE)) {
              triggerChangeEvent = false;
            } else {
              const activeElement = rootElement.querySelector(SELECTOR_ACTIVE);

              if (activeElement) {
                $__default["default"](activeElement).removeClass(CLASS_NAME_ACTIVE);
              }
            }
          }

          if (triggerChangeEvent) {
            // if it's not a radio button or checkbox don't add a pointless/invalid checked property to the input
            if (input.type === 'checkbox' || input.type === 'radio') {
              input.checked = !this._element.classList.contains(CLASS_NAME_ACTIVE);
            }

            if (!this.shouldAvoidTriggerChange) {
              $__default["default"](input).trigger('change');
            }
          }

          input.focus();
          addAriaPressed = false;
        }
      }

      if (!(this._element.hasAttribute('disabled') || this._element.classList.contains('disabled'))) {
        if (addAriaPressed) {
          this._element.setAttribute('aria-pressed', !this._element.classList.contains(CLASS_NAME_ACTIVE));
        }

        if (triggerChangeEvent) {
          $__default["default"](this._element).toggleClass(CLASS_NAME_ACTIVE);
        }
      }
    }

    dispose() {
      $__default["default"].removeData(this._element, DATA_KEY$1);
      this._element = null;
    }

    // Static

    static _jQueryInterface(config, avoidTriggerChange) {
      return this.each(function () {
        const $element = $__default["default"](this);
        let data = $element.data(DATA_KEY$1);

        if (!data) {
          data = new Button(this);
          $element.data(DATA_KEY$1, data);
        }

        data.shouldAvoidTriggerChange = avoidTriggerChange;

        if (config === 'toggle') {
          data[config]();
        }
      })
    }
  }

  /**
   * ------------------------------------------------------------------------
   * Data Api implementation
   * ------------------------------------------------------------------------
   */

  $__default["default"](document)
    .on(EVENT_CLICK_DATA_API$1, SELECTOR_DATA_TOGGLE_CARROT, event => {
      let button = event.target;
      const initialButton = button;

      if (!$__default["default"](button).hasClass(CLASS_NAME_BUTTON)) {
        button = $__default["default"](button).closest(SELECTOR_BUTTON)[0];
      }

      if (!button || button.hasAttribute('disabled') || button.classList.contains('disabled')) {
        event.preventDefault(); // work around Firefox bug #1540995
      } else {
        const inputBtn = button.querySelector(SELECTOR_INPUT);

        if (inputBtn && (inputBtn.hasAttribute('disabled') || inputBtn.classList.contains('disabled'))) {
          event.preventDefault(); // work around Firefox bug #1540995
          return
        }

        if (initialButton.tagName === 'INPUT' || button.tagName !== 'LABEL') {
          Button._jQueryInterface.call($__default["default"](button), 'toggle', initialButton.tagName === 'INPUT');
        }
      }
    })
    .on(EVENT_FOCUS_BLUR_DATA_API, SELECTOR_DATA_TOGGLE_CARROT, event => {
      const button = $__default["default"](event.target).closest(SELECTOR_BUTTON)[0];
      $__default["default"](button).toggleClass(CLASS_NAME_FOCUS, /^focus(in)?$/.test(event.type));
    });

  $__default["default"](window).on(EVENT_LOAD_DATA_API, () => {
    // ensure correct active class is set to match the controls' actual values/states

    // find all checkboxes/readio buttons inside data-toggle groups
    let buttons = [].slice.call(document.querySelectorAll(SELECTOR_DATA_TOGGLES_BUTTONS));
    for (let i = 0, len = buttons.length; i < len; i++) {
      const button = buttons[i];
      const input = button.querySelector(SELECTOR_INPUT);
      if (input.checked || input.hasAttribute('checked')) {
        button.classList.add(CLASS_NAME_ACTIVE);
      } else {
        button.classList.remove(CLASS_NAME_ACTIVE);
      }
    }

    // find all button toggles
    buttons = [].slice.call(document.querySelectorAll(SELECTOR_DATA_TOGGLE$1));
    for (let i = 0, len = buttons.length; i < len; i++) {
      const button = buttons[i];
      if (button.getAttribute('aria-pressed') === 'true') {
        button.classList.add(CLASS_NAME_ACTIVE);
      } else {
        button.classList.remove(CLASS_NAME_ACTIVE);
      }
    }
  });

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $__default["default"].fn[NAME$1] = Button._jQueryInterface;
  $__default["default"].fn[NAME$1].Constructor = Button;
  $__default["default"].fn[NAME$1].noConflict = () => {
    $__default["default"].fn[NAME$1] = JQUERY_NO_CONFLICT$1;
    return Button._jQueryInterface
  };

  /**
   * --------------------------------------------------------------------------
   * Bootstrap (v4.6.0): util.js
   * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
   * --------------------------------------------------------------------------
   */

  /**
   * ------------------------------------------------------------------------
   * Private TransitionEnd Helpers
   * ------------------------------------------------------------------------
   */

  const TRANSITION_END = 'transitionend';
  const MAX_UID = 1000000;
  const MILLISECONDS_MULTIPLIER = 1000;

  // Shoutout AngusCroll (https://goo.gl/pxwQGp)
  function toType(obj) {
    if (obj === null || typeof obj === 'undefined') {
      return `${obj}`
    }

    return {}.toString.call(obj).match(/\s([a-z]+)/i)[1].toLowerCase()
  }

  function getSpecialTransitionEndEvent() {
    return {
      bindType: TRANSITION_END,
      delegateType: TRANSITION_END,
      handle(event) {
        if ($__default["default"](event.target).is(this)) {
          return event.handleObj.handler.apply(this, arguments) // eslint-disable-line prefer-rest-params
        }

        return undefined
      }
    }
  }

  function transitionEndEmulator(duration) {
    let called = false;

    $__default["default"](this).one(Util.TRANSITION_END, () => {
      called = true;
    });

    setTimeout(() => {
      if (!called) {
        Util.triggerTransitionEnd(this);
      }
    }, duration);

    return this
  }

  function setTransitionEndSupport() {
    $__default["default"].fn.emulateTransitionEnd = transitionEndEmulator;
    $__default["default"].event.special[Util.TRANSITION_END] = getSpecialTransitionEndEvent();
  }

  /**
   * --------------------------------------------------------------------------
   * Public Util Api
   * --------------------------------------------------------------------------
   */

  const Util = {
    TRANSITION_END: 'bsTransitionEnd',

    getUID(prefix) {
      do {
        prefix += ~~(Math.random() * MAX_UID); // "~~" acts like a faster Math.floor() here
      } while (document.getElementById(prefix))

      return prefix
    },

    getSelectorFromElement(element) {
      let selector = element.getAttribute('data-target');

      if (!selector || selector === '#') {
        const hrefAttr = element.getAttribute('href');
        selector = hrefAttr && hrefAttr !== '#' ? hrefAttr.trim() : '';
      }

      try {
        return document.querySelector(selector) ? selector : null
      } catch (_) {
        return null
      }
    },

    getTransitionDurationFromElement(element) {
      if (!element) {
        return 0
      }

      // Get transition-duration of the element
      let transitionDuration = $__default["default"](element).css('transition-duration');
      let transitionDelay = $__default["default"](element).css('transition-delay');

      const floatTransitionDuration = parseFloat(transitionDuration);
      const floatTransitionDelay = parseFloat(transitionDelay);

      // Return 0 if element or transition duration is not found
      if (!floatTransitionDuration && !floatTransitionDelay) {
        return 0
      }

      // If multiple durations are defined, take the first
      transitionDuration = transitionDuration.split(',')[0];
      transitionDelay = transitionDelay.split(',')[0];

      return (parseFloat(transitionDuration) + parseFloat(transitionDelay)) * MILLISECONDS_MULTIPLIER
    },

    reflow(element) {
      return element.offsetHeight
    },

    triggerTransitionEnd(element) {
      $__default["default"](element).trigger(TRANSITION_END);
    },

    supportsTransitionEnd() {
      return Boolean(TRANSITION_END)
    },

    isElement(obj) {
      return (obj[0] || obj).nodeType
    },

    typeCheckConfig(componentName, config, configTypes) {
      for (const property in configTypes) {
        if (Object.prototype.hasOwnProperty.call(configTypes, property)) {
          const expectedTypes = configTypes[property];
          const value = config[property];
          const valueType = value && Util.isElement(value) ?
            'element' : toType(value);

          if (!new RegExp(expectedTypes).test(valueType)) {
            throw new Error(
              `${componentName.toUpperCase()}: ` +
              `Option "${property}" provided type "${valueType}" ` +
              `but expected type "${expectedTypes}".`)
          }
        }
      }
    },

    findShadowRoot(element) {
      if (!document.documentElement.attachShadow) {
        return null
      }

      // Can find the shadow root otherwise it'll return the document
      if (typeof element.getRootNode === 'function') {
        const root = element.getRootNode();
        return root instanceof ShadowRoot ? root : null
      }

      if (element instanceof ShadowRoot) {
        return element
      }

      // when we don't find a shadow root
      if (!element.parentNode) {
        return null
      }

      return Util.findShadowRoot(element.parentNode)
    },

    jQueryDetection() {
      if (typeof $__default["default"] === 'undefined') {
        throw new TypeError('Bootstrap\'s JavaScript requires jQuery. jQuery must be included before Bootstrap\'s JavaScript.')
      }

      const version = $__default["default"].fn.jquery.split(' ')[0].split('.');
      const minMajor = 1;
      const ltMajor = 2;
      const minMinor = 9;
      const minPatch = 1;
      const maxMajor = 4;

      if (version[0] < ltMajor && version[1] < minMinor || version[0] === minMajor && version[1] === minMinor && version[2] < minPatch || version[0] >= maxMajor) {
        throw new Error('Bootstrap\'s JavaScript requires at least jQuery v1.9.1 but less than v4.0.0')
      }
    }
  };

  Util.jQueryDetection();
  setTransitionEndSupport();

  /**
   * --------------------------------------------------------------------------
   * Bootstrap (v4.6.0): collapse.js
   * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
   * --------------------------------------------------------------------------
   */

  /**
   * ------------------------------------------------------------------------
   * Constants
   * ------------------------------------------------------------------------
   */

  const NAME = 'collapse';
  const VERSION = '4.6.0';
  const DATA_KEY = 'bs.collapse';
  const EVENT_KEY = `.${DATA_KEY}`;
  const DATA_API_KEY = '.data-api';
  const JQUERY_NO_CONFLICT = $__default["default"].fn[NAME];

  const Default = {
    toggle: true,
    parent: ''
  };

  const DefaultType = {
    toggle: 'boolean',
    parent: '(string|element)'
  };

  const EVENT_SHOW = `show${EVENT_KEY}`;
  const EVENT_SHOWN = `shown${EVENT_KEY}`;
  const EVENT_HIDE = `hide${EVENT_KEY}`;
  const EVENT_HIDDEN = `hidden${EVENT_KEY}`;
  const EVENT_CLICK_DATA_API = `click${EVENT_KEY}${DATA_API_KEY}`;

  const CLASS_NAME_SHOW = 'show';
  const CLASS_NAME_COLLAPSE = 'collapse';
  const CLASS_NAME_COLLAPSING = 'collapsing';
  const CLASS_NAME_COLLAPSED = 'collapsed';

  const DIMENSION_WIDTH = 'width';
  const DIMENSION_HEIGHT = 'height';

  const SELECTOR_ACTIVES = '.show, .collapsing';
  const SELECTOR_DATA_TOGGLE = '[data-toggle="collapse"]';

  /**
   * ------------------------------------------------------------------------
   * Class Definition
   * ------------------------------------------------------------------------
   */

  class Collapse {
    constructor(element, config) {
      this._isTransitioning = false;
      this._element = element;
      this._config = this._getConfig(config);
      this._triggerArray = [].slice.call(document.querySelectorAll(
        `[data-toggle="collapse"][href="#${element.id}"],` +
        `[data-toggle="collapse"][data-target="#${element.id}"]`
      ));

      const toggleList = [].slice.call(document.querySelectorAll(SELECTOR_DATA_TOGGLE));
      for (let i = 0, len = toggleList.length; i < len; i++) {
        const elem = toggleList[i];
        const selector = Util.getSelectorFromElement(elem);
        const filterElement = [].slice.call(document.querySelectorAll(selector))
          .filter(foundElem => foundElem === element);

        if (selector !== null && filterElement.length > 0) {
          this._selector = selector;
          this._triggerArray.push(elem);
        }
      }

      this._parent = this._config.parent ? this._getParent() : null;

      if (!this._config.parent) {
        this._addAriaAndCollapsedClass(this._element, this._triggerArray);
      }

      if (this._config.toggle) {
        this.toggle();
      }
    }

    // Getters

    static get VERSION() {
      return VERSION
    }

    static get Default() {
      return Default
    }

    // Public

    toggle() {
      if ($__default["default"](this._element).hasClass(CLASS_NAME_SHOW)) {
        this.hide();
      } else {
        this.show();
      }
    }

    show() {
      if (this._isTransitioning ||
        $__default["default"](this._element).hasClass(CLASS_NAME_SHOW)) {
        return
      }

      let actives;
      let activesData;

      if (this._parent) {
        actives = [].slice.call(this._parent.querySelectorAll(SELECTOR_ACTIVES))
          .filter(elem => {
            if (typeof this._config.parent === 'string') {
              return elem.getAttribute('data-parent') === this._config.parent
            }

            return elem.classList.contains(CLASS_NAME_COLLAPSE)
          });

        if (actives.length === 0) {
          actives = null;
        }
      }

      if (actives) {
        activesData = $__default["default"](actives).not(this._selector).data(DATA_KEY);
        if (activesData && activesData._isTransitioning) {
          return
        }
      }

      const startEvent = $__default["default"].Event(EVENT_SHOW);
      $__default["default"](this._element).trigger(startEvent);
      if (startEvent.isDefaultPrevented()) {
        return
      }

      if (actives) {
        Collapse._jQueryInterface.call($__default["default"](actives).not(this._selector), 'hide');
        if (!activesData) {
          $__default["default"](actives).data(DATA_KEY, null);
        }
      }

      const dimension = this._getDimension();

      $__default["default"](this._element)
        .removeClass(CLASS_NAME_COLLAPSE)
        .addClass(CLASS_NAME_COLLAPSING);

      this._element.style[dimension] = 0;

      if (this._triggerArray.length) {
        $__default["default"](this._triggerArray)
          .removeClass(CLASS_NAME_COLLAPSED)
          .attr('aria-expanded', true);
      }

      this.setTransitioning(true);

      const complete = () => {
        $__default["default"](this._element)
          .removeClass(CLASS_NAME_COLLAPSING)
          .addClass(`${CLASS_NAME_COLLAPSE} ${CLASS_NAME_SHOW}`);

        this._element.style[dimension] = '';

        this.setTransitioning(false);

        $__default["default"](this._element).trigger(EVENT_SHOWN);
      };

      const capitalizedDimension = dimension[0].toUpperCase() + dimension.slice(1);
      const scrollSize = `scroll${capitalizedDimension}`;
      const transitionDuration = Util.getTransitionDurationFromElement(this._element);

      $__default["default"](this._element)
        .one(Util.TRANSITION_END, complete)
        .emulateTransitionEnd(transitionDuration);

      this._element.style[dimension] = `${this._element[scrollSize]}px`;
    }

    hide() {
      if (this._isTransitioning ||
        !$__default["default"](this._element).hasClass(CLASS_NAME_SHOW)) {
        return
      }

      const startEvent = $__default["default"].Event(EVENT_HIDE);
      $__default["default"](this._element).trigger(startEvent);
      if (startEvent.isDefaultPrevented()) {
        return
      }

      const dimension = this._getDimension();

      this._element.style[dimension] = `${this._element.getBoundingClientRect()[dimension]}px`;

      Util.reflow(this._element);

      $__default["default"](this._element)
        .addClass(CLASS_NAME_COLLAPSING)
        .removeClass(`${CLASS_NAME_COLLAPSE} ${CLASS_NAME_SHOW}`);

      const triggerArrayLength = this._triggerArray.length;
      if (triggerArrayLength > 0) {
        for (let i = 0; i < triggerArrayLength; i++) {
          const trigger = this._triggerArray[i];
          const selector = Util.getSelectorFromElement(trigger);

          if (selector !== null) {
            const $elem = $__default["default"]([].slice.call(document.querySelectorAll(selector)));
            if (!$elem.hasClass(CLASS_NAME_SHOW)) {
              $__default["default"](trigger).addClass(CLASS_NAME_COLLAPSED)
                .attr('aria-expanded', false);
            }
          }
        }
      }

      this.setTransitioning(true);

      const complete = () => {
        this.setTransitioning(false);
        $__default["default"](this._element)
          .removeClass(CLASS_NAME_COLLAPSING)
          .addClass(CLASS_NAME_COLLAPSE)
          .trigger(EVENT_HIDDEN);
      };

      this._element.style[dimension] = '';
      const transitionDuration = Util.getTransitionDurationFromElement(this._element);

      $__default["default"](this._element)
        .one(Util.TRANSITION_END, complete)
        .emulateTransitionEnd(transitionDuration);
    }

    setTransitioning(isTransitioning) {
      this._isTransitioning = isTransitioning;
    }

    dispose() {
      $__default["default"].removeData(this._element, DATA_KEY);

      this._config = null;
      this._parent = null;
      this._element = null;
      this._triggerArray = null;
      this._isTransitioning = null;
    }

    // Private

    _getConfig(config) {
      config = {
        ...Default,
        ...config
      };
      config.toggle = Boolean(config.toggle); // Coerce string values
      Util.typeCheckConfig(NAME, config, DefaultType);
      return config
    }

    _getDimension() {
      const hasWidth = $__default["default"](this._element).hasClass(DIMENSION_WIDTH);
      return hasWidth ? DIMENSION_WIDTH : DIMENSION_HEIGHT
    }

    _getParent() {
      let parent;

      if (Util.isElement(this._config.parent)) {
        parent = this._config.parent;

        // It's a jQuery object
        if (typeof this._config.parent.jquery !== 'undefined') {
          parent = this._config.parent[0];
        }
      } else {
        parent = document.querySelector(this._config.parent);
      }

      const selector = `[data-toggle="collapse"][data-parent="${this._config.parent}"]`;
      const children = [].slice.call(parent.querySelectorAll(selector));

      $__default["default"](children).each((i, element) => {
        this._addAriaAndCollapsedClass(
          Collapse._getTargetFromElement(element),
          [element]
        );
      });

      return parent
    }

    _addAriaAndCollapsedClass(element, triggerArray) {
      const isOpen = $__default["default"](element).hasClass(CLASS_NAME_SHOW);

      if (triggerArray.length) {
        $__default["default"](triggerArray)
          .toggleClass(CLASS_NAME_COLLAPSED, !isOpen)
          .attr('aria-expanded', isOpen);
      }
    }

    // Static

    static _getTargetFromElement(element) {
      const selector = Util.getSelectorFromElement(element);
      return selector ? document.querySelector(selector) : null
    }

    static _jQueryInterface(config) {
      return this.each(function () {
        const $element = $__default["default"](this);
        let data = $element.data(DATA_KEY);
        const _config = {
          ...Default,
          ...$element.data(),
          ...(typeof config === 'object' && config ? config : {})
        };

        if (!data && _config.toggle && typeof config === 'string' && /show|hide/.test(config)) {
          _config.toggle = false;
        }

        if (!data) {
          data = new Collapse(this, _config);
          $element.data(DATA_KEY, data);
        }

        if (typeof config === 'string') {
          if (typeof data[config] === 'undefined') {
            throw new TypeError(`No method named "${config}"`)
          }

          data[config]();
        }
      })
    }
  }

  /**
   * ------------------------------------------------------------------------
   * Data Api implementation
   * ------------------------------------------------------------------------
   */

  $__default["default"](document).on(EVENT_CLICK_DATA_API, SELECTOR_DATA_TOGGLE, function (event) {
    // preventDefault only for <a> elements (which change the URL) not inside the collapsible element
    if (event.currentTarget.tagName === 'A') {
      event.preventDefault();
    }

    const $trigger = $__default["default"](this);
    const selector = Util.getSelectorFromElement(this);
    const selectors = [].slice.call(document.querySelectorAll(selector));

    $__default["default"](selectors).each(function () {
      const $target = $__default["default"](this);
      const data = $target.data(DATA_KEY);
      const config = data ? 'toggle' : $trigger.data();
      Collapse._jQueryInterface.call($target, config);
    });
  });

  /**
   * ------------------------------------------------------------------------
   * jQuery
   * ------------------------------------------------------------------------
   */

  $__default["default"].fn[NAME] = Collapse._jQueryInterface;
  $__default["default"].fn[NAME].Constructor = Collapse;
  $__default["default"].fn[NAME].noConflict = () => {
    $__default["default"].fn[NAME] = JQUERY_NO_CONFLICT;
    return Collapse._jQueryInterface
  };

  /**
   * File skip-link-focus-fix.js.
   *
   * Helps with accessibility for keyboard only users.
   *
   * Learn more: https://git.io/vWdr2
   */
  (function () {
    var isWebkit = navigator.userAgent.toLowerCase().indexOf('webkit') > -1,
        isOpera = navigator.userAgent.toLowerCase().indexOf('opera') > -1,
        isIe = navigator.userAgent.toLowerCase().indexOf('msie') > -1;

    if ((isWebkit || isOpera || isIe) && document.getElementById && window.addEventListener) {
      window.addEventListener('hashchange', function () {
        var id = location.hash.substring(1),
            element;

        if (!/^[A-z0-9_-]+$/.test(id)) {
          return;
        }

        element = document.getElementById(id);

        if (element) {
          if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
            element.tabIndex = -1;
          }

          element.focus();
        }
      }, false);
    }
  })();

  // Add your custom JS here.
  jQuery(document).ready(function ($) {
    var body = $('body');
    $('#main-nav').attr('class');
    jQuery(window).scroll(function () {
      var scroll = $(window).scrollTop();

      if (scroll >= 25) {
        body.addClass("scrolled");
        // $('#main-nav').addClass('navbar-light');
      } else {
        body.removeClass("scrolled");
      }

      if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
        body.addClass("near-bottom");
      } else {
        body.removeClass("near-bottom");
      }
    });
    $('#navbarNavDropdown').on('show.bs.collapse', function () {
      body.addClass('menu-open');
    });
    $('#navbarNavDropdown').on('hide.bs.collapse', function () {
      body.removeClass('menu-open');
    });
    $('.sub-menu-toggler').click(function (e) {
      e.preventDefault();
      $(this).parent().next().toggleClass('show');
      $(this).parent().parent().toggleClass('show');
    });
  });
  /* Carruseles */

  jQuery('.slick-slider').slick({
    dots: true,
    arrows: true,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true
  });
  jQuery('.slick-carousel, .wp-block-group.is-style-slick-carousel > .wp-block-group__inner-container, .wp-block-gallery.is-style-slick-carousel').slick({
    dots: false,
    arrows: true,
    infinite: true,
    speed: 300,
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    responsive: [{
      breakpoint: 992,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }, {
      breakpoint: 576,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    } // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
    ]
  }); // jQuery('.wp-block-group.is-layout-flex.is-style-slick-carousel-logos, .wp-block-group.is-style-slick-carousel-logos > .wp-block-group__inner-container, .wp-block-gallery.is-style-slick-carousel-logos').slick({
  //   dots: true,
  //   arrows: true,
  //   infinite: true,
  //   speed: 300,
  //   slidesToShow: 6,
  //   slidesToScroll: 6,
  //   autoplay: false,
  //   responsive: [
  //     {
  //       breakpoint: 992,
  //       settings: {
  //         slidesToShow: 4,
  //         slidesToScroll: 4
  //       }
  //     },
  //     {
  //       breakpoint: 782,
  //       settings: {
  //         slidesToShow: 3,
  //         slidesToScroll: 3
  //       }
  //     },
  //     {
  //       breakpoint: 600,
  //       settings: {
  //         slidesToShow: 2,
  //         slidesToScroll: 2
  //       }
  //     }    // You can unslick at a given breakpoint now by adding:
  //     // settings: "unslick"
  //     // instead of a settings object
  //   ]
  // });
  // REPRODUCIR VÍDEO CUANDO LLEGAS A ÉL
  // (function($) {
  //   $(document).ready(function() { 
  //     var $win = $(window);
  //     var elementTop, elementBottom, viewportTop, viewportBottom;
  //     function isScrolledIntoView(elem) {
  //       elementTop = $(elem).offset().top;
  //       elementBottom = elementTop + $(elem).outerHeight();
  //       viewportTop = $win.scrollTop();
  //       viewportBottom = viewportTop + $win.height();
  //       return (elementBottom > viewportTop && elementTop + 300 < viewportBottom);
  //     }
  //     if($('video').length){
  //       var loadVideo;
  //       $('video').each(function(){
  //         $(this).attr('webkit-playsinline', '');
  //         $(this).attr('playsinline', '');
  //         $(this).attr('muted', 'muted');
  //         $(this).attr('id','loadvideo');
  //         loadVideo = document.getElementById('loadvideo');
  //         loadVideo.load();
  //       });
  //       $win.scroll(function () { // video to play when is on viewport 
  //         $('video').each(function(){
  //           if (isScrolledIntoView(this) == true && $(this)[0].currentTime < $(this)[0].duration ) {
  //               $(this)[0].play();
  //           } else {
  //               $(this)[0].pause();
  //           }
  //         });
  //       });  // video to play when is on viewport
  //     } // end .field--name-field-video
  //    });
  // })(jQuery);

  exports.Button = Button;
  exports.Collapse = Collapse;
  exports.Util = Util;

  Object.defineProperty(exports, '__esModule', { value: true });

}));
//# sourceMappingURL=child-theme.js.map
