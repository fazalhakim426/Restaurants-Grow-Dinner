
<script>
import i18n from "../../../i18n";
import simplebar from "simplebar-vue";

/**
 * Nav-bar Component
 */
export default {
  data() {
    return {
      languages: [ 
      ],
      lan: i18n.locale,
      text: null,
      flag: null,
      value: null,
    };
  },
  components: { simplebar },
  mounted() {
    this.value = this.languages.find((x) => x.language === i18n.locale);
    this.text = this.value.title;
    this.flag = this.value.flag;
  },
  methods: {
    toggleMenu() {
      this.$parent.toggleMenu();
    },
    toggleRightSidebar() {
      this.$parent.toggleRightSidebar();
    },
    initFullScreen() {
      document.body.classList.toggle("fullscreen-enable");
      if (
        !document.fullscreenElement &&
        /* alternative standard method */ !document.mozFullScreenElement &&
        !document.webkitFullscreenElement
      ) {
        // current working methods
        if (document.documentElement.requestFullscreen) {
          document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
          document.documentElement.webkitRequestFullscreen(
            Element.ALLOW_KEYBOARD_INPUT
          );
        }
      } else {
        if (document.cancelFullScreen) {
          document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        }
      }
    },
    setLanguage(locale, country, flag) {
      this.lan = locale;
      this.text = country;
      this.flag = flag;
      i18n.locale = locale;
      localStorage.setItem("locale", locale);
    },
  },
};
</script>

<template>
  <header id="page-topbar">
    <div class="navbar-header">
      <div class="d-flex">
        <!-- LOGO -->
        <div class="navbar-brand-box">
          <a href="/" class="logo logo-dark">
            <span class="logo-sm">
              <img src="/images/logo.png" alt height="30" />
            </span>
            <span class="logo-lg">
              <img src="/images/logo-dark.png" alt height="27" />
            </span>
          </a>

          <a href="/" class="logo logo-light">
            <span class="logo-sm">
              <img src="/images/logo-light.png" alt height="30" />
            </span>
            <span class="logo-lg">
              <img src="/images/logo-light.png" alt height="27" />
            </span>
          </a>
        </div>

        <button
          id="vertical-menu-btn"
          type="button"
          class="btn btn-sm px-3 font-size-16 header-item"
          @click="toggleMenu"
        >
          <i class="fa fa-fw fa-bars"></i>
        </button>
 
      </div>

      <div class="d-flex"> 
 
 

        <b-dropdown right variant="black" toggle-class="header-item" menu-class="dropdown-menu-end">
          <template v-slot:button-content>
            <img
              class="rounded-circle header-profile-user"
              src="/images/users/avatar-1.jpg"
              alt="Header Avatar"
            />
            <span class="d-none d-xl-inline-block ms-1">{{ $t('navbar.dropdown.henry.text')}}</span>
            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
          </template>
          <!-- item-->
      
          <b-dropdown-item href="/contacts/profile">
            <i class="bx bx-user font-size-16 align-middle me-1"></i>
            {{ $t('navbar.dropdown.henry.list.profile') }}
          </b-dropdown-item>
          
          <b-dropdown-divider></b-dropdown-divider>
          <a href="/logout" class="dropdown-item text-danger">
            <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
            {{ $t('navbar.dropdown.henry.list.logout') }}
          </a>
        </b-dropdown>

        <div class="dropdown d-inline-block">
          <button
            type="button"
            class="btn header-item noti-icon right-bar-toggle toggle-right"
            @click="toggleRightSidebar"
          >
            <i class="bx bx-cog bx-spin toggle-right"></i>
          </button>
        </div>
      </div>
    </div>
  </header>
</template>
