
<script>
import i18n from "../../../i18n";
import simplebar from "simplebar-vue";
import axios from 'axios';
export default {
    props: {
    access_token : {
      type: String, 
      required:true, 
      // default:'...'
    },
  },
  
  data() {
    return {  
      user:{},
    };
  },
  components: { simplebar },
  mounted() {
    console.log(
      'access_token',
      this.access_token) 
        alert(3);
    this.getUser()
  },
  methods: {
      getUser(){
             axios({
              method: 'get',
              url : process.env.MIX_API_URL+"user",
              headers: {
                  Authorization: 'Bearer ' + this.access_token
              }
             }).then((res) => {
            if(res.status==200||res.data.success){  
                 this.user = res.data
                 }
             })
        },
    toggleMenu() {
      this.$parent.toggleMenu();
    },
    toggleRightSidebar() {
      this.$parent.toggleRightSidebar();
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
              <img src="/images/logo.png" alt height="60" />
            </span>
            <span class="logo-lg">
              <img src="/images/logo-dark.png" alt height="45"  />
            </span>
          </a>

          <a href="/" class="logo logo-light">
            <span class="logo-sm">
              <img src="/images/logo-light.png" alt height="60" />
            </span>
            <span class="logo-lg">
              <img src="/images/logo-light.png" alt height="45"  />
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
            <!-- <img
              class="rounded-circle header-profile-user"
              src="/images/users/avatar-1.jpg"
              alt="Header Avatar"
            /> -->
            <span class="d-none d-xl-inline-block ms-1">{{ user.first_name }}</span>
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
