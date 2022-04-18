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
            title: "Add Product",
            items: [
                {
                    text: "Ecommerce",
                    href: "/"
                },
                {
                    text: "Add Product",
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
            product: {
                name: "",
                manufacture_name: "",
                manufacture_brand: "",
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
                manufacture_name: null,
                manufacture_brand: null,
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
        product: {
            name: {
                required
            },
            manufacture_name: {
                required
            },
            manufacture_brand: {
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
        productAdd() {
            this.submitted = true;
            // stop here if form is invalid
            this.$v.$touch();

            if (this.$v.$invalid) {
                return;
            } else {
                let formData = new FormData();
                formData.append("name", this.product.name);
                formData.append(
                    "manufacture_name",
                    this.product.manufacture_name
                );
                formData.append(
                    "manufacture_brand",
                    this.product.manufacture_brand
                );
                formData.append("price", this.product.price);
                formData.append("image", this.file, this.image);

                //** Add product in api using post method *//
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
                        <h4 class="card-title">Basic Information</h4>
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
                       
                        <form @submit.prevent="productAdd">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="productname"
                                            >Product Name</label
                                        >
                                        <input
                                            id="productname"
                                            v-model="product.name"
                                            name="name"
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    submitted &&
                                                    $v.product.name.$error
                                            }"
                                        />
                                        <div
                                            v-if="
                                                submitted &&
                                                    !$v.product.name.required
                                            "
                                            class="invalid-feedback"
                                        >
                                            Product name is required.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="manufacturername"
                                            >Manufacturer Name</label
                                        >
                                        <input
                                            id="manufacturername"
                                            v-model="product.manufacture_name"
                                            name="manufacture_name"
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    submitted &&
                                                    $v.product.manufacture_name
                                                        .$error
                                            }"
                                        />
                                        <div
                                            v-if="
                                                submitted &&
                                                    !$v.product.manufacture_name
                                                        .required
                                            "
                                            class="invalid-feedback"
                                        >
                                            Product manufacture_name is
                                            required.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="manufacturerbrand"
                                            >Manufacturer Brand</label
                                        >
                                        <input
                                            id="manufacturerbrand"
                                            v-model="product.manufacture_brand"
                                            name="manufacture_brand"
                                            type="text"
                                            class="form-control"
                                            :class="{
                                                'is-invalid':
                                                    submitted &&
                                                    $v.product.manufacture_brand
                                                        .$error
                                            }"
                                        />
                                        <div
                                            v-if="
                                                submitted &&
                                                    !$v.product
                                                        .manufacture_brand
                                                        .required
                                            "
                                            class="invalid-feedback"
                                        >
                                            Product manufacture_brand is
                                            required.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price">Price</label>
                                        <input
                                            id="price"
                                            name="price"
                                            v-model="product.price"
                                            :class="{
                                                'is-invalid':
                                                    submitted &&
                                                    $v.product.price.$error
                                            }"
                                            type="text"
                                            class="form-control"
                                        />
                                        <div
                                            v-if="
                                                submitted &&
                                                    !$v.product.price.required
                                            "
                                            class="invalid-feedback"
                                        >
                                            Product price is required.
                                        </div>
                                    </div>
                                    <label>Product Images</label>
                                    <vue-dropzone
                                        id="dropzone"
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
                                            >Features</label
                                        >
                                        <multiselect
                                            v-model="value1"
                                            :options="options"
                                            :multiple="true"
                                        ></multiselect>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productdesc"
                                            >Product Description</label
                                        >
                                        <textarea
                                            id="productdesc"
                                            class="form-control"
                                            rows="5"
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button
                                    type="submit"
                                    class="btn btn-primary me-1"
                                >
                                    Save Changes
                                </button>
                                <button type="submit" class="btn btn-secondary">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Meta Data</h4>
                        <p class="card-title-desc">
                            Fill all information below
                        </p>

                        <form>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="metatitle"
                                            >Meta title</label
                                        >
                                        <input
                                            id="metatitle"
                                            name="productname"
                                            type="text"
                                            class="form-control"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label for="metakeywords"
                                            >Meta Keywords</label
                                        >
                                        <input
                                            id="metakeywords"
                                            name="manufacturername"
                                            type="text"
                                            class="form-control"
                                        />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="metadescription"
                                            >Meta Description</label
                                        >
                                        <textarea
                                            id="metadescription"
                                            class="form-control"
                                            rows="5"
                                        ></textarea>
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
