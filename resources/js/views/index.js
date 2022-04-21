import Vue from "vue";
// Use it to import all Vue file containing this folder as Components
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
//admin routes
Vue.component("admin_home", require("./admin/admin_home").default);
Vue.component("employees", require("./admin/employee/employees").default);
Vue.component("finances", require("./admin/finances/finances").default);

Vue.component("my-visited-restaurants", require("./employee/visited-restaurant/my-visited-restaurant").default);

Vue.component("my-booking-meetings", require("./employee/booking-meetings/my-booking-meetings").default);

Vue.component("restaurant", require("./admin/restaurant/restaurant").default);
Vue.component(
    "restaurant-detail",
    require("./admin/restaurant/restaurant-detail").default
);
Vue.component("restaurant-orders", require("./admin/restaurant/orders").default);
Vue.component("restaurant-customers", require("./admin/restaurant/customers").default); 
Vue.component("countries", require("./admin/countries/countries").default); 
Vue.component("country-cities", require("./admin/countries/cities/cities").default); 
Vue.component("country-city-departments", require("./admin/countries/cities/departements/departements").default); 
Vue.component("categories", require("./admin/categories/categories").default); 
Vue.component("coupons", require("./admin/coupons/coupons").default); 

Vue.component("add-restaurant",
    require("./admin/restaurant/add-restaurant").default
);


//employee routes
Vue.component("employee_home", require("./employee/employee_home").default);  

//finance routes      
Vue.component("finance_home", require("./finance/finance_home").default);

//login routes
Vue.component("login", require("./account/login").default);
Vue.component("register", require("./account/register").default);
Vue.component("forgot-password", require("./account/forgot-password").default);
Vue.component("reset-password", require("./account/reset-password").default);

//page not found rotes
Vue.component("pages-404", require("./utility/404").default);
Vue.component("pages-500", require("./utility/500").default);
