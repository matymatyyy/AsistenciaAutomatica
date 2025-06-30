<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExampleController extends AbstractController
{
    #[Route('/bienvenida', name: 'app_bienvenida', methods: ['GET'])]
    public function bienvenida(): Response
    {
        return $this->render('Example/bienvenida.html.twig', []);
    }
}
