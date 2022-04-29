<script>
import Layout from "../../../layouts/admin/main";
import PageHeader from "../../../components/page-header";
import axios from 'axios'  

import vue2Dropzone from "vue2-dropzone";
import { required } from "vuelidate/lib/validators";
export default {
  
  components: {
    vueDropzone: vue2Dropzone,
     Layout, PageHeader },
  props: {
    id: {
      type: String,
      required: false,
    },
     access_token: {
      type: String,
      require: true,
    },
  },
  mounted() {
    const queryString = window.location.search; 
    const urlParams = new URLSearchParams(queryString); 
    this.restaurant_id = urlParams.get('restaurant_id')
    this.getRestaurant(this.restaurant_id);
  },
  data() {
    return {
        formData: new FormData(),
      errors:[],
      image: "",
      file: "",

      tables : [ ],
      restaurant : {},
      restaurant_id:-1,
      showModal: false,
      showEditModal: false,
      submitted: false,
      table: {
        name: "", 
        number: "",
        max_person: "", 
        min_person: "",
        description: "", 
      }, 
       dropzoneOptions: {
        url: "https://httpbin.org/post", 
        method: "POST", 
        maxFiles: 1, 
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        thumbnailHeight: 100,
        accept: (file) => {
          this.onAccept(file);
        },
      },
 
      title: "Restaurant Detail",
      items: [
        {
          text: "Restaurants",
          href: "/admin/restaurant",
        },
        {
          text: "Restaurant Detail",
          active: true,
        },
      ],
    };
  },
    validations: {
    table: {  
      name: { required },
      number: { required }, 
      min_person: { required },
      max_person: { required }, 
      description: { required}

    }, 
  },
  created() {
    // this.productDetail = this.restaurantData.filter((product) => {
    //   return product.id === parseInt(this.id || "1");
    // });
  },
  methods: { 
    deleteRestaurant(id){
           axios({
          method: "delete",
          url: "http://localhost:8000/api/admin/restaurant/"+id, 
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
    editTableModel(table){  
          this.table.id          =  table.id
          this.table.name        =  table.name
          this.table.number      =  table.number
          this.table.min_person  =  table.min_person
          this.table.max_person  =  table.max_person
          this.table.description =  table.description
          
      this.showEditModal = true

    },
    deleteTable(id){
         //** Add Restaurant in api using post method *//
        axios({
          method: "delete",
          url: "http://localhost:8000/api/admin/table/"+id, 
          headers: {
            "Content-Type": "multipart/form-data",
            Authorization: "Bearer " + this.access_token,
          },
        })
          .then((res) => {
            if(res.status==200||res.data.success){ 
              this.getRestaurant()   
            } 
          })
          .catch((err) => {
            if (err.response.status === 422) {
              this.errors = err.response.data.errors;
            }
          });
    },
      onAccept(file) {
      this.image = file.name;
      this.file = file;
    }, 
    addTable(e) {
      this.errors=[]
      this.submitted = true;

      // stop here if form is invalid
      this.$v.$touch();
      if (this.$v.$invalid) { 
        return;
      } 
      { 
        let formData = new FormData();

        Object.keys(this.table).forEach((key) => { 
          formData.append(key, this.table[key]);
        }); 
        if(this.file && this.image)
        formData.append("photo", this.file, this.image);
        formData.append("restaurant_id", this.restaurant_id);
 
        //** Add Restaurant in api using post method *//
        axios({
          method: "post",
          url: "http://localhost:8000/api/admin/table",
          data: formData,
          headers: {
            "Content-Type": "multipart/form-data",
            Authorization: "Bearer " + this.access_token,
          },
        })
          .then((res) => {
            if(res.status==200||res.data.success){ 
              this.getRestaurant()  
              this.showModal = false;
              this.table = [];
              this.image = "";
              this.file = "";
            } 
          })
          .catch((err) => {
            if (err.response.status === 422) {
              this.errors = err.response.data.errors;
            }
          });
      }
      this.submitted = false;
    },
    editTable(e) {
      this.errors=[]
      this.submitted = true;

      // stop here if form is invalid
      this.$v.$touch();
      if (this.$v.$invalid) { 
        return;
      } 
      { 
        let formData = new FormData(); 
        Object.keys(this.table).forEach((key) => { 
          formData.append(key, this.table[key]); 
        }); 
        if(this.file && this.image)
        formData.append("photo", this.file, this.image);  
        //** edit Restaurant in api using put method *//
        axios({
          method: "post",
          url: "http://localhost:8000/api/admin/table-update/"+this.table.id,
          data: formData,
          headers: {
            "Content-Type": "multipart/form-data",
            Authorization: "Bearer " + this.access_token,
          },
        })
          .then((res) => {
            if(res.status==200||res.data.success){ 
              this.getRestaurant()  
              this.showEditModal = false;
              this.table = [];
              this.image = "";
              this.file = "";
            } 
          })
          .catch((err) => {
            if (err.response.status === 422) {
              this.errors = err.response.data.errors;
            }
          });
      }
      this.submitted = false;
    }, 
    getRestaurant(){
          axios({
          method: "get",
          url: "http://localhost:8000/api/admin/restaurant/"+this.restaurant_id+'/table', 
          headers: {
            "Content-Type": "multipart/form-data",
            Authorization: "Bearer " + this.access_token,
          },
        }) .then((response) => {  
                this.tables = response.data.data;
                this.restaurant = response.data.restaurant; 
            })
            .catch((err) => {
                console.log(err);
            });
    },
    imageShow(event) {
      const image = event.target.src;
      const expandImg = document.getElementById("expandedImg");
      expandImg.src = image;
    },
  },
};
</script>

<template>
  <Layout>
    <PageHeader :title="title" :items="items" />
    <div >
              <div class="text-sm-end">
                <a :href="'/admin/restaurant-orders?restaurant_id='+restaurant_id">
                <button
                  type="button"
                  class="btn btn-success btn-rounded mb-2 me-2"
                
                >
                  <i class="mdi mdi-plus me-1"></i> View Orders
                </button>
                </a> 
                <a :href="'/admin/edit-restaurant?restaurant_id='+restaurant_id">
                <button
                  type="button"
                  class="btn btn-primary btn-rounded mb-2 me-2"
                
                >
                  <i class="mdi mdi-account-edit me-1"></i> Edit Reastuarant
                </button>
                </a>  
                <button
                  type="button"
                  class="btn btn-danger btn-rounded mb-2 me-2"
                  @click="deleteRestaurant(restaurant_id)"
                >
                  <i class="mdi mdi-delete me-1"></i> Delete Restaurant
                </button> 
              </div>
    </div>
    <div class="row" v-if='restaurant'>
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-xl-6">
                <div class="product-detai-imgs"> 
                    <div class="product-img">
                        <img
                          :src="restaurant.photo"
                          :alt="restaurant.photo"
                          
                          class="img-fluid mx-auto d-block"
                        />
                      </div>
                  <!-- <b-tabs
                    pills
                    vertical
                    nav-wrapper-class="col-md-2 col-sm-3 col-4"
                  >
                    <b-tab>
                      <template v-slot:title>
                        <img
                          :src="productDetail[0].images[0]"
                          alt
                          class="img-fluid mx-auto d-block tab-img rounded"
                        />
                      </template>
                      <div class="product-img">
                        <img
                          :src="productDetail[0].images[0]"
                          alt
                          class="img-fluid mx-auto d-block"
                        />
                      </div>
                    </b-tab>
                    <b-tab>
                      <template v-slot:title>
                        <img
                          :src="productDetail[0].images[1]"
                          alt
                          class="img-fluid mx-auto d-block tab-img rounded"
                        />
                      </template>
                      <div class="product-img">
                        <img
                          :src="productDetail[0].images[1]"
                          alt
                          class="img-fluid mx-auto d-block"
                        />
                      </div>
                    </b-tab>
                    <b-tab>
                      <template v-slot:title>
                        <img
                          :src="productDetail[0].images[2]"
                          alt
                          class="img-fluid mx-auto d-block tab-img rounded"
                        />
                      </template>
                      <div class="product-img">
                        <img
                          :src="productDetail[0].images[2]"
                          alt
                          class="img-fluid mx-auto d-block"
                        />
                      </div>
                    </b-tab>
                    <b-tab>
                      <template v-slot:title>
                        <img
                          :src="productDetail[0].images[3]"
                          alt
                          class="img-fluid mx-auto d-block tab-img rounded"
                        />
                      </template>
                      <div class="product-img">
                        <img
                          :src="productDetail[0].images[3]"
                          alt
                          class="img-fluid mx-auto d-block"
                        />
                      </div>
                    </b-tab>
                  </b-tabs> -->
                </div>
              </div>  

              <div class="col-xl-6">
                <div class="mt-3">
                  <h4 class="mt-1 mb-3">{{ restaurant.first_name }}</h4>
                      <div v-if="restaurant.review_details && restaurant.review_details.rating">
                        <p class="text-muted float-left me-3">
                                              <i class="bx bx-star" :class="restaurant.review_details.rating>0?'text-warning':'ml-1'"></i>
                                              <i class="bx bx-star" :class="restaurant.review_details.rating>1?'text-warning':'ml-1'"></i>
                                              <i class="bx bx-star" :class="restaurant.review_details.rating>2?'text-warning':'ml-1'"></i>
                                              <i class="bx bx-star" :class="restaurant.review_details.rating>3?'text-warning':'ml-1'"></i>
                                              <i class="bx bx-star" :class="restaurant.review_details.rating>4?'text-warning':'ml-1'"></i>                                 
                                                    
                                        </p>
                                        <p class="text-muted mb-4">( Total {{ restaurant.review_details.total }} Customer review)</p>

                      </div>
                  
                  <h5 class="mb-4">
                     Contact number :
                    <strong> {{ restaurant.phone}}</strong>
                  </h5>
                  <p class="text-muted mb-4">
                    {{restaurant.description }}
                  </p>
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <div>
                        <p class="text-muted">
                          <i
                            class="
                              bx
                              bxl-facebook-circle
                              font-size-16
                              align-middle
                              text-primary
                              me-1
                            "
                          ></i>
                          <a :href="restaurant.facebook_link" target="_blank">Facebook</a>
                        </p>
                      </div>
                      <div>
                        <p class="text-muted">
                          <i
                            class="
                              bx
                              bxl-instagram
                              font-size-16
                              align-middle
                              text-primary
                              me-1
                            "
                          ></i>
                          <a :href="restaurant.instagram_link"  target="_blank">instagram</a>
                        </p>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div>
                        <p class="text-muted">
                          <i
                            class="
                              bx
                              bxl-wikipedia
                              font-size-16
                              align-middle
                              text-primary
                              me-1
                            "
                          ></i>
                          <a :href="restaurant.website_link"  target="_blank">  website</a>
                        </p>
                        <p class="text-muted">
                          <i
                            class="
                              bx
                              bxl-twitter
                              font-size-16
                              align-middle
                              text-primary
                              me-1
                            "
                          ></i>
                          <a :href="restaurant.twitter_link"  target="_blank"> twitter</a>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end row -->

            <!-- <div class="mt-5">
              <h5 class="mb-3">Details :</h5>

              <div class="table-responsive">
                <table class="table mb-0 table-bordered">
                  <tbody>
                    <tr>
                      <th scope="row" style="width: 400px">Orders</th>
                      <td>343</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div> -->
            <!-- end Specifications -->

            <div class="mt-5" v-if="restaurant.review_details && restaurant.review_details.reviews">
              <h5 class="mb-4">Reviews :</h5>

              <div v-for="review in restaurant.review_details.reviews" :key='review.id' class="media py-3 border-bottom">
                <!-- <img
                  src="/images/users/avatar-2.jpg"
                  class="avatar-xs me-3 rounded-circle"
                  alt="img"
                /> -->
                <div class="media-body">
                  <h5 class="mt-0 font-size-15"> {{ review.customer.user.first_name +" " +review.customer.user.last_name}}</h5>
                  <p class="text-muted">
                   {{ review.feedback }}
                  </p>
                <ul class="list-inline float-sm-end">
                    <li class="list-inline-item">
                                       <p class="text-muted float-left me-3">
                        <i class="bx bx-star" :class="review.stars>0?'text-warning':'ml-1'"></i>
                        <i class="bx bx-star" :class="review.stars>1?'text-warning':'ml-1'"></i>
                        <i class="bx bx-star" :class="review.stars>2?'text-warning':'ml-1'"></i>
                        <i class="bx bx-star" :class="review.stars>3?'text-warning':'ml-1'"></i>
                        <i class="bx bx-star" :class="review.stars>4?'text-warning':'ml-1'"></i>                                 
                              
                  </p>
                    </li>
                   
                  </ul>  
                  <div class="text-muted">
                    <i class="far fa-calendar-alt text-primary me-1"></i> 
                    {{ review.created_at }}
                  </div>
                </div>
              </div>
              

            
            </div>
          </div>
        </div>
        <!-- end card -->
      </div>
    </div>
    <!-- end row -->

    <div class="row mt-3" v-if="tables">
      <div class="col-lg-12">
        <div>
          <div class="row">
            <div class="col-sm-4">
              <h5 class="mb-3">Tables :</h5>
            </div>

            <div class="col-sm-8">
              <div class="text-sm-end">
                <button
                  type="button"
                  class="btn btn-success btn-rounded mb-2 me-2"
                  @click="showModal = true"
                >
                  <i class="mdi mdi-plus me-1"></i> New Table
                
                </button>
                <b-modal
                  v-model="showModal"
                  title="Add New Table"
                  title-class="text-black font-18"
                  body-class="p-3"
                  hide-footer
                >   <form @submit.prevent="addTable">
                    <div class="row">
                      <div class="col-6">
                        <div class="mb-3">
                          <label for="name">Name</label>
                          <input
                            id="name"
                            v-model="table.name"
                            type="text"
                            class="form-control"
                            placeholder="Name the table"
                            :class="{
                              'is-invalid': submitted && $v.table.name.$error,
                            }"
                          />
                          <div
                            v-if="submitted && !$v.table.name.required"
                            class="invalid-feedback"
                          >
                            This value is required.
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="mb-3">
                          <label for="number">Table serial number</label>
                          <input
                            id="number"
                            v-model="table.number"
                            type="text"
                            class="form-control"
                            placeholder="Insert number"
                            :class="{
                              'is-invalid': submitted && $v.table.number.$error,
                            }"
                          />
                          <div
                            v-if="submitted && !$v.table.number.required"
                            class="invalid-feedback"
                          >
                            This value is required.
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="mb-3">
                          <label for="min_person">Min Person</label>
                          <input
                            id="min_person"
                            v-model="table.min_person"
                            type="number"
                            class="form-control"
                            placeholder="minimum person capacity"
                            :class="{
                              'is-invalid':
                                submitted && $v.table.min_person.$error,
                            }"
                          />
                          <div
                            v-if="submitted && !$v.table.min_person.required"
                            class="invalid-feedback"
                          >
                            This value is required.
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="mb-3">
                          <label for="max_person">Max Person</label>
                          <input
                            id="max_person"
                            v-model="table.max_person"
                            type="number"
                            class="form-control"
                            placeholder="Maximum Person Capacity"
                            :class="{
                              'is-invalid':
                                submitted && $v.table.max_person.$error,
                            }"
                          />
                          <div
                            v-if="submitted && !$v.table.max_person.required"
                            class="invalid-feedback"
                          >
                            This value is required.
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label for="description">Table Description</label>
                        <textarea
                          id="description"
                          class="form-control"
                          v-model="table.description"
                          rows="5"
                              :class="{
                              'is-invalid': submitted && $v.table.description.$error,
                            }"
                        ></textarea>
                           <div
                            v-if="submitted && !$v.table.description.required"
                            class="invalid-feedback"
                          >
                            This value is required.
                          </div>

                      </div>
                           <label>Restaurant Photo 
                  </label>


                  <vue-dropzone
                    id="photo"
                    ref="myVueDropzone" 
                    :use-custom-slot="true"
                    :options="dropzoneOptions"
                    :class="{
                              'is-invalid':errors && errors.photo,
                            }"
                  >
                    <div class="dropzone-custom-content">
                      <div class="mb-1">
                        <i class="display-6 text-muted bx bxs-cloud-upload"></i>
                      </div>
                      <h4>Drop files here or click to upload.</h4>
                    </div>
                  </vue-dropzone> 

                      <div
                      v-if="errors && errors.photo"
                      class="invalid-feedback"
                    >
                     {{ errors.photo[0] }}
                    </div>



                    </div>
                    <div class="text-end pt-5 mt-3">
                      <b-button variant="light" @click="showModal = false"
                        >Close</b-button
                      >
                      <b-button type="submit" variant="success" class="ms-1"
                        >Add Table</b-button
                      >
                    </div>
                  </form>
                </b-modal>
              </div>
            </div>
          </div>

          <div class="row">
            

            <div v-for="t in tables" :key="t.id" class="col-xl-4 col-sm-6">
              <div class="card">




                <div class="card-body">
 
              <div class="row">
            <div class="col-11">
                <div class="row align-items-center">
                    <div class="col-md-4">
                      <img
                        :src="t.photo"
                        :alt="t.name"
                        class="img-fluid mx-auto d-block"
                      />
                    </div>
                    <div class="col-md-8">
                      <div class="text-center text-md-left">
                        <h5 class="mb-3 text-truncate">
                          <a href="javascript: void(0);" class="text-dark"
                            >{{ t.name }}</a
                          >
                        </h5>
                        <p class="text-muted"> Table Number : {{ t.number }}</p>
                        <h5 class="my-0">
                          <span class="me-2">
                            <b> {{ t.min_person +"-"+ t.max_person}} Person</b>
                          </span>
                        </h5>
                      </div>
                    </div>
                  </div> 
