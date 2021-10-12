<?php

namespace App\Controller;

use App\Utils\ResponseFormat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    private $responseFormatter;

    public function __construct(ResponseFormat $responseFormatter)
    {
        $this->responseFormatter = $responseFormatter;
    }
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->json($this->responseFormatter->success('Welcome to Bill the Investor Rest API!'));
    }
}
