<script> 
import Layout from "../../../layouts/admin/main";
import PageHeader from "../../../components/page-header";
import { tableData } from "./dataAdvancedtable";
import { tableDataPast } from "./dataAdvancedtablePast";

/**
 * Advanced table component
 */
export default {
  components: { Layout, PageHeader},
  data() {
    return { 
      coupon:{
        promo_code:"",
        is_fixed:"",
        amount: "",
        min_amount: "",
        start_at :"",
        end_at: "",
      },
      tableData: tableData,
      tableDataPast: tableDataPast,
      title: "Coupons",
      items: [ 
        {
          text: "Coupons",
          active: true,
        },
      ],
      totalRows: 1,
      currentPage: 1,
      perPage: 10,
      pageOptions: [10, 25, 50, 100],
      filter: null,
      filterOn: [],
      sortBy: "age",
      sortDesc: false,
      fields: [  
        { key: "promo_code", label: "Promo Code", type: "text" },
        { key: "is_fixed", label: "Fixed", type: "text" },
        { key: "amount", label: "amount", type: "text" },    
        { key: "min_amount", label: "Min Amount", type: "text" },    
        { key: "start_at", label: "Start At", type: "text" },    
        { key: "end_at", label: "End At", type: "text" },    
        { key: "action" },   
      ], 
    };
  },
  computed: {
    /**
     * Total no. of records
     */
    rows() {
      return this.tableData.length;
    },
    rows_past() {
      return this.tableDataPast.length;
    },
  },
  mounted() {
    // Set the initial number of items
    this.totalRows = this.items.length;
  },
  methods: {
    /**
     * Search the table data with search input
     */
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length;
      this.currentPage = 1;
    },
    handleInput(value, data) {
      this.editableDataItems[data.index][data.field.key] = value;
    }
  },
};
</script>

<template>
  <Layout>
    <PageHeader :title="title" :items="items" />


  <div class="row">
      <div class="col-lg-12 col-sm-12 col-md-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title mb-4">Add Coupons</h4>
            <form class="repeater" enctype="multipart/form-data">
              <div class="row"> 
                  <div class="mb-2 col-lg-2">
                    <label for="name">Promo Code</label>
                    <input
                      id="name"
                      v-model="coupon.promo_code"
                      type="text"
                      name="untyped-input"
                      class="form-control"
                    />
                  </div>
  
                  <div class="mb-2 col-lg-2">
                     <label for="name">Is Fixed</label>
                    <input
                      id="name"
                      v-model="coupon.is_fixed"
                      type="text"
                      name="untyped-input"
                      class="form-control"
                    />
                  </div>
 
                  <div class="mb-2 col-lg-2">
                     <label for="name">Amount</label>
                    <input
                      id="name"
                      v-model="coupon.amount"
                      type="text"
                      name="untyped-input"
                      class="form-control"
                    /> 
                  </div> 
                  <div class="mb-2 col-lg-2">
                    <label for="name">start at</label>
                    <input
                      id="name"
                      v-model="coupon.start_at"
                      type="date"
                      name="untyped-input"
                      class="form-control"
                    />
                  </div>
  
                  <div class="mb-2 col-lg-2">
                  <label for="name">End at</label>
                    <input
                      id="name"
                      v-model="coupon.end_at"
                      type="date"
                      name="untyped-input"
                      class="form-control"
                    />
                  </div>
 
                  <div class="mb-2 col-lg-2 col-md-2 align-self-end">
                     <div class="d-grid">
                    <input
                      type="button"
                      class="btn btn-primary btn-block"
                      value="Add"  
                    />
                     </div>
                  </div>
                </div>  
            </form>
          </div>
          <!-- end card-body -->
        </div>
        <!-- end card -->
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
 

    <div class="row">
      <div class="col-lg-12 col-sm-12 col-md-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Active Coupons</h4>
            <div class="row mt-4">
              <div class="col-sm-12 col-md-6">
                <div id="tickets-table_length" class="dataTables_length">
                  <label class="d-inline-flex align-items-center">
                    Show&nbsp;
                    <b-form-select
                      v-model="perPage"
                      size="sm"
                      class="form-select form-select-sm"
                      :options="pageOptions"
                    ></b-form-select
                    >&nbsp;entries
                  </label>
                </div>
              </div>
              <!-- Search -->
              <div class="col-sm-12 col-md-6">
                <div
                  id="tickets-table_filter"
                  class="dataTables_filter text-md-end"
                >
                  <label class="d-inline-flex align-items-center">
                    Search:
                    <b-form-input
                      v-model="filter"
                      type="search"
                      placeholder="Search..."
                      class="form-control form-control-sm ms-2"
                    ></b-form-input>
                  </label>
                </div>
              </div>
              <!-- End search -->
            </div>
            <!-- Table -->
            <div class="table-responsive mb-0">
              <b-table
                class="datatables"
                :items="tableDataPast"
                :fields="fields"
                responsive="sm"
                :per-page="perPage"
                :current-page="currentPage"
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                :filter="filter"
                :filter-included-fields="filterOn"
                @filtered="onFiltered"
              >
            
                <template #cell(action)="row">  
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
                </template>
      
      </b-table>
            </div>
            <div class="row">
              <div class="col">
                <div
                  class="dataTables_paginate paging_simple_numbers float-end"
                >
                  <ul class="pagination pagination-rounded mb-0">
                    <!-- pagination -->
                    <b-pagination
                      v-model="currentPage"
                      :total-rows="rows_past"
                    ></b-pagination>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 
    <div class="row">
      <div class="col-lg-12 col-sm-12 col-md-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Past Coupons</h4>
            <div class="row mt-4">
              <div class="col-sm-12 col-md-6">
                <div id="tickets-table_length" class="dataTables_length">
                  <label class="d-inline-flex align-items-center">
                    Show&nbsp;
                    <b-form-select
                      v-model="perPage"
                      size="sm"
                      class="form-select form-select-sm"
                      :options="pageOptions"
                    ></b-form-select
                    >&nbsp;entries
                  </label>
                </div>
              </div>
              <!-- Search -->
              <div class="col-sm-12 col-md-6">
                <div
                  id="tickets-table_filter"
                  class="dataTables_filter text-md-end"
                >
                  <label class="d-inline-flex align-items-center">
                    Search:
                    <b-form-input
                      v-model="filter"
                      type="search"
                      placeholder="Search..."
                      class="form-control form-control-sm ms-2"
                    ></b-form-input>
                  </label>
                </div>
              </div>
              <!-- End search -->
            </div>
            <!-- Table -->
            <div class="table-responsive mb-0">
              <b-table
                class="datatables"
                :items="tableData"
                :fields="fields"
                responsive="sm"
                :per-page="perPage"
                :current-page="currentPage"
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
                :filter="filter"
                :filter-included-fields="filterOn"
                @filtered="onFiltered"
              >
            
                <template #cell(action)="row">  
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
                </template>
      
      </b-table>
            </div>
            <div class="row">
              <div class="col">
                <div
                  class="dataTables_paginate paging_simple_numbers float-end"
                >
                  <ul class="pagination pagination-rounded mb-0">
                    <!-- pagination -->
                    <b-pagination
                      v-model="currentPage"
                      :total-rows="rows"
                    ></b-pagination>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 
  </Layout>
</template>