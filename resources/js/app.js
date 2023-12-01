import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import VueGates from "vue-gates";
import { createInertiaApp, router } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import VueTheMask from "vue-the-mask";
import Permissions from "./Plugins/Permissions";

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        let parts = name.split("::");
        if (parts.length > 1) {
            return resolvePageComponent(
                `../../Modules/${parts[0]}/Resources/assets/js/Pages/${parts[1]}.vue`,
                import.meta.glob(
                    "../../Modules/*/Resources/assets/js/Pages/**/*.vue"
                )
            );
        } else {
            return resolvePageComponent(
                `./Pages/${name}.vue`,
                import.meta.glob("./Pages/**/*.vue")
            );
        }
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(VueTheMask)
            .use(VueGates)
            .use(Permissions)
            .component("font-awesome-icon", FontAwesomeIcon);

        //.mount(el);
        // Agregar el código de manejo de redireccionamiento
        app.mixin({
            mounted() {
                router.on("error", (error) => {
                    //console.log(error);
                    if (error.response && error.response.status === 401) {
                        // Redirigir al inicio de sesión cuando la sesión ha caducado
                        router.visit("/login", { replace: true });
                    }
                });
            },
        });
        return app.mount(el);
    },
    progress: {
        // The delay after which the progress bar will appear, in milliseconds...
        delay: 250,

        // The color of the progress bar...
        color: "#4B5563",

        // Whether to include the default NProgress styles...
        includeCSS: true,

        // Whether the NProgress spinner will be shown...
        showSpinner: true,
    },
});
