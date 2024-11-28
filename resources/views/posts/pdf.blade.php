<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Artículos</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .image {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <h1>Listado de Artículos</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Imagen</th> <!-- Columna de Imagen -->
            </tr>
        </thead>
        <tbody>
            @foreach($articulos as $articulo)
                <tr>
                    <td>{{ $articulo->id }}</td>
                    <td>{{ $articulo->nombre }}</td>
                    <td>{{ $articulo->descripcion }}</td>
                    <td>{{ $articulo->precio }}</td>
                    <td>
                        @if($articulo->imagen) 
                            <img src="{{ asset('storage/'.$articulo->imagen) }}" class="image" alt="Imagen de {{ $articulo->nombre }}">
                        @else
                            No disponible
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
