var post_url;
var token;
function load_post_url(url, token_){
    post_url = url;
    token = token_
}
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
                const elemento_menu = document.getElementById(producto.id + "_mpc");

                // Verificar si el elemento existe antes de eliminarlo
                if (elemento) {
                    // Eliminar el elemento y su contenido
                    elemento.remove();
                }
                if (elemento_menu) {
                    // Eliminar el elemento y su contenido
                    elemento_menu.remove();
                }
            }
            carrito = JSON.parse(localStorage.getItem("carrito")) || [];
            if(carrito.length<1){
               try {
                document.getElementById("btn-crear-cuenta").setAttribute("disabled", "disabled");
               } catch (error) {

               }
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
        if(typeof producto.color === 'undefined' || producto.color == null){  //para productos tipo cursos capperu
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
        }else{ //para productos con colores celmovil
            //console.log(producto.color);
            const json = producto.color;
            try { //si tiene colores escogerá el indicado si no catch
                const colors = JSON.parse(json.product.sizes).map(size => size.size);

                const colorsObject = {};

                colors.forEach(color => {
                  colorsObject[color] = color;
                });

                (async () => {
                    /* inputOptions can be an object or Promise */
                    const inputOptions = new Promise((resolve) => {
                      setTimeout(() => {
                        resolve(colorsObject); //objeto con los colores
                      }, 1000);
                    });
                    const { value: color } = await Swal.fire({
                      title: "Escoge el color de " + producto.nombre +
                      "<img width='320px' src='"+producto.color.image+"'></img>",
                      input: "radio",
                      inputOptions,
                      inputValidator: (value) => {
                        if (!value) {
                          return "Debes escoger un color!";
                        }
                      }
                    });
                    if (color) {
                                            Swal.fire({ html: `<h4> ` + producto.nombre + ` de color: ${color} fue agregado al carrito de compras.</h4>` });
                                            // Obtener el carrito actual del almacenamiento local
                                            let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
                                                producto.color = color;
                                                producto.quantity = 1;
                                            // Agregar el producto al carrito
                                            carrito.push(producto);

                                            // Guardar el carrito actualizado en el almacenamiento local
                                            localStorage.setItem("carrito", JSON.stringify(carrito));
                                            getTotal();
                                            cargarContadorCarrito();
                                            try {
                                                load_cart_menu();
                                            } catch (error) {

                                            }
                                            try {
                                                cargarItemsCarritoBD();
                                            } catch (error) {

                                            }
                                                }
                                            })();
            } catch (error) { //si no tiene color se elige directo
                                        Swal.fire({ html: `<h4> ` + producto.nombre + ` fue agregado al carrito de compras.</h4>` });
                                        // Obtener el carrito actual del almacenamiento local
                                        let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
                                        producto.color = "no aplica";
                                        producto.quantity = 1;
                                        // Agregar el producto al carrito
                                        carrito.push(producto);

                                        // Guardar el carrito actualizado en el almacenamiento local
                                        localStorage.setItem("carrito", JSON.stringify(carrito));
                                        getTotal();
                                        cargarContadorCarrito();
                                        try {
                                        load_cart_menu();
                                        } catch (error) {

                                        }
                                        try {
                                        cargarItemsCarritoBD();
                                        } catch (error) {

                                        }
            }



            // Swal.fire({
            //     //Consulta para agregar item al CARRITO
            //     title: "Estas a punto de Aprender",
            //     text: '¿Deseas agregar "' + producto.nombre + '" al Carrito?',
            //     icon: "success",
            //     showCancelButton: true,
            //     confirmButtonText: "Sí",
            //     cancelButtonText: "No",
            // }).then((result) => {
            //     if (result.isConfirmed) {
            //         // Obtener el carrito actual del almacenamiento local
            //         let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

            //         // Agregar el producto al carrito
            //         carrito.push(producto);

            //         // Guardar el carrito actualizado en el almacenamiento local
            //         localStorage.setItem("carrito", JSON.stringify(carrito));
            //         getTotal();
            //         cargarContadorCarrito();
            //         cargarItemsCarritoBD();
            //     } else if (result.dismiss === Swal.DismissReason.cancel) {
            //         // Acción a realizar si el usuario hace clic en "No" o cierra el diálogo
            //         console.log("El usuario ha cancelado.");
            //     }
            // });
        }
    }
}

