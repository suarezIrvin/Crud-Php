<x-app-layout>
    <x-slot name="header">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Papelería y Novedades') }}
        </h2>
        <!-- Botón para generar el PDF -->
        <a href="{{ route('productos.pdf') }}" class="btn btn-primary float-end" target="_blank">Generar PDF</a>
        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addProductModal">
            Agregar Producto
        </button>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Aquí va mi CRUD -->
            <div class="container my-5">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="row">
                    <!-- Columna izquierda -->
                    <div class="col-md-2 mb-3">
                    </div>
                    <!-- Columna derecha -->
                    <div class="col-md-15">
                        <div class="card mb-3">
                            <div class="card-header">Productos</div>
                            <div id="product-list">
                                <h3>Cargando productos...</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar producto -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Agregar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm" action="javascript:void(0);" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input class="form-control" type="text" name="nombre" id="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="marca" class="form-label">Marca</label>
                            <input class="form-control" type="text" name="marca" id="marca" required>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input class="form-control" type="number" name="precio" id="precio" required>
                        </div>
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen</label>
                            <input class="form-control" type="file" name="imagen" id="imagen" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Agregar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar producto -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Editar Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="editNombre" class="form-label">Nombre</label>
                            <input class="form-control" type="text" name="nombre" id="editNombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" id="editDescripcion" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editMarca" class="form-label">Marca</label>
                            <input class="form-control" type="text" name="marca" id="editMarca" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPrecio" class="form-label">Precio</label>
                            <input class="form-control" type="number" name="precio" id="editPrecio" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Imagen actual</label><br>
                            <img id="editImagenPreview" src="" alt="Imagen actual" width="100">
                        </div>
                        <div class="mb-3">
                            <label for="editImagen" class="form-label">Nueva Imagen</label>
                            <input class="form-control" type="file" name="imagen" id="editImagen">
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para mostrar la lista de productos
        async function loadProducts() {
            const response = await fetch('http://127.0.0.1:8000/api/articulos');
            const data = await response.json();
            const productList = document.getElementById('product-list');
            productList.innerHTML = '';

            if (data.length === 0) {
                productList.innerHTML = '<h3>No hay productos registrados</h3>';
                return;
            }

            let tableHTML = `
                <table class="table">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Marca</th>
                            <th>Precio</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            data.forEach(product => {
                tableHTML += `
                    <tr>
                        <td>${product.id}</td>
                        <td>${product.nombre}</td>
                        <td>${product.descripcion}</td>
                        <td>${product.marca}</td>
                        <td>${product.precio}</td>
                        <td><img src="http://127.0.0.1:8000/storage/${product.imagen}" width="100" alt="Imagen"></td>
                        <td>
                            <button 
                                type="button" 
                                class="btn btn-primary btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editProductModal" 
                                onclick="loadProductData(${product.id}, '${product.nombre}', '${product.descripcion}', '${product.marca}', ${product.precio}, '${product.imagen}')">
                                Editar
                            </button>
                            <button 
                                type="button" 
                                class="btn btn-danger btn-sm" 
                                onclick="deleteProduct(${product.id})">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                `;
            });

            tableHTML += '</tbody></table>';
            productList.innerHTML = tableHTML;
        }

        // Función para cargar los datos de un producto en el modal de edición
        function loadProductData(id, nombre, descripcion, marca, precio, imagenUrl) {
            document.getElementById('editNombre').value = nombre;
            document.getElementById('editDescripcion').value = descripcion;
            document.getElementById('editMarca').value = marca;
            document.getElementById('editPrecio').value = precio;
            document.getElementById('editImagenPreview').src = imagenUrl;
            document.getElementById('editProductForm').action = `/api/articulos/${id}`;
        }

        // Función para agregar un producto
        document.getElementById('addProductForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const response = await fetch('http://127.0.0.1:8000/api/articulos', {
                method: 'POST',
                body: formData,
            });

            const data = await response.json();
            if (response.ok) {
                alert('Producto agregado con éxito');
                $('#addProductModal').modal('hide');
                loadProducts();
            } else {
                alert('Error al agregar producto');
            }
        });

        // Función para actualizar un producto
        document.getElementById('editProductForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const productId = document.getElementById('editProductForm').action.split('/').pop();
            const response = await fetch(`http://127.0.0.1:8000/api/articulos/${productId}`, {
                method: 'PUT',
                body: formData,
            });

            const data = await response.json();
            if (response.ok) {
                alert('Producto actualizado con éxito');
                $('#editProductModal').modal('hide');
                loadProducts();
            } else {
                alert('Error al actualizar producto');
            }
        });

        // Función para eliminar un producto
        async function deleteProduct(id) {
            if (confirm('¿Seguro que quieres eliminar este producto?')) {
                const response = await fetch(`http://127.0.0.1:8000/api/articulos/${id}`, {
                    method: 'DELETE',
                });

                if (response.ok) {
                    alert('Producto eliminado con éxito');
                    loadProducts();
                } else {
                    alert('Error al eliminar producto');
                }
            }
        }

        // Cargar los productos cuando la página se cargue
        window.onload = loadProducts;
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
