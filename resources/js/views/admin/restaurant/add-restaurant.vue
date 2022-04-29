<script>
import axios from "axios";
import _ from "lodash";

import vue2Dropzone from "vue2-dropzone";
import Multiselect from "vue-multiselect";

import Layout from "../../../layouts/admin/main";
import PageHeader from "../../../components/page-header"; 
/**
 * Add-Restaurant component
 */
export default {
  props: {
    access_token: {
      type: String,
      require: true,
    },
  },
  components: {
    vueDropzone: vue2Dropzone,
    Multiselect,
    Layout,
    PageHeader,
  },
  data() {
    return { 

      APP_URL: process.env.APP_URL,
      title: "Add Restaurant",
      items: [
        {
          text: "Add Restaurant",
          active: true,
        }
        ,
      ],
      dropzoneOptions: {
        url: "https://httpbin.org/post",
        acceptedFiles: "image/*",
        method: "POST",
        thumbnailHeight: 100,
        accept: (file) => {
          this.onAccept(file);
        },
      },
      dropzoneMenuOptions: {
        url: "https://httpbin.org/post",
        acceptedFiles: "image/*",
        method: "POST",
        thumbnailHeight: 100,
        accept: (file) => {
          this.onAcceptMenu(file);
        },
      },
      formData: new FormData(),
      restaurant : {
      information_tags:'',
      country_id:'',
      category_id:'',
      password:null,
      twitter_link: '',
      facebook_link: '',
      instagram_link: '',
      website_link: '',
        email : "", 
        address:"",
        phone: "",
        first_name: "",
        latitude: "",
        longitude: "" ,
        opening_time: '',
        closing_time: '',
      },
      menuFile: "",
      menuImage: "",
      image: "",
      file: "",
      value: null, 
      options: [   
        "Alabama",
        "Arkansas",
        "Illinois",
        "Iowa",
      ],
      countries : [
        {
            "id": 1,
            "name": "Afghanistan",
            "code": "AF"
        },
        {
            "id": 2,
            "name": "Åland Islands",
            "code": "AX"
        },
        {
            "id": 3,
            "name": "Albania",
            "code": "AL"
        }
        ],
        categories:[
        {
            id: 1,
            name: "omnis 0", 
        },
        {
            id: 2,
            name: "id 1", 
        },
        {
            id: 3,
            name: "tempore 2", 
        }
        ],
      submitted: false,
      formData: {
        first_name: null,
        latitude: null,
        longitude: null,
        opening_time: null,
        closing_time: null,
        image: null,
      },
      avatar: null,
      avatarName: null,
      menuAvatar: null,
      menuAvatarName: null,
      showForm: true,
      user: null,
      errors: null,
    };
  },

  methods: {
    onAccept(file) {
      this.image = file.name;
      this.file = file;
    },
    fileAdded(file) {
      this.avatar = file;
      this.avatarName = file.name;
    },

    onAcceptMenu(menuFile) {
      this.menuImage = menuFile.name;
      this.menuFile = menuFile;
    },
    menuFileAdded(menuFile) {
      this.menuAvatar = menuFile;
      this.menuAvatarName = menuFile.name;
    },

    restaurantAdd() {
      this.submitted = true;
      this.errors = []; 
        
        let formData = new FormData();

        Object.keys(this.restaurant).forEach((key) => {
          console.log(this.restaurant[key]);
          formData.append(key, this.restaurant[key]);
        }); 
        if(this.file && this.image)
        formData.append("photo", this.file, this.image);

        if(this.menuFile && this.menuImage)
        formData.append("menu", this.menuFile, this.menuImage);

        //** Add Restaurant in api using post method *//
        axios({
          method: "post",
          url: "http://localhost:8000/api/admin/restaurant",
          data: formData,
          headers: {
            "Content-Type": "multipart/form-data",
            Authorization: "Bearer " + this.access_token,
          },
        })
          .then((res) => {
            if(res.status==200||res.data.success){
                window.location.replace("http://127.0.0.1:8000/admin/restaurant");
            } 
          })
          .catch((err) => {
            if (err.response.status === 422) {
              this.errors = err.response.data.errors;
            }
          });
       
    },
  },
};
</script>

