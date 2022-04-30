<script>
import VueSlideBar from "vue-slide-bar"; 
import Layout from "../../../layouts/admin/main";
import axios from "axios"
import PageHeader from "../../../components/page-header";      
 
/**
 * Products component
 */
export default {
      props: {
    access_token: {
      type: String,
      require: true,
    },
  },
    components: {
        VueSlideBar,
        Layout,
        PageHeader,
    }, 
    data() {
        return {
            restaurantsData: [],
            title: "Restaurant",
            items: [ 
                {
                    text: "Restaurant",
                    active: true,
                },
            ],
            sliderPrice: 800,
            currentPage: 1,
            discountRates: [],
            records: [],
            prices: [],
            selected: {
                prices: [],
            },
        };
    },
    watch: {
        selected: {
            handler: function () {
                this.loadPrices();
            },
            deep: true,
        },
    },
    mounted() { 
        this.loadRestaurants()
 
    },
    
    methods: { 
 loadRestaurants(){
 axios({
          method: "get",
          url: process.env.MIX_API_URL+"admin/restaurant", 
          headers: {
            "Content-Type": "multipart/form-data",
            Authorization: "Bearer " + this.access_token,
          },
        }) .then((response) => { 
                // this.records = response.data.data;
                this.restaurantsData = response.data.data;
            })
            .catch((err) => {
                console.log(err);
            });
 },

        searchFilter(e) { 
            const searchStr = e.target.value;  
            if(searchStr=='')
                 this.loadRestaurants()
            else
            this.restaurantsData = this.restaurantsData.filter((restaurant) => { 
                return (
                    restaurant.first_name.toLowerCase().search(searchStr.toLowerCase()) !== -1
                );
            });
        },

        // discountLessFilter(e, percentage) {
        //     if (e === "accepted" && this.discountRates.length === 0) {
        //         this.restaurantsData = restaurantsData.filter((product) => {
        //             return product.discount < percentage;
        //         });
        //     } else {
        //         this.restaurantsData = restaurantsData.filter((product) => {
        //             return product.discount >= Math.max.apply(null, this);
        //         }, this.discountRates);
        //     }
        // },

        // discountMoreFilter(e, percentage) {
        //     if (e === "accepted") {
        //         this.discountRates.push(percentage);
        //     } else {
        //         this.discountRates.splice(this.discountRates.indexOf(percentage), 1);
        //     }
        //     this.restaurantsData = restaurantsData.filter((product) => {
        //         return product.discount >= Math.max.apply(null, this);
        //     }, this.discountRates);
        // },
    },
};
</script>

<template>
<Layout :access_token='access_token'>
    <PageHeader :title="title" :items="items" />

    <div class="row">
       
        <div class="col-lg-12">
            <div class="row mb-3">
                <div class="col-xl-4 col-sm-6">
                    <div class="mt-2"> 
                    </div>
                </div>
                <div class="col-lg-8 col-sm-6">
                  <form class="mt-4 mt-sm-0 float-sm-end d-flex align-items-center">
                        <div class="search-box me-2">
                            <div class="position-relative">
                                <input type="text" class="form-control border-0" placeholder="Search..." @input="searchFilter($event)" />
                                <i class="bx bx-search-alt search-icon"></i>
                            </div>
                        </div>
                        <ul class="nav nav-pills product-view-nav">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript: void(0);">
                                    <i class="bx bx-grid-alt"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript: void(0);">
                                    <i class="bx bx-list-ul"></i>
                                </a>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>

            <div class="row">
               
                <div v-for="(item, index) in restaurantsData"  :key="index" class="col-xl-4 col-sm-6">
                    <div class="card"  v-show="index+1 <= currentPage * 6 && index+1 >   (currentPage-1)*6"> 
                        <div class="card-body">
                            <div class="product-img position-relative">
                                <div  class="avatar-sm product-ribbon">
                                       <a  :href="`/admin/restaurant-orders?restaurant_id=${item.id}`">
                                    <span class="avatar-title rounded-circle bg-primary">
                                     Orders
                                        </span></a>
                                </div>
                                <a :href="`/admin/restaurant-detail?restaurant_id=${item.id}`">
                                    <img :src="`${item.photo}`" :alt='item.first_name' class="img-fluid mx-auto d-block" />
                                </a>
                            </div>
                            <div class="mt-4 text-center">
                                <h5 class="mb-3 text-truncate">
                                    <a class="text-dark" :href="`/admin/restaurant-detail${item.id}`">{{ item.first_name }}</a>
                                </h5>
                                <p class="text-muted">

                                    <i class="bx bx-star" :class="item.review_details.rating>0?'text-warning':'ml-1'"></i>
                                    <i class="bx bx-star" :class="item.review_details.rating>1?'text-warning':'ml-1'"></i>
                                    <i class="bx bx-star" :class="item.review_details.rating>2?'text-warning':'ml-1'"></i>
                                    <i class="bx bx-star" :class="item.review_details.rating>3?'text-warning':'ml-1'"></i>
                                    <i class="bx bx-star" :class="item.review_details.rating>4?'text-warning':'ml-1'"></i>                                 
                                </p>   
                                <h5 class="my-0">
                                    <b>{{ item.phone }}</b>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-lg-12"> 
                    <b-pagination v-if="restaurantsData.length > 0" class="justify-content-center" pills v-model="currentPage" :total-rows="restaurantsData.length" :per-page="6" aria-controls="my-table"></b-pagination>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</Layout>
</template>
