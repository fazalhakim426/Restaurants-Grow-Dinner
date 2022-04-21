<script>
import Layout from "../../../layouts/admin/main";
import PageHeader from "../../../components/page-header";
import { required } from "vuelidate/lib/validators";

import { emplyeesData } from "./data-finance";

/**
 * Employees component
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
      emplyeesData: emplyeesData,
      title: "Employees",
      items: [ 
        {
          text: "Employees",
          active: true
        }
      ],
      showModal: false,
      submitted: false,
      employees: {
        username: "",
        phone: "",
        email: "",
        address: "",
        salary: "",
      },
    };
  },
  validations: {
    employees: {
      username: { required },
      phone: { required },
      email: { required },
      address: { required }, 
      password: { required },
      salary: { required },
      social_nr: { required },
      bank_number: { required },
      documents: { required },

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
        this.emplyeesData.push({
          username: this.employees.username,
          phone: this.employees.phone,
          email: this.employees.email,
          address: this.employees.address,
          salary: this.employees.salary,
          social_nr: "4.3",
          date: currentDate,
        });
        this.showModal = false;
        this.employees = {};
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
                    <i class="mdi mdi-plus me-1"></i> New Employee
                  </button>
                    <b-modal
                    v-model="showModal"
                    title="Add New Employee"
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
                              v-model="employees.username"
                              type="text"
                              class="form-control"
                              placeholder="Insert username"
                              :class="{
                                'is-invalid':
                                  submitted && $v.employees.username.$error,
                              }"
                            />
                            <div
                              v-if="
                                submitted && !$v.employees.username.required
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
                              v-model="employees.phone"
                              type="text"
                              class="form-control"
                              placeholder="Insert phone"
                              :class="{
                                'is-invalid':
                                  submitted && $v.employees.phone.$error,
                              }"
                            />
                            <div
                              v-if="submitted && !$v.employees.phone.required"
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
                              v-model="employees.email"
                              type="email"
                              class="form-control"
                              placeholder="Insert email"
                              :class="{
                                'is-invalid':
                                  submitted && $v.employees.email.$error,
                              }"
                            />
                            <div
                              v-if="submitted && !$v.employees.email.required"
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
                              v-model="employees.address"
                              type="text"
                              class="form-control"
                              placeholder="Insert address"
                              :class="{
                                'is-invalid':
                                  submitted && $v.employees.address.$error,
                              }"
                            />
                            <div
                              v-if="submitted && !$v.employees.address.required"
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
                              v-model="employees.password"
                              type="password"
                              class="form-control"
                              placeholder="Insert password"
                              :class="{
                                'is-invalid':
                                  submitted && $v.employees.password.$error,
                              }"
                            />
                            <div
                              v-if="submitted && !$v.employees.password.required"
                              class="invalid-feedback"
                            >
                              This value is required.
                            </div>
                          </div>
                        </div>

                        <hr>
                        <!-- salary -->
                        <div class="col-12">
                          <div class="mb-3">
                            <label for="salary">salary</label>
                            <input
                              id="salary"
                              v-model="employees.salary"
                              type="number"
                              class="form-control"
                              placeholder="Insert salary"
                              :class="{
                                'is-invalid':
                                  submitted && $v.employees.salary.$error,
                              }"
                            />
                            <div
                              v-if="submitted && !$v.employees.salary.required"
                              class="invalid-feedback"
                            >
                              This value is required.
                            </div>
                          </div>
                        </div>
                        <!-- social nr -->
                        
                        <div class="col-12">
                          <div class="mb-3">
                            <label for="social_nr">Social NR</label>
                            <input
                              id="social_nr"
                              v-model="employees.social_nr"
                              type="social_nr"
                              class="form-control"
                              placeholder="Insert social_nr"
                              :class="{
                                'is-invalid':
                                  submitted && $v.employees.social_nr.$error,
                              }"
                            />
                            <div
                              v-if="submitted && !$v.employees.social_nr.required"
                              class="invalid-feedback"
                            >
                              This value is required.
                            </div>
                          </div>
                        </div>

                        
                        <!-- bankd numbers -->
                        
                        <div class="col-12">
                          <div class="mb-3">
                            <label for="bank_number">Bank Number</label>
                            <input
                              id="bank_number"
                              v-model="employees.bank_number"
                              type="bank_number"
                              class="form-control"
                              placeholder="Insert bank_number"
                              :class="{
                                'is-invalid':
                                  submitted && $v.employees.bank_number.$error,
                              }"
                            />
                            <div
                              v-if="submitted && !$v.employees.bank_number.required"
                              class="invalid-feedback"
                            >
                              This value is required.
                            </div>
                          </div>
                        </div>

                        <!-- documents -->
                        
                        <div class="col-12">
                          <div class="mb-3">
                            <label for="documents">documents</label>
                            <input
                              id="documents"
                              v-model="employees.documents"
                              type="text"
                              class="form-control"
                              placeholder="Insert documents"
                              :class="{
                                'is-invalid':
                                  submitted && $v.employees.documents.$error,
                              }"
                            />
                            <div v-if="submitted && !$v.employees.documents.required"
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
                          >Add Employee</b-button>
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
                    <th>Social NR</th>
                    <th>Salary</th> 
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="employees in emplyeesData" :key="employees.id">
                    <td>
                     <div class="form-check font-size-16">
                        <input
                          :id="`customCheck${employees.id}`"
                          type="checkbox"
                          class="form-check-input"
                        />
                        <label
                          class="form-check-label"
                          :for="`customCheck${employees.id}`"
                        >&nbsp;</label>
                      </div>
                    </td>
                    <td>{{employees.username}}</td>
                    <td>
                      <p class="mb-1">{{employees.phone}}</p>
                      <p class="mb-0">{{employees.email}}</p>
                    </td>

                    <td>{{employees.address}}</td>
                    <td>
                      <span class="badge bg-success font-size-12">
                        <i class="mdi mdi-star me-1"></i>
                        {{employees.social_nr}}
                      </span>
                    </td>
                    <td>{{employees.salary}}</td> 
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
