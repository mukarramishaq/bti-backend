<?php

namespace App\Controller;

use App\Repository\StockTypeRepository;
use App\Utils\ResponseFormat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StockTypeController extends AbstractController
{
    private $responseFormatter;

    public function __construct(ResponseFormat $responseFormatter)
    {
        $this->responseFormatter = $responseFormatter;
    }
    /**
     * @Route("/stocktype", name="stocktype.list", methods={"GET"})
     */
    public function getAll(StockTypeRepository $repository): Response
    {
        $companies = $repository->findAll();
        return $this->json($this->responseFormatter->success($companies));
    }

    /**
     * @Route("/stocktype/{id}", name="stocktype.getOne", methods={"GET"})
     */
    public function getOne($id, StockTypeRepository $repository): Response
    {
        return $this->json($this->responseFormatter->success($repository->findById($id)));
    }

    /**
     * @Route("/stocktype", name="stocktype.create", methods={"POST"})
     */
    public function create(Request $request, StockTypeRepository $repository): Response
    {
        $data = json_decode($request->getContent(), true);
        $object = $repository->create($data);
        return $this->json($this->responseFormatter->success($object));
    }

    /**
     * @Route("/stocktype/{id}", name="stocktype.update", methods={"PUT|PATCH"})
     */
    public function update($id, Request $request, StockTypeRepository $repository): Response
    {
        $data = json_decode($request->getContent(), true);
        $object = $repository->updateById($id, $data);
        return $this->json($this->responseFormatter->success($object));
    }

    /**
     * @Route("/stocktype/{id}", name="stocktype.delete", methods={"DELETE"})
     */
    public function delete($id, Request $request, StockTypeRepository $repository): Response
    {
        $object = $repository->deleteById($id);
        return $this->json($this->responseFormatter->success($object));
    }
}
