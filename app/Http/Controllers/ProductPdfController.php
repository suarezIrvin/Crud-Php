<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulos;
use Dompdf\Dompdf;
use Dompdf\Options;

class ProductPdfController extends Controller
{
    public function generatePdf()
    {
        // Obtener todos los artículos
        $articulos = Articulos::all();

        // Inicializar DomPDF
        $dompdf = new Dompdf();

        // Configurar DomPDF (opcional)
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf->setOptions($options);

        // Obtener contenido HTML con las imágenes en base64
        $html = view('posts.pdf', compact('articulos'))->render();

        // Reemplazar las rutas de las imágenes con base64
        foreach ($articulos as $articulo) {
            if ($articulo->imagen) {
                // Obtener la ruta absoluta de la imagen
                $imagePath = public_path('storage/' . $articulo->imagen);

                if (file_exists($imagePath)) {
                    // Obtener el contenido de la imagen y convertirlo a base64
                    $imageData = base64_encode(file_get_contents($imagePath));
                    $imageUrl = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . $imageData;

                    // Reemplazar la URL de la imagen en el HTML con base64
                    $html = str_replace(asset('storage/'.$articulo->imagen), $imageUrl, $html);
                }
            }
        }

        // Cargar el HTML en DomPDF
        $dompdf->loadHtml($html);

        // Establecer el tamaño del papel
        $dompdf->setPaper('A4', 'portrait');

        // Renderizar el PDF
        $dompdf->render();

        // Descargar el PDF generado
        return $dompdf->stream('posts.pdf');
    }
}
