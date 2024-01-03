import { faBellConcierge } from "@fortawesome/free-solid-svg-icons";

const menuRestaurant = {
    status: false,
    text: "Restaurante",
    icom: faBellConcierge,
    route: null,
    permissions: "res_dashboard",
    items: [
        {
            route: route("res_comandas_list"),
            status: false,
            text: "Comandas",
            permissions: "res_comandas",
        },
        {
            route: route("res_menu_list"),
            status: false,
            text: "Menu Del Día",
            permissions: "res_menu",
        },
        {
            route: route("res_sales_create"),
            status: false,
            text: "Vender",
            permissions: "res_venta_nuevo",
        },
    ],
};

export default menuRestaurant;
