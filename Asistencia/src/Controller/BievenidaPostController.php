<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class BievenidaPostController extends AbstractController
{
    #[Route('/bievenida/marcar', name: 'asistencia_marcar', methods: ['POST'])]
    public function marcar(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $lat = $data['lat'] ?? null;
        $lon = $data['lon'] ?? null;

        $campusLat = -34.63799257139449;   // Latitud del campus (ejemplo)
        $campusLon = -60.471895526835176;   // Longitud del campus
        $radio = 100;              // Radio válido en metros

        function distanciaHaversine($lat1, $lon1, $lat2, $lon2) {
            $pi80 = M_PI / 180;
            $lat1 *= $pi80; $lon1 *= $pi80;
            $lat2 *= $pi80; $lon2 *= $pi80;
            $r = 6372.797;  // radio medio de la Tierra en km
            $dLat = $lat2 - $lat1;
            $dLon = $lon2 - $lon1;
            $a = sin($dLat/2)*sin($dLat/2) 
            + cos($lat1)*cos($lat2)*sin($dLon/2)*sin($dLon/2);
            $c = 2 * atan2(sqrt($a), sqrt(1-$a));
            return $r * $c; // km
        }
        $distancia = distanciaHaversine($lat, $lon, $campusLat, $campusLon) * 1000; // en metros

        $respuesta = "";
        $radio = 100; // en metros
        if ($distancia <= $radio) {
            // Dentro del campus: registrar asistencia
            $respuesta = "Hola estas dentro del campos(100m) de la escuela, tu ubi: latitud $lat, altitud: $lon,
            la ubicacion de la escuela: latitud $campusLat, altitud: $campusLon";
        } else {
            $respuesta = "Hola NO estas dentro del campos(100m) de la escuela, tu ubi: latitud $lat, altitud: $lon,
            la ubicacion de la escuela: latitud $campusLat, altitud: $campusLon";
        }

        $response = [
            "status" => "success",
            "dentro" => $distancia <= $radio,
            "lat" => $lat,
            "lon" => $lon,
            "campusLat" => $campusLat,
            "campusLon" => $campusLon
        ];

        return new JsonResponse($response);
    }

    
}
