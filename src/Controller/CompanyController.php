<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\StockType;
use App\Repository\CompanyRepository;
use App\Repository\StockPriceRepository;
use App\Repository\StockTypeRepository;
use App\Utils\ResponseFormat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;


class CompanyController extends AbstractController
{
    private $responseFormatter;
    private $logger;
    public function __construct(ResponseFormat $responseFormatter, LoggerInterface $logger)
    {
        $this->responseFormatter = $responseFormatter;
        $this->logger = $logger;
    }
    /**
     * @Route("/company", name="company.list", methods={"GET"})
     */
    public function getAll(CompanyRepository $repository): Response
    {
        $companies = $repository->findAll();
        return $this->json($this->responseFormatter->success($companies));
    }

    /**
     * @Route("/company/{id<\d+>}", name="company.getOne", methods={"GET"})
     */
    public function getOne($id, CompanyRepository $repository): Response
    {
        return $this->json($this->responseFormatter->success($repository->findById($id)));
    }

    /**
     * @Route("/company", name="company.create", methods={"POST"})
     */
    public function create(Request $request, CompanyRepository $repository): Response
    {
        $data = json_decode($request->getContent(), true);
        $object = $repository->create($data);
        return $this->json($this->responseFormatter->success($object));
    }

    /**
     * @Route("/company/{id<\d+>}", name="company.update", methods={"PUT|PATCH"})
     */
    public function update($id, Request $request, CompanyRepository $repository): Response
    {
        $data = json_decode($request->getContent(), true);
        $object = $repository->updateById($id, $data);
        return $this->json($this->responseFormatter->success($object));
    }

    /**
     * @Route("/company/{id<\d+>}", name="company.delete", methods={"DELETE"})
     */
    public function delete($id, Request $request, CompanyRepository $repository): Response
    {
        $object = $repository->deleteById($id);
        return $this->json($this->responseFormatter->success($object));
    }

    /**
     * @Route("/company/{id<\d+>}/stockTypes", methods={"GET"})
     */
    public function getAvailableStockTypes($id, CompanyRepository $repository, StockTypeRepository $stRepository)
    {
        $company = $repository->find($id);
        return $this->json($this->responseFormatter->success($stRepository->getAllOfCompany($company)));
    }

    /**
     * @Route("/company/{id<\d+>}/stockType/{stockTypeId<\d+>}/markets", methods={"GET"})
     */
    public function getStockMarkets($id, $stockTypeId, CompanyRepository $repository, StockTypeRepository $stRepository, StockPriceRepository $spRepository)
    {
        $this->logger->debug($id);
        $this->logger->debug($stockTypeId);
        $company = $repository->find($id);
        $stockType = $stRepository->find($stockTypeId);
        return $this->json($this->responseFormatter->success($spRepository->getCompanyStockPrices($company, $stockType)));
    }
}
