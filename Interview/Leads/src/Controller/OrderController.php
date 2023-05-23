<?php

namespace App\Controller;

use App\Factory\OrderFactory;
use App\Repository\OrderRepository;
use App\Service\BillGenerator;
use App\Service\BillMicroserviceClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use const App\Entity\CONTRACTOR_TYPE_LEGAL;
use const App\Entity\CONTRACTOR_TYPE_PERSON;

class OrderController
{
    /** @var OrderFactory */
    protected $order_factory;

    /** @var OrderRepository */
    protected $order_repository;

    public function __construct(OrderFactory $order_factory, OrderRepository $order_repository)
    {
        $this->order_factory = $order_factory;
        $this->order_repository = $order_repository;
    }

    /**
     * @Route("/create", methods={"POST"})
     */
    public function create(Request $request)
    {
        $orderData = json_decode($request->getContent(), true);
        $orderId = $this->order_factory->generateOrderId();

        try {
            $order = $this->order_factory->createOrder($orderData, $orderId);

            if ($order->contractorType === CONTRACTOR_TYPE_PERSON) {
                $this->order_repository->save($order);
                return new RedirectResponse($order->getPayUrl());

            }
            if ($order->contractorType === CONTRACTOR_TYPE_LEGAL) {
                $order->setBillGenerator(new BillGenerator());
                $this->order_repository->save($order);
                return new RedirectResponse($order->getBillUrl());
            }
        } catch (\Exception $exception) {
            return new Response("Something went wrong");
        }
    }

    /**
     * @Route("/finish/{orderId}", methods={"GET"})
     */
    public function finish($orderId)
    {
        $order = $this->order_repository->get($orderId);
        if ($order->contractorType == CONTRACTOR_TYPE_LEGAL) {
            $order->setBillClient(new BillMicroserviceClient());
        }
        if ($order->isPaid()) {
            return new Response("Thank you");
        } else {
            return new Response("You haven't paid bill yet");
        }
    }

    /**
     * @Route("/last", methods={"GET"})
     */
    public function last(Request $request)
    {
        $limit = $request->get("limit");
        $orders = $this->order_repository->last($limit);
        return new JsonResponse($orders);
    }
}