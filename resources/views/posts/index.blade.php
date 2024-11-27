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
                            <div class="card-header">Posts</div>
                            <div class="card-body">
                              <table class="table">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>Marca</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                              </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