<template>
  <Layout>
    <PageHeader :title="title" :items="items" />

    <div class="row">
      <form @submit.prevent="restaurantAdd">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Account Creations  </h4>
              <p class="card-title-desc">Login Informations</p>
              <div class="row">
                <div class="col-sm-6">
                  <div class="mb-3">
                    <label for="first_name">Restaurant Name</label>
                    <input
                      id="first_name"
                      v-model="restaurant.first_name"
                      name="first_name"
                      type="text"
                      class="form-control"
                      :class="{
                        'is-invalid': errors && errors.first_name,
                      }"
                    />
                    <div
                      v-if="errors && errors.first_name"
                      class="invalid-feedback"
                    >
                      Restaurant Name is required.
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="metatitle">Email</label>
                    <input
                      id="email"
                      name="email"
                      type="text"
                      v-model="restaurant.email"
                      :class="{
                        'is-invalid': errors && errors.email,
                      }"
                      class="form-control" 
                    />
                      <div v-if="errors && errors.email" class="invalid-feedback">
                       {{errors.email[0]}}
                    </div>
                   
                  </div>
                  <div class="mb-3">
                    <label for="password">Password</label>
                    <input
                      id="password"
                      name="password"
                      type="password"
                      class="form-control"
                    />
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="mb-3">
                    <label class="control-label">Country</label>
                    <b-form-select
                      v-model="restaurant.country_id" 
                      :options="countries" 
                      value-field="id"
                      text-field="name"
                      
                      class="form-control"
                       :class="{
                        'is-invalid': errors && errors.country_id,
                      }"
                    ></b-form-select>
                             <div
                      v-if="errors && errors.country_id"
                      class="invalid-feedback"
                    >
                     Please Select Country.
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="phone">Phone</label>
                    <input
                      id="phone"
                      v-model="restaurant.phone"
                      class="form-control"
                      :class="{
                        'is-invalid': errors && errors.phone,
                      }"
                    />
                      <div v-if="errors && errors.phone" class="invalid-feedback">
                       {{ errors.phone[0] }}
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="address">Address</label>
                    <textarea
                      id="address"
                      class="form-control"
                      rows="2"
                      v-model="restaurant.address"
                      :class="{
                        'is-invalid': errors && errors.address,
                      }"
                    ></textarea>
                      <div v-if="errors && errors.address" class="invalid-feedback">
                      Address is required.
                    </div>
                  </div>
                </div>
              </div>

              <!-- <button type="submit" class="btn btn-primary mr-1">
                                Save Changes
                            </button>
                            <button type="submit" class="btn btn-secondary">
                                Cancel
                            </button> -->
            </div>
          </div>

          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Restaurant Basic Information</h4>
              <p class="card-title-desc">Fill all information below</p>

              <!-- THIS SECTION IS FOR ERRORS THAT WOULD COME FROM API -->



              <div class="row">
                <div class="col-sm-6">
                  <div class="mb-3">
                    <label for="restaurantname">Latitude</label>
                    <input
                      id="restaurantname"
                      v-model="restaurant.latitude"
                      name="name"
                      type="number"
                      class="form-control"
                      :class="{
                        'is-invalid': errors && errors.latitude,
                      }"
                    />
                    <div
                      v-if="errors && errors.latitude"
                      class="invalid-feedback"
                    >
                      Latitude is required.
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="restaurantname">longitude</label>
                    <input
                      id="restaurantname"
                      v-model="restaurant.longitude"
                      name="name"
                      type="number"
                      class="form-control"
                      :class="{
                        'is-invalid': errors && errors.longitude,
                      }"
                    />
                    <div
                      v-if="errors && errors.longitude"
                      class="invalid-feedback"
                    >
                      longitude is required.
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="opening_time">Opening Time</label>
                    <input
                      id="opening_time"
                      v-model="restaurant.opening_time"
                      name="opening time"
                      type="time"
                      class="form-control"
                      :class="{
                        'is-invalid': errors && errors.opening_time,
                      }"
                    />
                    <div
                      v-if="errors && errors.opening_time"
                      class="invalid-feedback"
                    >
                    <div v-for="error in errors.opening_time " :key="error">

                      {{ error }}
                    </div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="closing_time">closing time</label>
                    <input
                      id="closing_time"
                      v-model="restaurant.closing_time"
                      name="closing_time"
                      type="time"
                      class="form-control"
                      :class="{
                        'is-invalid': errors && errors.closing_time,
                      }"
                    />
                    <div
                      v-if="errors && errors.closing_time"
                      class="invalid-feedback"
                    >
                      Restaurant closing time is required.
                    </div>
                  </div>

                  <label>Restaurant Photo 
                  </label>
                  <vue-dropzone
                    id="image"
                    ref="myVueDropzone" 
                    :use-custom-slot="true"
                    :options="dropzoneOptions"
                    :class="{ 'is-invalid': errors && errors.photo, }"
                  >
                    <div class="dropzone-custom-content">
                      <div class="mb-1">
                        <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                      </div>
                      <h4>Drop files here or click to upload.</h4>
                    </div>
                  </vue-dropzone>
                      <div
                      v-if="errors && errors.photo"
                      class="invalid-feedback"
                    >
                     Photo is required.
                    </div>
                </div>

                <div class="col-sm-6">
                  <div class="mb-3">
                    <label class="control-label">Category </label>
                    <b-form-select
                      v-model="restaurant.category_id"
                      :options="categories"
                      value-field="id"
                       :class="{
                        'is-invalid': errors && errors.category_id,
                      }" 
                      class="form-control"
                      text-field="name"
                    ></b-form-select>
                    <div
                      v-if="errors && errors.category_id"
                      class="invalid-feedback"
                    >
                      Please select a category.
                    </div>
                  </div>

                  <div class="mb-3">
                    <label class="control-label">Informational Tags {{ restaurant.information_tags }}</label>
                    <b-form-tags
                      v-model="restaurant.information_tags"
                      :options="options"
                      class="form-control"
                    ></b-form-tags>
                  </div>

                  <label>Menu Images</label>
                  <vue-dropzone
                    id="menu"
                    ref="myVueDropzone"
                    :use-custom-slot="true"
                    :options="dropzoneMenuOptions"
                  > 
                   <div class="dropzone-custom-content">
                      <div class="mb-1">
                        <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                      </div>
                      <h4>Drop files here or click to upload.</h4>
                    </div>
                  </vue-dropzone>
                </div>
              </div>
              <!-- <div class="mt-2">
                                <button
                                    type="submit"
                                    class="btn btn-primary me-1"
                                >
                                    Save Changes
                                </button>
                                <button type="submit" class="btn btn-secondary">
                                    Cancel
                                </button>
                            </div> -->
            </div>
          </div>

          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Social Connect</h4>
              <p class="card-title-desc">Past social links below</p>

              <div class="row">
                <div class="col-sm-6">
                  <div class="mb-3">
                    <label for="metatitle">Instagram link</label>
                    <input
                     v-model="restaurant.instagram_link"
                      id="instagram_link"
                      name="instagram_link"
                      type="link"
                      class="form-control"
                    />
                  </div>

                  <div class="mb-3">
                    <label for="metatitle">Facebook link</label>
                    <input
                    v-model="restaurant.facebook_link"
                      id="facebook_link"
                      name="facebook_link"
                      type="link"
                      class="form-control"
                    />
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="mb-3">
                    <label for="metatitle">Twitter link</label>
                    <input
                    v-model="restaurant.twitter_link"
                      id="twitter_link"
                      name="twitter_link"
                      type="link"
                      class="form-control"
                    />
                  </div>

                  <div class="mb-3">
                    <label for="metatitle">Website link</label>
                    <input
                    v-model="restaurant.website_link"
                      id="website_link"
                      name="website_link"
                      type="link"
                      class="form-control"
                    />
                  </div>
                </div>
              </div>
              <div> 
              </div>
              <div v-if="errors">
                <div
                  v-for="(error, index) in errors"
                  :key="index"
                  class="alert alert-danger"
                >
                {{error[0]}}
                </div>
              </div>


              <button type="submit" class="btn btn-primary mr-1">
                Save Changes
              </button>
              <button type="submit" class="btn btn-secondary">Cancel</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- end row -->
  </Layout>
</template>
