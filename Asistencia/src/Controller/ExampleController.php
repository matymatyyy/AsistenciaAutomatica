<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


//las rutas se marcan con la anotacion routes y acceden despues por el url
//despues tiene la funcion render que tiene la vista, los parametros y el response
class ExampleController extends AbstractController
{
    #[Route('/bienvenida', name: 'app_bienvenida', methods: ['GET'])]
    public function bienvenida(): Response
    {
        return $this->render('Example/bienvenida.html.twig', [
            'nombre' => 'Matías',
        ]);
    }
}
