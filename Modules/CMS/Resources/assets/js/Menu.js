import { faEarthAmericas } from "@fortawesome/free-solid-svg-icons";

const menuCMS = {
    status: false,
    text: "CMS",
    icom: faEarthAmericas,
    route: null,
    permissions: "cms_dashboard",
    items: [
        {
            route: route("cms_items_list"),
            status: false,
            text: "Items",
            permissions: "cms_items",
        },
        {
            route: route("cms_section_list"),
            status: false,
            text: "Secciones",
            permissions: "cms_seccion",
        },
        {
            route: route("cms_pages_list"),
            status: false,
            text: "Paginas",
            permissions: "cms_pagina",
        },
        {
            route: route("establishments.index"),
            status: false,
            text: "Centros de distribución",
            permissions: "sale_tienda",
        },
        {
            route: route("blog-category.index"),
            status: false,
            text: "Blog Categorías",
            permissions: "blog_categorias",
        },
        {
            route: route("blog-article.index"),
            status: false,
            text: "Blog Artículos",
            permissions: "blog_articulos",
        },
        {
            route: route("blog_subscriber"),
            status: false,
            text: "Suscriptores",
            permissions: "cms_seccion",
        },
        {
            route: route("cms_testimonies_list"),
            status: false,
            text: "Testimonios",
            permissions: "cms_testimonios",
        },
    ],
};
export default menuCMS;
