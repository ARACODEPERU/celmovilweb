import { faMasksTheater } from "@fortawesome/free-solid-svg-icons";

const menuSocialevents = {
    status: false,
    text: "Eventos",
    icom: faMasksTheater,
    route: null,
    permissions: "even_dashboard",
    items: [
        {
            route: route("even_categories_list"),
            status: false,
            text: "Categorías",
            permissions: "even_categoria_listado",
        },
        {
            route: route("even_local_list"),
            status: false,
            text: "Locales",
            permissions: "even_local_listado",
        },
        {
            route: route("even_eventos_list"),
            status: false,
            text: "Eventos",
            permissions: "even_evento_listado",
        },
        {
            route: route("even_tickets_listado"),
            status: false,
            text: "Ticket Vendidos",
            permissions: "even_ventas_listado",
        },
    ],
};
export default menuSocialevents;
