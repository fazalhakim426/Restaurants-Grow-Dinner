<script>
import axios from "axios";
import _ from "lodash";
import { required } from "vuelidate/lib/validators";

import vue2Dropzone from "vue2-dropzone";
import Multiselect from "vue-multiselect";

import Layout from "../../../layouts/admin/main";
import PageHeader from "../../../components/page-header";

/**
 * Add-product component
 */
export default {
      props: {
    access_token: {
      type: String,
      required: true
    }
  },
    components: {
        vueDropzone: vue2Dropzone,
        Multiselect,
        Layout,
        PageHeader
    },
    data() {
        return {
            title: "Add Restaurant",
            items: [ 
                {
                    text: "Add Restaurant",
                    active: true
                }
            ],
            dropzoneOptions: {
                url: "https://httpbin.org/post",
                acceptedFiles: "image/*",
                method: "POST",
                thumbnailHeight: 100,
                accept: file => {
                    this.onAccept(file);
                }
            },
            formData: new FormData(),
            restaurant: {
                name: "",
                latidue: "",
                longitude:"",
                opening_time: "", 
                closing_time: "",
                price: null
            },
            image: "",
            file: "",
            value: null,
            value1: null,
            options: [
                "Alaska",
                "Hawaii",
                "California",
                "Nevada",
                "Oregon",
                "Washington",
                "Arizona",
                "Colorado",
                "Idaho",
                "Montana",
                "Nebraska",
                "New Mexico",
                "North Dakota",
                "Utah",
                "Wyoming",
                "Alabama",
                "Arkansas",
                "Illinois",
                "Iowa"
            ],
            submitted: false,
            formData: {
                name: null,
                opening_time: null,
                closing_time: null,
                price: null,
                image: null
            },
            avatar: null,
            avatarName: null,
            showForm: true,
            user: null,
            errors: null
        };
    },
    validations: {
        restaurant: {
            name: {
                required
            },
            opening_time: {
                required
            },
            closing_time: {
                required
            },
            latidue: {
                required
            },
            longitude: {
                required
            },
            price: {
                required
            }
        }
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
        submit() {
            this.submitted = true;
            // stop here if form is invalid
            this.$v.$touch();
            if (this.$v.$invalid) {
                return;
            } else {
                this.errors = null;
                let formData = new FormData();
                formData.append("image", this.avatar, this.avatarName);
                _.each(this.formData, (value, key) => {
                    formData.append(key, value);
                });
                console.log(formData);
                axios
                    .post("/api/products", formData, {
                        headers: {
                            "Content-Type": "multipart/form-data"
                        }
                    })
                    .then(response => {
                        this.showForm = false;
                        this.user = response.data.data;
                        console.log(this.user);
                    })
                    .catch(err => {
                        if (err.response.status === 422) {
                            this.errors = [];
                            _.each(err.response.data.errors, error => {
                                _.each(error, e => {
                                    this.errors.push(e);
                                });
                            });
                        }
                    });
            }
        },
        restaurantAdd() {
            this.submitted = true;
            // stop here if form is invalid
            this.$v.$touch();

            if (this.$v.$invalid) {
                return;
            } else {
                let formData = new FormData();
                formData.append("name", this.restaurant.name);
                formData.append(
                    "opening_time",
                    this.restaurant.opening_time
                );
                formData.append(
                    "closing_time",
                    this.restaurant.closing_time
                );
                formData.append("price", this.restaurant.price);
                formData.append("image", this.file, this.image);

                //** Add Restaurant in api using post method *//
                axios
                    .post(`http://localhost:8000/api/products`, formData)
                    .then(res => {
                        return res;
                    })
                    .catch(err => {
                        return err;
                    });
            }
        }
    }
};
</script>

