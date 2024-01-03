import { faUserGear } from "@fortawesome/free-solid-svg-icons";

const menuHelpdesk = {
    status: false,
    text: "Centro de Soporte",
    icom: faUserGear,
    route: null,
    permissions: "help_dashboard",
    items: [
        {
            route: route("help-level.index"),
            status: false,
            text: "Niveles",
            permissions: "help_nivel",
        },
        {
            route: route("helpdesk_incidents"),
            status: false,
            text: "Banco de Preguntas",
            permissions: "help_incidentes",
        },
        {
            route: route("help-boards.index"),
            status: false,
            text: "Tableros",
            permissions: "help_tableros",
        },
    ],
};
export default menuHelpdesk;
