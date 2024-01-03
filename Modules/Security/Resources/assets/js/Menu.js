import { faGear } from "@fortawesome/free-solid-svg-icons";

const menuConfig = {
    status: false,
    text: "Configuraciones",
    icom: faGear,
    route: null,
    permissions: "configuracion",
    items: [
        {
            route: route("company_show"),
            status: false,
            text: "Empresa",
            permissions: "empresa",
        },
        {
            route: route("roles.index"),
            status: false,
            text: "Roles",
            permissions: "roles",
        },
        {
            route: route("permissions.index"),
            status: false,
            text: "Permisos",
            permissions: "permisos",
        },
        {
            route: route("users.index"),
            status: false,
            text: "usuarios",
            permissions: "usuarios",
        },
        {
            route: route("parameters"),
            status: false,
            text: "Parámetros del sistema",
            permissions: "parametros",
        },
    ],
};
export default menuConfig;
