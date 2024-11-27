<x-app-layout>
    <x-slot name="header">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Papelería y Novedades') }}
        </h2>
        <!-- Botón para abrir el modal -->
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
                            @if ($articulos->count() > 0)

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
                                    @foreach ($articulos as $articulo)
                                        <tr>
                                            <td>{{ $articulo->id }}</td>
                                            <td>{{ $articulo->nombre }}</td>
                                            <td>{{ $articulo->descripcion }}</td>
                                            <td>{{ $articulo->marca }}</td>
                                            <td>{{ $articulo->precio }}</td>
                                            <td><img src="{{ asset('storage/'.$articulo->imagen) }}" width="100" alt="Imagen"></td>
                                            <td>
                                            <button 
                                                type="button" 
                                                 class="btn btn-primary btn-sm" 
                                                 data-bs-toggle="modal" 
                                                 data-bs-target="#editProductModal" 
                                                 onclick="loadProductData({{ $articulo->id }}, '{{ $articulo->nombre }}', '{{ $articulo->descripcion }}', '{{ $articulo->marca }}', {{ $articulo->precio }}, '{{ asset('storage/'.$articulo->imagen) }}')">
                                                 Editar
                                            </button>  
                                            <form id="deleteForm-{{$articulo->id}}" class="d-inline" action="/posts/{{$articulo->id}}/delete" method="post">
                                             @csrf
                                             @method('delete')
                                            <button 
                                              type="button" 
                                                class="btn btn-danger btn-sm" 
                                               onclick="confirmDelete({{$articulo->id}})">
                                                  Eliminar
                                             </button>
                                            </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else 
                            <h3>No hay registro</h3>
                            @endif
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
                    <form action="/posts/store" method="post" enctype="multipart/form-data">
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
                <form id="editProductForm" method="post" enctype="multipart/form-data">
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
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar el formulario correspondiente
                document.getElementById('deleteForm-' + id).submit();
            }
        });
    }
</script>

<script>
    function loadProductData(id, nombre, descripcion, marca, precio, imagenUrl) {
        // Llenar los campos del modal con los datos del producto
        document.getElementById('editNombre').value = nombre;
        document.getElementById('editDescripcion').value = descripcion;
        document.getElementById('editMarca').value = marca;
        document.getElementById('editPrecio').value = precio;
        document.getElementById('editImagenPreview').src = imagenUrl;

        // Actualizar la acción del formulario para incluir el ID del producto
        document.getElementById('editProductForm').action = `/posts/${id}/update`;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
