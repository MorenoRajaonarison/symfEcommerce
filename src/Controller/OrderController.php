<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/commande", name="order")
     * @param Cart $cart
     * @param Request $request
     * @return Response
     */
    public function index(Cart $cart, Request $request): Response
    {
        if (!$this->getUser()->getAddresses()->getValues()) {
            return $this->redirectToRoute('account_address_add');
        }
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);
        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);
    }

    /**
     * @Route("/commande/recapitulatif", name="order-recap",methods={"POST"})
     * @param Cart $cart
     * @param Request $request
     * @return Response
     */
    public function add(Cart $cart, Request $request): Response
    {
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ])->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $delivery = $form->get('adresses')->getData();
            $delivery_content = $delivery->getFirstname() . ' ' . $delivery->getLastname();
            $delivery_content .= '<br>' . $delivery->getPhone();
            if ($delivery->getCompany()) {
                $delivery_content .= '<br>' . $delivery->getCompany();
            }
            $delivery_content .= '<br>' . $delivery->getAddress();
            $delivery_content .= '<br>' . $delivery->getPostal() . ' ' . $delivery->getCity();
            $delivery_content .= '<br>' . $delivery->getCountry();

            $order = new Order();
            $order->setUser($this->getUser());
            $order->setCreatedAt(new \DateTime());
            $order->setCarrierName($form->get('carriers')->getData()->getName());
            $order->setCarrierPrice($form->get('carriers')->getData()->getPrice());
            $order->setDelivery($delivery_content);
            $order->setIsPayed(0);

            $this->manager->persist($order);

            foreach ($cart->getFull() as $product) {
                $order_details = new OrderDetails();
                $order_details->setMyOrder($order);
                $order_details->setProduct($product['product']->getName());
                $order_details->setPrice($product['product']->getPrice());
                $order_details->setTotal($product['product']->getPrice() * $product['quantity']);
                $order_details->setQuantity($product['quantity']);
                $this->manager->persist($order_details);
            }
            $this->manager->flush();
            return $this->render('order/add.html.twig', [
                'cart' => $cart->getFull(),
                'carrier' => $form->get('carriers')->getData(),
                'delivery' => $delivery_content
            ]);
        }
        return  $this->redirectToRoute('cart');
    }
}
