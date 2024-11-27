<x-app-layout>
    <x-slot name="header">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('CRUD') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Aquí va mi CRUD -->
            <div class="container my-5">
                
                <div class="row">
                    <!-- Columna izquierda -->
                    <div class="col-md-4">
                        <div class="list-group">
                            <a href="dashboard" class="list-group-item list-group-item-action">
                                Posts
                            </a>
                            <a href="posts/create" class="list-group-item list-group-item-action">
                                Create Posts
                            </a>
                        </div>
                    </div>
                    <!-- Columna derecha -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Producto</div>
                            <div class="card-body">
                                <form action="/posts/store" method="post" enctype="multipart/form-data" required>
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input class= "form-control" type="text" name="nombre" id="nombre" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label">Descripción</label>
                                        <textarea name="descripcion" id="descripcion" cold="5" rows="5" class="form-control"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="marca" class="form-label">Marca</label>
                                        <input class= "form-control" type="text" name="marca" id="marca" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="precio" class="form-label">Precio</label>
                                        <input class= "form-control" type="number" name="precio" id="precio" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="imagen" class="form-label">Imagen</label>
                                        <input class= "form-control" type="file" name="imagen" id="imagen" required>
                                    </div>
                                    <div class="mb 3">
                                        <button class="btn btn-success">Agregar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
