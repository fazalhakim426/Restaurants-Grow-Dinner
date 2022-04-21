<script>
import Layout from "../../../layouts/admin/main";
import PageHeader from "../../../components/page-header";

import { clothsData } from "./data-products";

/**
 * Product detail component
 */
export default {
  components: { Layout, PageHeader },
  props: {
    id: {
      type: String,
      required: false,
    },
  },
  data() {
    return {
      showModal: false,
      submitted: false,
      table: {
        name: "",
        number: "",
        min_number: "",
        max_number: "", 
      },

      productDetail: null,
      clothsData: clothsData,
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
  created() {
    this.productDetail = clothsData.filter((product) => {
      return product.id === parseInt(this.id || "1");
    });
  },
  methods: {
    /**
     * Selected image shows
     */
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
                <a href="/admin/restaurant-orders?restaurant_id=2">
                <button
                  type="button"
                  class="btn btn-success btn-rounded mb-2 me-2"
                
                >
                  <i class="mdi mdi-plus me-1"></i> View Orders
                </button>
                </a>
              </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-xl-6">
                <div class="product-detai-imgs">
                  <b-tabs
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
                  </b-tabs>
                </div>
              </div>

              <div class="col-xl-6">
                <div class="mt-3">
                  <h4 class="mt-1 mb-3">{{ productDetail[0].name }}</h4>

                  <p class="text-muted float-left me-3">
                    <span class="bx bx-star text-warning"></span>
                    <span class="bx bx-star text-warning ml-1"></span>
                    <span class="bx bx-star text-warning ml-1"></span>
                    <span class="bx bx-star text-warning ml-1"></span>
                    <span class="bx bx-star ml-1"></span>
                  </p>
                  <p class="text-muted mb-4">( 152 Customers Review )</p>

                  <h5 class="mb-4">
                    number Number :
                    <strong> 045345345532</strong>
                  </h5>
                  <p class="text-muted mb-4">
                    Description To achieve this, it would be necessary to have
                    uniform grammar pronunciation and more common words If
                    several languages coalesce
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
                          <a href="facebook.com">Facebook</a>
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
                          <a href="instragram.com">instagram</a>
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
                          <a href="website.com"> website</a>
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
                          <a href="twitter.com"> twitter</a>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- end row -->

            <div class="mt-5">
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
            </div>
            <!-- end Specifications -->

            <div class="mt-5">
              <h5 class="mb-4">Reviews :</h5>

              <div class="media py-3 border-bottom">
                <img
                  src="/images/users/avatar-2.jpg"
                  class="avatar-xs me-3 rounded-circle"
                  alt="img"
                />
                <div class="media-body">
                  <h5 class="mt-0 font-size-15">Brian</h5>
                  <p class="text-muted">
                    If several languages coalesce, the grammar of the resulting
                    language.
                  </p>
                  <ul class="list-inline float-sm-end">
                    <li class="list-inline-item">
                      <a href="javascript: void(0);">
                        <i class="far fa-thumbs-up me-1"></i> Like
                      </a>
                    </li>
                    <li class="list-inline-item">
                      <a href="javascript: void(0);">
                        <i class="far fa-comment-dots me-1"></i> Comment
                      </a>
                    </li>
                  </ul>
                  <div class="text-muted">
                    <i class="far fa-calendar-alt text-primary me-1"></i> 5 hrs
                    ago
                  </div>
                </div>
              </div>
              <div class="media py-3 border-bottom">
                <img
                  src="/images/users/avatar-4.jpg"
                  class="avatar-xs me-3 rounded-circle"
                  alt="img"
                />
                <div class="media-body">
                  <h5 class="mt-0 font-size-15">Denver</h5>
                  <p class="text-muted">
                    To an English person, it will seem like simplified English,
                    as a skeptical Cambridge
                  </p>
                  <ul class="list-inline float-sm-end">
                    <li class="list-inline-item">
                      <a href="javascript: void(0);">
                        <i class="far fa-thumbs-up me-1"></i> Like
                      </a>
                    </li>
                    <li class="list-inline-item">
                      <a href="javascript: void(0);">
                        <i class="far fa-comment-dots me-1"></i> Comment
                      </a>
                    </li>
                  </ul>
                  <div class="text-muted">
                    <i class="far fa-calendar-alt text-primary me-1"></i> 07
                    Oct, 2019
                  </div>
                  <div class="media mt-4">
                    <img
                      src="/images/users/avatar-5.jpg"
                      class="avatar-xs me-3 rounded-circle"
                      alt="img"
                    />
                    <div class="media-body">
                      <h5 class="mt-0 font-size-15">Henry</h5>
                      <p class="text-muted">
                        Their separate existence is a myth. For science, music,
                        sport, etc.
                      </p>
                      <ul class="list-inline float-sm-end">
                        <li class="list-inline-item">
                          <a href="javascript: void(0);">
                            <i class="far fa-thumbs-up me-1"></i> Like
                          </a>
                        </li>
                        <li class="list-inline-item">
                          <a href="javascript: void(0);">
                            <i class="far fa-comment-dots me-1"></i> Comment
                          </a>
                        </li>
                      </ul>
                      <div class="text-muted">
                        <i class="far fa-calendar-alt text-primary me-1"></i> 08
                        Oct, 2019
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="media mt-3 border-bottom">
                <div class="avatar-xs me-3">
                  <span
                    class="
                      avatar-title
                      bg-soft bg-primary
                      text-primary
                      rounded-circle
                      font-size-16
                    "
                    >N</span
                  >
                </div>
                <div class="media-body">
                  <h5 class="mt-0 font-size-15">Neal</h5>
                  <p class="text-muted">
                    Everyone realizes why a new common language would be
                    desirable.
                  </p>
                  <ul class="list-inline float-sm-end">
                    <li class="list-inline-item">
                      <a href="javascript: void(0);">
                        <i class="far fa-thumbs-up me-1"></i> Like
                      </a>
                    </li>
                    <li class="list-inline-item">
                      <a href="javascript: void(0);">
                        <i class="far fa-comment-dots me-1"></i> Comment
                      </a>
                    </li>
                  </ul>
                  <div class="text-muted">
                    <i class="far fa-calendar-alt text-primary me-1"></i> 05
                    Oct, 2019
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

    <div class="row mt-3">
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
                >
                  <form @submit.prevent="handleSubmit">
                    <div class="row">
                      <div class="col-12">
                        <div class="mb-3">
                          <label for="name">Name</label>
                          <input
                            id="name"
                            v-model="table.name"
                            type="text"
                            class="form-control"
                            placeholder="Insert username"
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
                      <div class="col-12">
                        <div class="mb-3">
                          <label for="number">number</label>
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
                      <div class="col-12">
                        <div class="mb-3">
                          <label for="min_number">min number</label>
                          <input
                            id="min_number"
                            v-model="table.min_number"
                            type="min_number"
                            class="form-control"
                            placeholder="Insert min number"
                            :class="{
                              'is-invalid':
                                submitted && $v.table.min_number.$error,
                            }"
                          />
                          <div
                            v-if="submitted && !$v.table.min_number.required"
                            class="invalid-feedback"
                          >
                            This value is required.
                          </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="mb-3">
                          <label for="max_number">max number</label>
                          <input
                            id="max_number"
                            v-model="table.max_number"
                            type="text"
                            class="form-control"
                            placeholder="Insert max number"
                            :class="{
                              'is-invalid':
                                submitted && $v.table.max_number.$error,
                            }"
                          />
                          <div
                            v-if="submitted && !$v.table.max_number.required"
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
                          rows="5"
                        ></textarea>
                      </div>
                      <div class="col-12">
                        <label for="image">Table image</label>
                        <input id="image" class="form-control" type="file" />
                      </div>
                    </div>
                    <div class="text-end pt-5 mt-3">
                      <b-button variant="light" @click="showModal = false"
                        >Close</b-button
                      >
                      <b-button type="submit" variant="success" class="ms-1"
                        >Add Employee</b-button
                      >
                    </div>
                  </form>
                </b-modal>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xl-4 col-sm-6">
              <div class="card">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <img
                        src="/images/crypto/blog/img-3.jpg"
                        alt
                        class="img-fluid mx-auto d-block"
                      />
                    </div>
                    <div class="col-md-8">
                      <div class="text-center text-md-left">
                        <h5 class="mb-3 text-truncate">
                          <a href="javascript: void(0);" class="text-dark"
                            >Table Name</a
                          >
                        </h5>
                        <p class="text-muted">Table Number # 5</p>
                        <h5 class="my-0">
                          <span class="me-2">
                            <b> 2 - 4 Person</b>
                          </span>
                        </h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-sm-6">
              <div class="card">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <img
                        src="/images/crypto/blog/img-2.jpg"
                        alt
                        class="img-fluid mx-auto d-block"
                      />
                    </div>
                    <div class="col-md-8">
                      <div class="text-center text-md-left">
                        <h5 class="mb-3 text-truncate">
                          <a href="javascript: void(0);" class="text-dark"
                            >Table Name</a
                          >
                        </h5>
                        <p class="text-muted">Table Number # 5</p>
                        <h5 class="my-0">
                          <span class="me-2">
                            <b> 5 - 7 Person</b>
                          </span>
                        </h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-4 col-sm-6">
              <div class="card">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-md-4">
                      <img
                        src="/images/crypto/blog/img-1.jpg"
                        alt
                        class="img-fluid mx-auto d-block"
                      />
                    </div>
                    <div class="col-md-8">
                      <div class="text-center text-md-left">
                        <h5 class="mb-3 text-truncate">
                          <a href="javascript: void(0);" class="text-dark"
                            >Table Name</a
                          >
                        </h5>
                        <p class="text-muted">Table Number # 5</p>
                        <h5 class="my-0">
                          <span class="me-2">
                            <b> 3 - 5 Person</b>
                          </span>
                        </h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end row -->
        </div>
      </div>
    </div>
    <!-- end row -->
  </Layout>
</template>