function agregarAlCarrito_w_color(producto) { //agregar al carrito con un color fijo
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
    let color="";
    try {
        console.log( document.getElementById("color_selected").value);
        color = document.getElementById("color_selected").value;
    } catch (error) {
        color = "No Aplica";
        console.log("Color No aplica");
    }
    if (agregar) {
        if(typeof producto.color === 'undefined' || producto.color == null){  //para productos tipo cursos capperu
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
                    producto.color = color;
                    producto.quantity = document.getElementById("quantity").value;

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
        }else{ //para productos con colores celmovil

                if (color) {
                  Swal.fire({ html: `<h4> ` + producto.nombre + ` de color: ${color} fue agregado al carrito de compras.</h4>` + "<img width='320px' src='"+producto.color.image+"'></img>" });
                                      // Obtener el carrito actual del almacenamiento local
                                      let carrito = JSON.parse(localStorage.getItem("carrito")) || [];
                                        producto.color = color;
                                        producto.quantity = document.getElementById("quantity").value;
                                      // Agregar el producto al carrito
                                      carrito.push(producto);

                                      // Guardar el carrito actualizado en el almacenamiento local
                                      localStorage.setItem("carrito", JSON.stringify(carrito));
                                      getTotal();
                                      cargarContadorCarrito();
                                      try {
                                        load_cart_menu();
                                      } catch (error) {

                                      }
                                      try {
                                        cargarItemsCarritoBD();
                                      } catch (error) {

                                      }
                }


            // Swal.fire({
            //     //Consulta para agregar item al CARRITO
            //     title: "Estas a punto de Aprender",
            //     text: '¿Deseas agregar "' + producto.nombre + '" al Carrito?',
            //     icon: "success",
            //     showCancelButton: true,
            //     confirmButtonText: "Sí",
            //     cancelButtonText: "No",
            // }).then((result) => {
            //     if (result.isConfirmed) {
            //         // Obtener el carrito actual del almacenamiento local
            //         let carrito = JSON.parse(localStorage.getItem("carrito")) || [];

            //         // Agregar el producto al carrito
            //         carrito.push(producto);

            //         // Guardar el carrito actualizado en el almacenamiento local
            //         localStorage.setItem("carrito", JSON.stringify(carrito));
            //         getTotal();
            //         cargarContadorCarrito();
            //         cargarItemsCarritoBD();
            //     } else if (result.dismiss === Swal.DismissReason.cancel) {
            //         // Acción a realizar si el usuario hace clic en "No" o cierra el diálogo
            //         console.log("El usuario ha cancelado.");
            //     }
            // });
        }
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
            total += carritoTemp[i].precio*carritoTemp[i].quantity;
        }
        document.getElementById("totalid").textContent = "S/. " + total + ".00";

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
    //var contadorCarritoMovil = document.getElementById("contadorCarritoMovil");
    var contadorCarritoWeb = document.getElementById("contadorCarritoWeb");

    if (valor == 0) {
       // contadorCarritoMovil.setAttribute("hidden", true); // Ocultar el contador
        contadorCarritoWeb.setAttribute("hidden", true); // Ocultar el contador
    } else {
        //contadorCarritoMovil.removeAttribute("hidden"); // Mostrar el contador
        contadorCarritoWeb.removeAttribute("hidden"); // Mostrar el contador
    }
    console.log(valor);
    //contadorCarritoMovil.innerHTML = valor;
    contadorCarritoWeb.innerHTML = valor;
}

function cargarItemsCarritoBD() {
    try {
        document.getElementById('cart').innerHTML =""; // BORRAR contenido de la vista, antes de cargar de la base de datos
    } catch (error) {

    }
    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    myIds = [];
    carrito.forEach(function(item) {
        // Hacer algo con cada elemento del carrito

        myIds.push(parseInt(item.id));
    });

    try {
        btnCrear = document.getElementById("btn-crear-cuenta");
                btnCrear.setAttribute("disabled", "disabled");
    } catch (error) {

    }
    realizarConsulta(myIds);
}

