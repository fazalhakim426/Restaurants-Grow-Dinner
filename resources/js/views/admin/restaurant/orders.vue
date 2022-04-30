<script>
import Layout from '../../../layouts/admin/main'
import PageHeader from '../../../components/page-header'
import axios from 'axios'
import Transaction from '../../../components/widgets/transaction'

/**
 * Products-order component
 */
export default {
  components: { Layout, PageHeader, Transaction },
    props: { 
     access_token: {
      type: String,
      require: true,
    },
  },
    mounted() {
    const queryString = window.location.search; 
    const urlParams = new URLSearchParams(queryString); 
    this.restaurant_id = urlParams.get('restaurant_id')
    this.getOrders(this.restaurant_id);
  },
  methods: {
    getOrders(id){ 
 axios({
          method: "get",
          url: process.env.MIX_API_URL+"admin/restaurant/"+id+'/booked-table', 
          headers: {
            "Content-Type": "multipart/form-data",
            Authorization: "Bearer " + this.access_token,
          },
        }) .then((response) => {  
                this.transactions = response.data.data;
            })
            .catch((err) => {
                console.log(err);
            });
 }
  },
  data() {
    return {
      title: 'Orders',
      restaurant_id : null,
      items: [
        {
          text: 'Restaurants',
          href: '/admin/restaurant',
        },
        {
          text: 'Orders',
          active: true,
        },
      ],
      transactions: [ ],
    }
  },
}
</script>

<template>
  <Layout :access_token='access_token'>
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
              <!-- end col-->
            </div>
            <!-- Table data -->
            <Transaction :transactions="transactions" />
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
          <!-- end card-body -->
        </div>
        <!-- end card -->
      </div>
      <!-- end col -->
    </div>
    <!-- end row -->
  </Layout>
</template>
