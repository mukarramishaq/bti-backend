<?php

namespace App\Controller;

use App\Repository\StockPriceRepository;
use App\Utils\ResponseFormat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StockPriceController extends AbstractController
{
    private $responseFormatter;

    public function __construct(ResponseFormat $responseFormatter)
    {
        $this->responseFormatter = $responseFormatter;
    }
    /**
     * @Route("/stockprice", name="stockprice.list", methods={"GET"})
     */
    public function getAll(StockPriceRepository $repository): Response
    {
        $companies = $repository->findAll();
        return $this->json($this->responseFormatter->success($companies));
    }

    /**
     * @Route("/stockprice/{id<\d+>}", name="stockprice.getOne", methods={"GET"})
     */
    public function getOne($id, StockPriceRepository $repository): Response
    {
        return $this->json($this->responseFormatter->success($repository->findById($id)));
    }

    /**
     * @Route("/stockprice", name="stockprice.create", methods={"POST"})
     */
    public function create(Request $request, StockPriceRepository $repository): Response
    {
        $data = json_decode($request->getContent(), true);
        $object = $repository->create($data);
        return $this->json($this->responseFormatter->success($object));
    }

    /**
     * @Route("/stockprice/{id<\d+>}", name="stockprice.update", methods={"PUT|PATCH"})
     */
    public function update($id, Request $request, StockPriceRepository $repository): Response
    {
        $data = json_decode($request->getContent(), true);
        $object = $repository->updateById($id, $data);
        return $this->json($this->responseFormatter->success($object));
    }

    /**
     * @Route("/stockprice/{id<\d+>}", name="stockprice.delete", methods={"DELETE"})
     */
    public function delete($id, Request $request, StockPriceRepository $repository): Response
    {
        $object = $repository->deleteById($id);
        return $this->json($this->responseFormatter->success($object));
    }

    /**
     * @Route("/stockprice/highest", methods={"GET"})
     */
    public function highestMarketPrices(Request $request, StockPriceRepository $repository)
    {
        $limit = $request->query->get("limit") ?? 10;
        $query = "select c.id as companyId, c.name as companyName, e.id as exchangeId, e.name as exchangeName, st.id as stockTypeId, st.name as stockTypeName, p.id as priceId, p.price as price, p.created_at as priceDateTime from company c inner join stock_price p on p.company_id = c.id inner join exchange e on e.id = p.exchange_id
        inner join stock_type st on st.id = p.stock_type_id group by c.id, st.id, e.id order by p.created_at desc, p.price desc limit ?";
        $conn = $repository->entityManager->getConnection();
        $stmt = $conn->prepare($query);
        $stmt->execute([$limit]);
        $rows = $stmt->fetchAll();

        /// format and group the data
        $data = [];
        foreach ($rows as $row) {
            $data[$row['priceId']] = $data[$row['priceId']] ?? [
                'id' => $row['priceId'],
                'price' => $row['price'],
                'dateTime' => $row['priceDateTime'],
                'exchange' => ['id' => $row['exchangeId'], 'name' => $row['exchangeName']],
                'stockType' => ['id' => $row['stockTypeId'], 'name' => $row['stockTypeName']],
                'company' => ['id' => $row['companyId'], 'name' => $row['companyName']],
            ];
        }
        return $this->json($this->responseFormatter->success(\array_values($data)));
    }
}
