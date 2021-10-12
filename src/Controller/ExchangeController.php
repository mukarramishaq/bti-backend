<?php

namespace App\Controller;

use App\Entity\Exchange;
use App\Repository\ExchangeRepository;
use App\Repository\StockPriceRepository;
use App\Utils\ResponseFormat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExchangeController extends AbstractController
{
    private $responseFormatter;

    public function __construct(ResponseFormat $responseFormatter)
    {
        $this->responseFormatter = $responseFormatter;
    }
    /**
     * @Route("/exchange", name="exchange.list", methods={"GET"})
     */
    public function getAll(ExchangeRepository $repository): Response
    {
        $companies = $repository->findAll();
        return $this->json($this->responseFormatter->success($companies));
    }

    /**
     * @Route("/exchange/{id<\d+>}", name="exchange.getOne", methods={"GET"})
     */
    public function getOne($id, ExchangeRepository $repository): Response
    {
        return $this->json($this->responseFormatter->success($repository->findById($id)));
    }

    /**
     * @Route("/exchange", name="exchange.create", methods={"POST"})
     */
    public function create(Request $request, ExchangeRepository $repository): Response
    {
        $data = json_decode($request->getContent(), true);
        $object = $repository->create($data);
        return $this->json($this->responseFormatter->success($object));
    }

    /**
     * @Route("/exchange/{id<\d+>}", name="exchange.update", methods={"PUT|PATCH"})
     */
    public function update($id, Request $request, ExchangeRepository $repository): Response
    {
        $data = json_decode($request->getContent(), true);
        $object = $repository->updateById($id, $data);
        return $this->json($this->responseFormatter->success($object));
    }

    /**
     * @Route("/exchange/{id<\d+>}", name="exchange.delete", methods={"DELETE"})
     */
    public function delete($id, Request $request, ExchangeRepository $repository): Response
    {
        $object = $repository->deleteById($id);
        return $this->json($this->responseFormatter->success($object));
    }

    /**
     * @Route("/exchange/{id<\d+>}/prices", name="exchange.prices", methods={"GET"})
     */
    public function getTradePrices(Exchange $exchange, Request $request, ExchangeRepository $repository, StockPriceRepository $spRepository): Response
    {
        return  $this->json($this->responseFormatter->success($spRepository->getExchangePrices($exchange)));
    }

}