function realizarConsulta(ids) {
    // Realizar la petición Ajax
    var csrfToken = token;


    $.ajax({
        url: post_url,
        type: 'POST',
        data: {
            ids: ids
        },
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(respuesta) {
            // Obtén una referencia al elemento div por su ID
            var divCartHidden = document.getElementById("divCartHidden");
            var index = 0;
            if(document.getElementById('cart'))document.getElementById('cart').innerHTML=null;
            if(document.getElementById('cart-menu'))document.getElementById('cart-menu').innerHTML=null;
            try {
                document.getElementById("input-hidden").innerHTML = null; // borrando inputs del form pay
            } catch (error) {

            }
            respuesta.items.forEach(function(item) {
                // Accede a las propiedades del objeto
                renderProducto(item, index++);
                if (index-1 == respuesta.items.length - 1){
                    cart_menu = document.getElementById('cart-menu');
                    cart_menu.innerHTML +=`
                                        <li class="cart-menu-btn">
                                            <a href="`+ruta_carrito+`">Ir al Carrito</a>
                                            <a style="background-color: red; color: white;" href="" onclick="confirmarEliminarCarrito()">Vaciar Carrito</a>
                                        </li>`;
                }
                // Crea un elemento input oculto
                let inputHidden = document.createElement("input");
                // Establece los atributos del input
                inputHidden.type = "hidden";
                inputHidden.name = "item_id[]"; // Asigna el nombre que desees
                inputHidden.value = item.id; // Asigna el valor que desees
                // Agrega el input al div
                if(divCartHidden){
                    divCartHidden.appendChild(inputHidden);
                }
                //Colocando items en Formulario de Pay
                //----------------------------------------------------------------------product_id
                inputHidden = document.createElement("input");
                inputHidden.type = "hidden";
                inputHidden.name = "product_id[]"; // Asigna el nombre que desees
                inputHidden.value = item.id; // Asigna el valor que desees
                try {
                    document.getElementById("input-hidden").appendChild(inputHidden);
                } catch (error) {

                }
                //----------------------------------------------------------------------product_name
                inputHidden = document.createElement("input");
                inputHidden.type = "hidden";
                inputHidden.name = "product_name[]"; // Asigna el nombre que desees
                inputHidden.value = item.name; // Asigna el valor que desees
                try {
                    document.getElementById("input-hidden").appendChild(inputHidden);
                } catch (error) {

                }
                //---------------------------------------------------------------------product_category_id
                inputHidden = document.createElement("input");
                inputHidden.type = "hidden";
                inputHidden.name = "product_category_id[]"; // Asigna el nombre que desees
                inputHidden.value = item.id; // Asigna el valor que desees
                try {
                    document.getElementById("input-hidden").appendChild(inputHidden);
                } catch (error) {

                }
                //---------------------------------------------------------------------product_quantity
                var dataString = localStorage.getItem("carrito");
                var data = JSON.parse(dataString);
                var quantity;

                for (var i = 0; i < data.length; i++) {
                if (data[i].id === item.id) {
                    quantity = data[i].quantity;
                    break;
                }
                }
                inputHidden = document.createElement("input");
                inputHidden.id = "p_q_"+item.id;
                inputHidden.type = "hidden";
                inputHidden.name = "product_quantity[]"; // Asigna el nombre que desees
                inputHidden.value = quantity; // obtener dato de carrito
                try {
                    document.getElementById("input-hidden").appendChild(inputHidden);
                } catch (error) {

                }
                //---------------------------------------------------------------------product_color
                                var color;

                                for (var i = 0; i < data.length; i++) {
                                if (data[i].id === item.id) {
                                    color = data[i].color;
                                    break;
                                }
                                }
                                inputHidden = document.createElement("input");
                                inputHidden.id = "p_c_"+item.id;
                                inputHidden.type = "hidden";
                                inputHidden.name = "product_color[]"; // Asigna el nombre que desees
                                inputHidden.value = color; // obtener dato de carrito
                                try {
                                    document.getElementById("input-hidden").appendChild(inputHidden);
                                } catch (error) {

                                }
                //---------------------------------------------------------------------product_price
                inputHidden = document.createElement("input");
                inputHidden.type = "hidden";
                inputHidden.name = "product_price[]"; // Asigna el nombre que desees
                inputHidden.value = item.price-item.discount; // Asigna el valor que desees
                try {
                    document.getElementById("input-hidden").appendChild(inputHidden);
                } catch (error) {

                }
                console.log("ITEM: ",item);

            });

            try {
                btnCrear = document.getElementById("btn-crear-cuenta");
                btnCrear.removeAttribute("disabled");
            } catch (error) {

            }

        },
        error: function(xhr) {
            // Ocurrió un error al realizar la consulta
            console.log(xhr.responseText);
            // Aquí puedes manejar el error de alguna manera
        }
    });

}

