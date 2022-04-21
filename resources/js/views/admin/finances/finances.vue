<script>
import Layout from "../../../layouts/admin/main";
import PageHeader from "../../../components/page-header";
import { required } from "vuelidate/lib/validators";

import { financesData } from "./data-finance";

/**
 * Finance component
 */
export default {
  props: {
    access_token: {
      type: String,
      required: true
    }
  },
  components: { Layout, PageHeader },
  data() {
    return {
      financesData: financesData,
      title: "Finance",
      items: [ 
        {
          text: "Finance",
          active: true
        }
      ],
      showModal: false,
      submitted: false,
      finance: {
        username: "",
        phone: "",
        email: "",
        address: "", 
      },
    };
  },
  validations: {
    finance: {
      username: { required },
      phone: { required },
      email: { required },
      address: { required }, 
      password: { required },   

    },
  },
  methods: {
    /**
     * Modal form submit
     */
    // eslint-disable-next-line no-unused-vars
    handleSubmit(e) {
      this.submitted = true;

      // stop here if form is invalid
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      } else {
        const currentDate = new Date();
        this.financesData.push({
          username: this.finance.username,
          phone: this.finance.phone,
          email: this.finance.email,
          address: this.finance.address, 
          date: currentDate,
        });
        this.showModal = false;
        this.finance = {};
      }
      this.submitted = false;
    },
  },
};
</script>

<template>
  <Layout>
    <PageHeader :title="title" :items="items" />

    <div class="row"> 
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row mb-2">
              <div class="col-sm-4">
                <div class="search-box me-2 mb-2 d-inline-block">
                  <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search..." />
                    <i class="bx bx-search-alt search-icon"></i>
                  </div>
                </div>
              </div>
              <div class="col-sm-8">
                <div class="text-sm-end">
                  <button
                    type="button"
                    class="btn btn-success btn-rounded mb-2 me-2"
                     @click="showModal = true"
                  >
                    <i class="mdi mdi-plus me-1"></i> New Finance
                  </button>
                    <b-modal
                    v-model="showModal"
                    title="Add New Finance"
                    title-class="text-black font-18"
                    body-class="p-3" 
                    hide-footer >
                    <form @submit.prevent="handleSubmit">
                      <div class="row">
                        <div class="col-12">
                          <div class="mb-3">
                            <label for="name">Name</label>
                            <input
                              id="name"
                              v-model="finance.username"
                              type="text"
                              class="form-control"
                              placeholder="Insert username"
                              :class="{
                                'is-invalid':
                                  submitted && $v.finance.username.$error,
                              }"
                            />
                            <div
                              v-if="
                                submitted && !$v.finance.username.required
                              "
                              class="invalid-feedback"
                            >
                              This value is required.
                            </div>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="mb-3">
                            <label for="phone">Phone</label>
                            <input
                              id="phone"
                              v-model="finance.phone"
                              type="text"
                              class="form-control"
                              placeholder="Insert phone"
                              :class="{
                                'is-invalid':
                                  submitted && $v.finance.phone.$error,
                              }"
                            />
                            <div
                              v-if="submitted && !$v.finance.phone.required"
                              class="invalid-feedback"
                            >
                              This value is required.
                            </div>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="mb-3">
                            <label for="email">Email</label>
                            <input
                              id="email"
                              v-model="finance.email"
                              type="email"
                              class="form-control"
                              placeholder="Insert email"
                              :class="{
                                'is-invalid':
                                  submitted && $v.finance.email.$error,
                              }"
                            />
                            <div
                              v-if="submitted && !$v.finance.email.required"
                              class="invalid-feedback"
                            >
                              This value is required.
                            </div>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="mb-3">
                            <label for="address">Address</label>
                            <input
                              id="address"
                              v-model="finance.address"
                              type="text"
                              class="form-control"
                              placeholder="Insert address"
                              :class="{
                                'is-invalid':
                                  submitted && $v.finance.address.$error,
                              }"
                            />
                            <div
                              v-if="submitted && !$v.finance.address.required"
                              class="invalid-feedback"
                            >
                              This value is required.
                            </div>
                          </div>
                        </div>
                        <!-- password -->
                        <div class="col-12">
                          <div class="mb-3">
                            <label for="password">password</label>
                            <input
                              id="password"
                              v-model="finance.password"
                              type="password"
                              class="form-control"
                              placeholder="Insert password"
                              :class="{
                                'is-invalid':
                                  submitted && $v.finance.password.$error,
                              }"
                            />
                            <div
                              v-if="submitted && !$v.finance.password.required"
                              class="invalid-feedback"
                            >
                              This value is required.
                            </div>
                          </div>
                        </div>
  
                        <!-- departement -->
                        <!-- country and city -->
                      </div> 
                      <div class="text-end pt-5 mt-3">
                        <b-button variant="light" @click="showModal = false">Close</b-button>
                        <b-button type="submit" variant="success" class="ms-1"
                          >Add Finance</b-button>
                      </div>
                    </form>
                  </b-modal>
                </div>
              </div>
              <!-- end col-->
            </div>
            <div class="table-responsive">
              <table class="table table-centered table-nowrap">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Phone / Email</th>
                    <th>Address</th>   
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="finance in financesData" :key="finance.id">
                    <td>
                     <div class="form-check font-size-16">
                        <input
                          :id="`customCheck${finance.id}`"
                          type="checkbox"
                          class="form-check-input"
                        />
                        <label
                          class="form-check-label"
                          :for="`customCheck${finance.id}`"
                        >&nbsp;</label>
                      </div>
                    </td>
                    <td>{{finance.username}}</td>
                    <td>
                      <p class="mb-1">{{finance.phone}}</p>
                      <p class="mb-0">{{finance.email}}</p>
                    </td>

                    <td>{{finance.address}}</td>
                  
                    <td>
                      <b-dropdown class="card-drop" variant="white" right toggle-class="p-0" menu-class="dropdown-menu-end">
                        <template v-slot:button-content>
                          <i class="mdi mdi-dots-horizontal font-size-18"></i>
                        </template>

                        <b-dropdown-item>
                          <i class="fas fa-pencil-alt text-success me-1"></i> Edit
                        </b-dropdown-item>

                        <b-dropdown-item>
                          <i class="fas fa-trash-alt text-danger me-1"></i> Delete
                        </b-dropdown-item>
                      </b-dropdown>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <ul class="pagination pagination-rounded justify-content-end mb-2">
              <li class="page-item disabled">
                <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                  <i class="mdi mdi-chevron-left"></i>
                </a>
              </li>
              <li class="page-item active">
                <a class="page-link" href="javascript: void(0);">1</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="javascript: void(0);">2</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="javascript: void(0);">3</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="javascript: void(0);">4</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="javascript: void(0);">5</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="javascript: void(0);" aria-label="Next">
                  <i class="mdi mdi-chevron-right"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </Layout>
</template>
