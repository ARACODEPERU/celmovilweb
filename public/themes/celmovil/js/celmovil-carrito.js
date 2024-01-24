// Obtener el carrito actual del almacenamiento local
carrito = JSON.parse(localStorage.getItem("carrito")) || [];
document.addEventListener("DOMContentLoaded", function() {
    getTotal();
cargarContadorCarrito();
  });

//Tiene que hacer una consulta con los datos de la variable carrito para que llene los espacios necesarios de los cursos elegidos

function eliminarproducto(producto) {
    Swal.fire({
        title: "¿Estás seguro?",
        text:
            '¿Deseas quitar "' +
            producto.nombre +
            '" de tu Carrito de compras?',
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Sí",
        cancelButtonText: "No",
    }).then((result) => {
        if (result.isConfirmed) {
            let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
            let indice = carrito.findIndex((item) => item.id === producto.id);
            if (indice >= 0) {
                // Elimina el producto del carrito utilizando el índice
                carrito.splice(indice, 1);
                localStorage.setItem("carrito", JSON.stringify(carrito));

                //codigo que elimine el producto o curso de la vista
                // Seleccionar el elemento con el ID "1pc" el id + la cadena ya especificada en la BD ejemplo id+"pc"
                const elemento = document.getElementById(producto.id + "_pc");

                // Verificar si el elemento existe antes de eliminarlo
                if (elemento) {
                    // Eliminar el elemento y su contenido
                    elemento.remove();
                }
            }
            carrito = JSON.parse(localStorage.getItem("carrito")) || [];
            if(carrito.length<1){
                document.getElementById("btn-crear-cuenta").setAttribute("disabled", "disabled");
            }
            getTotal();
            cargarContadorCarrito();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Acción a realizar si el usuario hace clic en "No" o cierra el diálogo
            console.log("El usuario ha cancelado.");
        }
    });

    //Aquí el producto ya fue eliminado del localstorage y de la vista
    // ahora debería luego de que ya eliminó del localstorage "el producto o curso" verificar si está logueado y si lo está eliminar de la base de datos tambien
}

function agregarAlCarrito(producto) {
    carritoTemp = obtenerCarrito();

    var agregar = true;
    for (let i = 0; i < carritoTemp.length; i++) {
        //consulta si ya exist el artículo en el carrito
        if (carritoTemp[i].id == producto.id) {
            Swal.fire({
                title: "Estimado Usuario",
                text:
                    producto.nombre +
                    " ya se encuentra en su carrito de compras.",
                icon: "warning",
                confirmButtonText: "Aceptar",
            });

            agregar = false;
            break;
        }
    }

    if (agregar) {
        Swal.fire({
            //Consulta para agregar item al CARRITO
            title: "Estas a punto de Aprender",
            text: '¿Deseas agregar "' + producto.nombre + '" al Carrito?',
            icon: "success",
            showCancelButton: true,
            confirmButtonText: "Sí",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                // Obtener el carrito actual del almacenamiento local
                let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

                // Agregar el producto al carrito
                carrito.push(producto);

                // Guardar el carrito actualizado en el almacenamiento local
                localStorage.setItem("carrito", JSON.stringify(carrito));
                getTotal();
                cargarContadorCarrito();
                cargarItemsCarritoBD();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                // Acción a realizar si el usuario hace clic en "No" o cierra el diálogo
                console.log("El usuario ha cancelado.");
            }
        });
    }
}

// Obtener el carrito actual
function obtenerCarrito() {
    return JSON.parse(localStorage.getItem("carrito")) || [];
}

function eliminarCarrito() {
    //ELiminar por completo el carrito de Compras
    localStorage.removeItem("carrito");
    getTotal();
    cargarContadorCarrito();
}

function getTotal() {
    var elemento = document.getElementById("totalid");

    if (elemento !== null) {
        // El elemento con el ID 'totalid' existe
        // Puedes realizar operaciones en el elemento aquí
        carritoTemp = JSON.parse(localStorage.getItem("carrito")) || [];
        total = 0;
        for (let i = 0; i < carritoTemp.length; i++) {
            total += carritoTemp[i].precio;
        }
        document.getElementById("totalid").textContent = "S/. " + total + ".00";
        total_productos = carritoTemp.length;
        document.getElementById("total_productos").innerHTML =
            total_productos + " programas en el carrito.";
    }
}
function cargarContadorCarrito() {
    // Obtener el carrito actual del almacenamiento local
    carrito = JSON.parse(localStorage.getItem("carrito")) || [];

    actualizarContador(carrito.length);
}
// Actualizar el valor del contador
function actualizarContador(valor) {
    // Obtener el elemento del contador
    var contadorCarritoMovil = document.getElementById("contadorCarritoMovil");
    var contadorCarritoWeb = document.getElementById("contadorCarritoWeb");

    if (valor == 0) {
        contadorCarritoMovil.setAttribute("hidden", true); // Ocultar el contador
        contadorCarritoWeb.setAttribute("hidden", true); // Ocultar el contador
    } else {
        contadorCarritoMovil.removeAttribute("hidden"); // Mostrar el contador
        contadorCarritoWeb.removeAttribute("hidden"); // Mostrar el contador
    }
    contadorCarritoMovil.innerHTML = valor;
    contadorCarritoWeb.innerHTML = valor;
}
