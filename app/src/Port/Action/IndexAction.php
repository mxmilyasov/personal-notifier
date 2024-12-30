<?php

declare(strict_types=1);

namespace App\Port\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/', name: self::class, methods: ['GET'])]
final class IndexAction extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render(
            view: 'hello.html.twig',
            response: new Response('', Response::HTTP_OK, ['Content-Type' => 'text/html']),
        );
    }
}
