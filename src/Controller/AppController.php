<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * This route will catch all frontend paths and render React SPA
     * Place it **after all API routes** so it doesn't override them
     */
    #[Route('/{reactRouting}', name: 'spa', requirements: ['reactRouting' => '^(?!api/).*'], defaults: ['reactRouting' => null])]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }
}