function renderProducto(respuesta, i) {

    var cart = document.getElementById('cart');
    var cart_menu = document.getElementById('cart-menu');
    var id = respuesta.id;
        var teacher = respuesta.teacher;
        var teacher_id = respuesta.teacher_id;
        var avatar = respuesta.avatar;
        var image = respuesta.image;
        var name = respuesta.name;
        var price = respuesta.price - respuesta.discount;
        var modalidad = respuesta.additional;
        var url_campus = "";
        var url_descripcion_programa = "/descripcion-programa/"+id; // esta ruta deberá corregirse si se cambia el el get de la RUTA :S
        console.log("RESPUESTA", respuesta.product.sizes);
        let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

    if (cart != null) {

        cart.innerHTML += `
                        <tr id="` + id + `_pc">
                            <td class="td-img text-left">
                                <a>
                                    <img style="width: 100px;" src="`+image+`" alt="Imagen Producto" />
                                </a>
                                <div class="">
                                    <p>
                                        <a>`+name+`</a><br>
                                        <b>Color:</b> `+carrito[i].color+`
                                    </p>
                                </div>
                            </td>
                            <td>S/ `+formatearNumero(price)+`</td>
                            <td>
                                <form action="#" method="POST">
                                    <div class="plus-minus">
                                        <a class="dec qtybutton" onclick="quantity(` + i + `, 0, `+price+`)">-</a>
                                        <input type="text" disabled id="`+i+`qty" value="`+carrito[i].quantity+`" name="qtybutton" class="plus-minus-box">
                                        <a class="inc qtybutton" onclick="quantity(` + i + `, 1, `+price+`)">+</a>
                                    </div>
                                </form>
                            </td>
                            <td id="`+i+`subTotal">S/ `+formatearNumero(carrito[i].quantity*price)+`</td>
                            <td><i class="fa fa-trash" title="Remover producto" onclick="eliminarproducto({ id: ` + id + `, nombre: '` +
                            name + `', precio: ` + price + ` });"></i></td>
                        </tr>
        `;
    }
    if (cart_menu) {
        cart_menu.innerHTML +=`
                                        <li id="` + id + `_mpc">
                                            <a><img
                                                    src="`+image+`"
                                                    alt="" /></a>
                                            <div class="cart-menu-title">
                                                <a>
                                                    <h5>`+name+`</h5>
                                                </a>
                                                <span>`+carrito[i].quantity+` x S/ `+formatearNumero(price)+`</span>
                                            </div>
                                            <span class="cancel-item" onclick="eliminarproducto({ id: ` + id + `, nombre: '` +
                                            name + `', precio: ` + price + ` });"><i class="fa fa-close"></i></span>
                                        </li>`
      }
}

function load_cart_menu(){
    try {
        cart_menu = document.getElementById('cart-menu');
        //cart_menu.innerHTML = null;
    } catch (error) {

    }
}
function formatearNumero(numero) {
    // Formatear el número con separadores de miles
    let numeroFormateado = Number(numero).toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

    // Si el número no tiene decimales, agregar ".00" al final
    if (!numeroFormateado.includes('.')) {
        numeroFormateado += ".00";
    }

    return numeroFormateado;
}
