<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class=" bg-opacity-25 grid grid-cols-1 md:grid-cols-4 dark:bg-gray-600">
        <div v-role="'admin'" class="p-6">
            <Link title="Productos" :href="route('products.index')" class="w-full inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight uppercase rounded hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                Productos
                <div class="flex flex-wrap justify-center">
                    <img
                        src="img/revisa.png"
                        alt="Productos"
                        style="width: 70px;"
                    />
                </div>
            </Link>
        </div>
        <div  v-can="'caja_chica'" class="p-6">
            <Link :href="route('pettycash.index')" type="button" class="w-full inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight uppercase rounded hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                Caja Chica
                <div class="flex flex-wrap justify-center">
                    <img
                        src="img/cartera.png"
                        alt="Caja Chica"
                        style="width: 70px;"
                    />
                </div>
            </Link>
        </div>
        <div v-role="'admin'" class="p-6">
            <Link :href="route('clients.index')" class="w-full inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight uppercase rounded hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                Clientes
                <div class="flex flex-wrap justify-center">
                    <img
                        src="img/clientes.png"
                        alt="Productos"
                        style="width: 70px;"
                    />
                </div>
            </Link>
        </div>
        <div v-role="'admin'" class="p-6">
            <Link :href="route('providers.index')" class="w-full inline-block px-6 py-2 border-2 border-blue-600 text-blue-600 font-medium text-xs leading-tight uppercase rounded hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                Proveedores
                <div class="flex flex-wrap justify-center">
                    <img
                        src="img/proveedor.png"
                        alt="Proveedores"
                        style="width: 70px;"
                    />
                </div>
            </Link>
        </div>
    </div>
    <div class=" bg-opacity-25 grid grid-cols-1 md:grid-cols-4 dark:bg-gray-600">
        <div v-can="'punto_ventas'" class="p-6">
            <Link :href="route('sales.index')" class="w-full inline-block px-6 py-2 border-2 font-medium text-xs leading-tight uppercase rounded hover:bg-gray-100 dark:text-yellow-500 dark:hover:bg-black dark:hover:bg-opacity-5 dark:border-yellow-500 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                Punto de Ventas
                <div class="flex flex-wrap justify-center">
                    <img
                        src="img/caja-registradora.png"
                        alt="Punto de Ventas"
                        style="width: 70px;"
                    />
                </div>
            </Link>
        </div>
        <div v-role="'admin'" class="p-6">
            <Link :href="route('users.index')" type="button" class="w-full inline-block px-6 py-2 border-2 font-medium text-xs leading-tight uppercase rounded hover:bg-gray-100 dark:text-yellow-500 dark:hover:bg-black dark:hover:bg-opacity-5 dark:border-yellow-500 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                Usuarios
                <div class="flex flex-wrap justify-center">
                    <img
                        src="img/empleados.png"
                        alt="Usuarios"
                        style="width: 70px;"
                    />
                </div>
            </Link>
        </div>
        <div v-role="'admin'" class="p-6">
            <Link :href="route('establishments.index')" type="button" class="w-full inline-block px-6 py-2 border-2 font-medium text-xs leading-tight uppercase rounded hover:bg-gray-100 dark:text-yellow-500 dark:hover:bg-black dark:hover:bg-opacity-5 dark:border-yellow-500 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                Tiendas
                <div class="flex flex-wrap justify-center">
                    <img
                        src="img/tienda.png"
                        alt="tienda"
                        style="width: 70px;"
                    />
                </div>
            </Link>
        </div>
        <div class="p-6">
            <Link v-role="'admin'" :href="route('reports')"  type="button" class="w-full inline-block px-6 py-2 border-2 font-medium text-xs leading-tight uppercase rounded hover:bg-gray-100 dark:text-yellow-500 dark:hover:bg-black dark:hover:bg-opacity-5 dark:border-yellow-500 focus:outline-none focus:ring-0 transition duration-150 ease-in-out">
                Reportes
                <div class="flex flex-wrap justify-center">
                    <img
                        src="img/reporte.png"
                        alt="reportes"
                        style="width: 70px;"
                    />
                </div>

            </Link>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 dark:bg-gray-600">
        <div class="p-6">
            <Link v-role="'admin'" :href="route('kardex_index')" class="w-full inline-flex items-center justify-center p-5 text-base font-medium text-gray-500 rounded-lg bg-gray-100 hover:text-gray-800 hover:bg-gray-200 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white">
                <svg aria-hidden="true" class="w-5 h-5 mr-3" viewBox="0 0 22 31" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_4151_63004)"><path d="M5.50085 30.1242C8.53625 30.1242 10.9998 27.8749 10.9998 25.1035V20.0828H5.50085C2.46546 20.0828 0.00195312 22.332 0.00195312 25.1035C0.00195312 27.8749 2.46546 30.1242 5.50085 30.1242Z" fill="#0ACF83"/><path d="M0.00195312 15.062C0.00195312 12.2905 2.46546 10.0413 5.50085 10.0413H10.9998V20.0827H5.50085C2.46546 20.0827 0.00195312 17.8334 0.00195312 15.062Z" fill="#A259FF"/><path d="M0.00195312 5.02048C0.00195312 2.24904 2.46546 -0.000244141 5.50085 -0.000244141H10.9998V10.0412H5.50085C2.46546 10.0412 0.00195312 7.79193 0.00195312 5.02048Z" fill="#F24E1E"/><path d="M11 -0.000244141H16.4989C19.5343 -0.000244141 21.9978 2.24904 21.9978 5.02048C21.9978 7.79193 19.5343 10.0412 16.4989 10.0412H11V-0.000244141Z" fill="#FF7262"/><path d="M21.9978 15.062C21.9978 17.8334 19.5343 20.0827 16.4989 20.0827C13.4635 20.0827 11 17.8334 11 15.062C11 12.2905 13.4635 10.0413 16.4989 10.0413C19.5343 10.0413 21.9978 12.2905 21.9978 15.062Z" fill="#1ABCFE"/></g><defs><clipPath id="clip0_4151_63004"><rect width="22" height="30.1244" fill="white" transform="translate(0 -0.000244141)"/></clipPath></defs></svg>                                              
                <span class="w-full">Inventario</span>
                <svg aria-hidden="true" class="w-6 h-6 ml-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </Link>
        </div>
    </div>
</template>
