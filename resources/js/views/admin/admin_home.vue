<script>
import Layout from "../../layouts/admin/main"; 
import Stat from "../../components/widgets/stat";  

/**
 * Dashboard Component
 */
export default {
  components: { Layout,Stat },
  data() {
    return {
      title: "Dashboard",
      showModal: false,
      statData: [
        {
          icon: "bx bx-copy-alt",
          title: "Today Sale",
          value: "$235"
        },
        {
          icon: "bx bx-store",
          title: "Total Restaurants",
          value: "35"
        },
        {
          icon: "bx bx-user",
          title: "Total Customers",
          value: "16,333"
        },
        {
          icon: "bx bx-user",
          title: "Total Employee",
          value: "83"
        },
        {
          icon: "bx bx-store",
          title: "Visited Restaurant",
          value: "333"
        }
      ],
      transactions: [
        {
          id: "#SK2540",
          name: "Neal Matthews",
          date: "07 Oct, 2019",
          total: "$400",
          status: "Paid",
          payment: ["fa-cc-mastercard", "Mastercard"],
          index: 1
        },
        {
          id: "#SK2541",
          name: "Jamal Burnett",
          date: "07 Oct, 2019",
          total: "$380",
          status: "Chargeback",
          payment: ["fa-cc-visa", "Visa"],
          index: 2
        },
        {
          id: "#SK2542",
          name: "Juan Mitchell",
          date: "06 Oct, 2019",
          total: "$384",
          status: "Paid",
          payment: ["fab fa-cc-paypal", "Paypal"],
          index: 3
        },
        {
          id: "#SK2543",
          name: "Barry Dick",
          date: "05 Oct, 2019",
          total: "$412",
          status: "Paid",
          payment: ["fa-cc-mastercard", "Mastercard"],
          index: 4
        },
        {
          id: "#SK2544",
          name: "Ronald Taylor",
          date: "04 Oct, 2019",
          total: "$404",
          status: "Refund",
          payment: ["fa-cc-visa", "Visa"],
          index: 5
        },
        {
          id: "#SK2545",
          name: "Jacob Hunter",
          date: "04 Oct, 2019",
          total: "$392",
          status: "Paid",
          payment: ["fab fa-cc-paypal", "Paypal"],
          index: 6
        }
      ]
    };
  },
   mounted() {
    setTimeout(() => {
      this.showModal = true;
    }, 1500);
  },
};
</script>

<template>
  <Layout>
 
    <!-- end page title -->
    <div class="row">
    
          <div v-for="stat of statData" :key="stat.icon" class="col-md-4">
            <Stat :icon="stat.icon" :title="stat.title" :value="stat.value" />
          </div> 
  
    </div>
    <!-- end row --> 
  </Layout>
</template>