</div>
         
<div class="col-1">
  <b-dropdown style='float:right' class="card-drop  justify-content-end" variant="white" right toggle-class="p-0" menu-class="dropdown-menu-end">
                           <template v-slot:button-content class="row d-flex justify-content-end">
                                <i class="mdi mdi-dots-vertical  font-size-22 d-flex justify-content-end "></i>
                              </template>
                     
                        <b-dropdown-item @click="editTableModel(t)">
                      
                          <i class="fas fa-pencil-alt text-success me-1"  ></i> Edit

            
                        </b-dropdown-item>

                        <b-dropdown-item @click="deleteTable(t.id)">

                          <i class="fas fa-trash-alt text-danger me-1"></i> Delete
                        </b-dropdown-item>
                      </b-dropdown>
</div>
                  
  </div>
                
 
                
                </div>
              </div>
            </div>

           

          </div>
          <!-- end row -->
     


        </div>
      </div>

            <b-modal
                  v-model="showEditModal"
                  title="Edit Table"
                  title-class="text-black font-18"
                  body-class="p-3"
                  hide-footer
                > <form @submit.prevent="editTable">
                    <div class="row">
                      <div class="col-6">
                        <div class="mb-3">
                          <label for="name">Name</label>
                          <input
                            id="name"
                            v-model="table.name"
                            type="text"
                            class="form-control"
                            placeholder="Name the table"
                            :class="{ 'is-invalid': submitted && $v.table.name.$error}"
                          />
                          <div
                            v-if="submitted && !$v.table.name.required"
                            class="invalid-feedback"
                          >
                            This value is required.
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="mb-3">
                          <label for="number">Table serial number</label>
                          <input
                            id="number"
                            v-model="table.number"
                            type="text"
                            class="form-control"
                            placeholder="Insert number"
                            :class="{
                              'is-invalid': submitted && $v.table.number.$error,
                            }"
                          />
                          <div
                            v-if="submitted && !$v.table.number.required"
                            class="invalid-feedback"
                          >
                            This value is required.
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="mb-3">
                          <label for="min_person">Min Person</label>
                          <input
                            id="min_person"
                            v-model="table.min_person"
                            type="number"
                            class="form-control"
                            placeholder="minimum person capacity"
                            :class="{
                              'is-invalid':
                                submitted && $v.table.min_person.$error,
                            }"
                          />
                          <div
                            v-if="submitted && !$v.table.min_person.required"
                            class="invalid-feedback"
                          >
                            This value is required.
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="mb-3">
                          <label for="max_person">Max Person</label>
                          <input
                            id="max_person"
                            v-model="table.max_person"
                            type="number"
                            class="form-control"
                            placeholder="Maximum Person Capacity"
                            :class="{
                              'is-invalid':
                                submitted && $v.table.max_person.$error,
                            }"
                          />  
                          <div
                            v-if="submitted && !$v.table.max_person.required"
                            class="invalid-feedback"
                          >
                            This value is required.
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <label for="description">Table Description</label>
                        <textarea
                          id="description"
                          class="form-control"
                          v-model="table.description"
                          rows="5"
                              :class="{
                              'is-invalid': submitted && $v.table.description.$error,
                            }"
                        ></textarea>
                           <div
                            v-if="submitted && !$v.table.description.required"
                            class="invalid-feedback"
                          >
                            This value is required.
                          </div>

                      </div>
                           <label>Restaurant Photo 
                  </label>


                  <vue-dropzone
                    id="photo"
                    ref="myVueDropzone" 
                    :use-custom-slot="true"
                    :options="dropzoneOptions"
                    :class="{
                              'is-invalid':errors && errors.photo,
                            }"
                  >
                    <div class="dropzone-custom-content">
                      <div class="mb-1">
                        <i class="display-6 text-muted bx bxs-cloud-upload"></i>
                      </div>
                      <h4>Drop files here or click to upload.</h4>
                    </div>
                  </vue-dropzone> 

                      <div
                      v-if="errors && errors.photo"
                      class="invalid-feedback"
                    >
                     {{ errors.photo[0] }}
                    </div>



                    </div>
                    <div class="text-end pt-5 mt-3">
                      <b-button variant="light" @click="showEditModal = false"
                        >Close</b-button
                      >
                      <b-button type="submit" variant="success" class="ms-1"
                        >Submit</b-button
                      >
                    </div>
                  </form>
                </b-modal>




    </div>
    <!-- end row -->
  </Layout>
</template>
