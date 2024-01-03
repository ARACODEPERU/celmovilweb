import { faCashRegister } from "@fortawesome/free-solid-svg-icons";

const menuSales = {
    status: false,
    text: "Ventas",
    icom: faCashRegister,
    route: null,
    permissions: "sale_dashboard",
    items: [
        {
            route: route("establishments.index"),
            status: false,
            text: "Tiendas",
            permissions: "sale_tienda",
        },
        {
            route: route("clients.index"),
            status: false,
            text: "Clientes",
            permissions: "clientes",
        },
        {
            route: route("pettycash.index"),
            status: false,
            text: "Caja Chica",
            permissions: "caja_chica",
        },
        {
            status: false,
            route: route("products.index"),
            text: "Gestión Productos & servicios",
            permissions: "productos",
        },
        {
            route: route("sales.index"),
            status: false,
            text: "Punto de venta (POS)",
            permissions: "punto_ventas",
        },
        {
            route: route("sale_physical_document_list"),
            status: false,
            text: "Documento Físico",
            permissions: "sale_documento_fisico",
        },
        {
            route: route("reports"),
            status: false,
            text: "Reportes",
            permissions: "sale_reportes",
        },
    ],
};
export default menuSales;
