import { faCartShopping } from "@fortawesome/free-solid-svg-icons";

const menuPurchases = {
    status: false,
    text: "Compras",
    icom: faCartShopping,
    route: null,
    permissions: "purc_dashboard",
    items: [
        {
            route: route("purc_documents_list"),
            status: false,
            text: "Documentos",
            permissions: "purc_documentos_listado",
        },
        {
            route: route("clients.index"),
            status: false,
            text: "Reporte",
            permissions: "purc_reporte",
        },
    ],
};
export default menuPurchases;
