export const menuItems = [ 
    {
        id: 8,
        label: "menuitems.employees.text",
        icon: "bx-user",
        link: "/admin/employees"
    },
    {
        id: 10,
        label: "menuitems.restaurant.text",
        icon: "bx-store",
        subItems: [
            {
                id: 11,
                label: "menuitems.restaurant.text",
                link: "/admin/restaurant",
                parentId: 10
            },
            {
                id: 12,
                label: "menuitems.restaurant.list.restaurantdetail",
                link: "/admin/restaurant-detail",
                parentId: 10
            },
            {
                id: 13,
                label: "menuitems.restaurant.list.orders",
                link: "/admin/restaurant-orders",
                parentId: 10
            },
            {
                id: 14,
                label: "menuitems.restaurant.list.customers",
                link: "/admin/restaurant-customers",
                parentId: 10
            },
            {
                id: 15,
                label: "menuitems.restaurant.list.cart",
                link: "/admin/restaurant-cart",
                parentId: 10
            },
            {
                id: 16,
                label: "menuitems.restaurant.list.checkout",
                link: "/admin/restaurant-checkout",
                parentId: 10
            },
            {
                id: 17,
                label: "menuitems.restaurant.list.shops",
                link: "/admin/restaurant-shops",
                parentId: 10
            },
            {
                id: 18,
                label: "menuitems.restaurant.list.addrestaurant",
                link: "/admin/add-restaurant",
                parentId: 10
            }
        ]
    },



    {
        id: 10,
        label: "menuitems.sales.text",
        icon: "bx-caret-right",
        link: "/sales"
    },
    {
        id: 11,
        label: "menuitems.finances.text",
        icon: "bx-caret-right",
        link: "/finances"
    },
    {
        id: 12,
        label: "menuitems.countries.text",
        icon: "bx-caret-right",
        link: "/countires"
    },
    {
        id: 13,
        label: "menuitems.cities.text",
        icon: "bx-caret-right",
        link: "/cities"
    },
    {
        id: 14,
        label: "menuitems.departements.text",
        icon: "bx-caret-right",
        link: "/departements"
    },
    {
        id: 15,
        label: "menuitems.categories.text",
        icon: "bx-caret-right",
        link: "/categories"
    },
    {
        id: 16,
        label: "menuitems.coupons.text",
        icon: "bx-caret-right",
        link: "/coupons"
    },  
];
