<script>
import VueSlideBar from "vue-slide-bar"; 
import Layout from "../../../layouts/admin/main";
import PageHeader from "../../../components/page-header";      
import {
    clothsData
} from "./data-products"; 
/**
 * Products component
 */
export default {
    components: {
        VueSlideBar,
        Layout,
        PageHeader,
    },
    data() {
        return {
            clothsData: clothsData,
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
        // axios
        //     .get("/api/products")
        //     .then((response) => {
        //         this.records = response.data.data;
        //     })
        //     .catch((err) => {
        //         console.log(err);
        //     });

        this.loadPrices();
    },
    methods: {
        loadPrices() {},

        valuechange(value) {
            this.clothsData = clothsData.filter(function (product) {
                return product.newprice <= value.currentValue;
            });
        },

        searchFilter(e) {
            const searchStr = e.target.value;
            this.clothsData = clothsData.filter((product) => {
                return (
                    product.name.toLowerCase().search(searchStr.toLowerCase()) !== -1
                );
            });
        },

        discountLessFilter(e, percentage) {
            if (e === "accepted" && this.discountRates.length === 0) {
                this.clothsData = clothsData.filter((product) => {
                    return product.discount < percentage;
                });
            } else {
                this.clothsData = clothsData.filter((product) => {
                    return product.discount >= Math.max.apply(null, this);
                }, this.discountRates);
            }
        },

        discountMoreFilter(e, percentage) {
            if (e === "accepted") {
                this.discountRates.push(percentage);
            } else {
                this.discountRates.splice(this.discountRates.indexOf(percentage), 1);
            }
            this.clothsData = clothsData.filter((product) => {
                return product.discount >= Math.max.apply(null, this);
            }, this.discountRates);
        },
    },
};
</script>

<template>
<Layout>
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
               
                <div v-for="(item, index) in clothsData" :key="index" class="col-xl-4 col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-img position-relative">
                                <div  class="avatar-sm product-ribbon">
                                       <a href="/admin/restaurant-orders?restaurant_id=2">
                                    <span class="avatar-title rounded-circle bg-primary">
                                     Orders
                                        </span></a>
                                </div>
                                <a :href="`/admin/restaurant-detail`">
                                    <img :src="`${item.product}`" alt class="img-fluid mx-auto d-block" />
                                </a>
                            </div>
                            <div class="mt-4 text-center">
                                <h5 class="mb-3 text-truncate">
                                    <a class="text-dark" :href="`/admin/restaurant-detail${item.id}`">{{ item.name }}</a>
                                </h5>
                                <p class="text-muted">
                                    <i class="bx bx-star text-warning"></i>
                                    <i class="bx bx-star text-warning"></i>
                                    <i class="bx bx-star text-warning"></i>
                                    <i class="bx bx-star text-warning"></i>
                                    <i class="bx bx-star text-warning"></i>
                                </p>
                                <h5 class="my-0">
                                    <b># {{ item.phone }}</b>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-lg-12">
                    <b-pagination v-if="clothsData.length > 0" class="justify-content-center" pills v-model="currentPage" :total-rows="clothsData.length" :per-page="6" aria-controls="my-table"></b-pagination>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</Layout>
</template>