<template>
    <Layout>
        <PageHeader :title="title" :items="items" />
        <div class="row">
            <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Account Creations</h4>
                        <p class="card-title-desc">
                            Login Informations
                        </p>

                        <form>
                            <div class="row">
                                <div class="col-sm-6">
                                        <div class="mb-3">
                                        <label for="restaurantname"
                                            >name</label
                                        >
                                        <input
                                            id="restaurantname"
                                            v-model="restaurant.name"
                                            name="name"
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    submitted &&
                                                    $v.restaurant.name.$error
                                            }"
                                        />
                                        <div
                                            v-if="
                                                submitted &&
                                                    !$v.restaurant.name.required
                                            "
                                            class="invalid-feedback"
                                        >
                                            name is required.
                                        </div>
                                    </div>
 



                                    <div class="mb-3">
                                        <label for="metatitle"
                                            >Email</label
                                        >
                                        <input
                                            id="email"
                                            name="email"
                                            type="text"
                                            class="form-control"
                                        />
                                         <div
                                            v-if="
                                                submitted &&
                                                    !$v.restaurant.email.required
                                            "
                                            class="invalid-feedback"
                                        >
                                            Email is required.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password"
                                            >Password</label
                                        >
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
                                        <label class="control-label"
                                            >Country</label
                                        >
                                        <multiselect
                                            v-model="value"
                                            :options="options"
                                        ></multiselect>
                                    </div>

                                    <div class="mb-3">
                                        <label for="address"
                                            >Phone</label
                                        >
                                        <input
                                            id="phone"
                                            class="form-control" 
                                        /> 
                                    </div>

                                    <div class="mb-3">
                                        <label for="address"
                                            >Address</label
                                        >
                                        <textarea
                                            id="address"
                                            class="form-control"
                                            rows="2"
                                        ></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- <button type="submit" class="btn btn-primary mr-1">
                                Save Changes
                            </button>
                            <button type="submit" class="btn btn-secondary">
                                Cancel
                            </button> -->
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Restaurant Basic Information</h4>
                        <p class="card-title-desc">
                            Fill all information below
                        </p>

                        <!-- THIS SECTION IS FOR ERRORS THAT WOULD COME FROM API -->
                        <div v-if="errors">
                            <div
                                v-for="(error, index) in errors"
                                :key="index"
                                class="alert alert-danger"
                            >
                                {{ error }}
                            </div>
                        </div>
                       
                        <form @submit.prevent="restaurantAdd">
                            <div class="row">
                                
                                <div class="col-sm-6">
                               

                                    <div class="mb-3">
                                        <label for="restaurantname"
                                            >Latitude</label
                                        >
                                        <input
                                            id="restaurantname"
                                            v-model="restaurant.latitude"
                                            name="name"
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    submitted &&
                                                    $v.restaurant.latitude.$error
                                            }"
                                        />
                                        <div
                                            v-if="
                                                submitted &&
                                                    !$v.restaurant.latitude.required
                                            "
                                            class="invalid-feedback"
                                        >
                                            Latitude is required.
                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label for="restaurantname"
                                            >longitude</label
                                        >
                                        <input
                                            id="restaurantname"
                                            v-model="restaurant.longitude"
                                            name="name"
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    submitted &&
                                                    $v.restaurant.longitude.$error
                                            }"
                                        />
                                        <div
                                            v-if="
                                                submitted &&
                                                    !$v.restaurant.longitude.required
                                            "
                                            class="invalid-feedback"
                                        >
                                            longitude is required.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="opening_time"
                                            >Opening Time</label
                                        >
                                        <input
                                            id="opening_time"
                                            v-model="restaurant.opening_time"
                                            name="opening time"
                                            type="date"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    submitted &&
                                                    $v.restaurant.opening_time
                                                        .$error
                                            }"
                                        />
                                        <div
                                            v-if="
                                                submitted &&
                                                    !$v.restaurant.opening_time
                                                        .required
                                            "
                                            class="invalid-feedback"
                                        >
                                            Restaurant opening time is
                                            required.
                                        </div>
                                    </div>
                                    <div class="mb-3"> 
                                        <label for="closing_time"
                                            >closing time</label
                                        >
                                        <input
                                            id="closing_time"
                                            v-model="restaurant.closing_time"
                                            name="closing_time"
                                            type="date"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    submitted &&
                                                    $v.restaurant.closing_time
                                                        .$error
                                            }"
                                        />
                                        <div
                                            v-if="
                                                submitted &&
                                                    !$v.product
                                                        .closing_time
                                                        .required
                                            "
                                            class="invalid-feedback"
                                        >
                                            Restaurant
                                             closing time is
                                            required.
                                        </div>
                                    </div>
                                    
                                    <label>Product Images</label>
                                    <vue-dropzone
                                        id="image"
                                        ref="myVueDropzone"
                                        :use-custom-slot="true"
                                        :options="dropzoneOptions"
                                    >
                                        <div class="dropzone-custom-content">
                                            <div class="mb-1">
                                                <i
                                                    class="display-4 text-muted bx bxs-cloud-upload"
                                                ></i>
                                            </div>
                                            <h4>
                                                Drop files here or click to
                                                upload.
                                            </h4>
                                        </div>
                                    </vue-dropzone>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="control-label"
                                            >Category</label
                                        >
                                        <multiselect
                                            v-model="value"
                                            :options="options"
                                        ></multiselect>
                                    </div>
                                    <div class="mb-3">
                                        <label class="control-label"
                                            >Tags</label
                                        >
                                        <multiselect
                                            v-model="value1"
                                            :options="options"
                                            :multiple="true"
                                        ></multiselect>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description"
                                            >Restaurant Description</label
                                        >
                                        <textarea
                                            id="description"
                                            class="form-control"
                                            rows="5"
                                        ></textarea>
                                    </div>


                                                
                                    <label>Menu Images</label>
                                    <vue-dropzone
                                        id="menu"
                                        ref="myVueDropzone"
                                        :use-custom-slot="true"
                                        :options="dropzoneOptions"
                                    >
                                        <div class="dropzone-custom-content">
                                            <div class="mb-1">
                                                <i
                                                    class="display-4 text-muted bx bxs-cloud-upload"
                                                ></i>
                                            </div>
                                            <h4>
                                                Drop files here or click to
                                                upload.
                                            </h4>
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
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Social Connect</h4>
                        <p class="card-title-desc">
                            Past social links below
                        </p>

                        <form>
                            <div class="row">
                                <div class="col-sm-6">
                                   <div class="mb-3">
                                        <label for="metatitle"
                                            >Instagram link</label
                                        >
                                        <input
                                            id="instagram_link"
                                            name="instagram_link"
                                            type="text"
                                            class="form-control"
                                        />
                                    </div>

                                    <div class="mb-3">
                                        <label for="metatitle"
                                            >Facebook link</label
                                        >
                                        <input
                                            id="facebook_link"
                                            name="facebook_link"
                                            type="text"
                                            class="form-control"
                                        />
                                    </div>
                                 
                                </div>

                                <div class="col-sm-6">
                                     <div class="mb-3">
                                        <label for="metatitle"
                                            >Twitter link</label
                                        >
                                        <input
                                            id="twitter_link"
                                            name="twitter_link"
                                            type="text"
                                            class="form-control"
                                        />
                                    </div>

                                   <div class="mb-3">
                                        <label for="metatitle"
                                            >Website link</label
                                        >
                                        <input
                                            id="website_link"
                                            name="website_link"
                                            type="text"
                                            class="form-control"
                                        />
                                    </div>

                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary mr-1">
                                Save Changes
                            </button>
                            <button type="submit" class="btn btn-secondary">
                                Cancel
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </Layout>
</template>
