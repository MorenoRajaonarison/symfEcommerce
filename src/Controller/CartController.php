<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/mon-panier", name="cart")
     * @param Cart $cart
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function index(Cart $cart, EntityManagerInterface $manager): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getFull()
        ]);
    }


    /**
     * @Route("/cart/add/{id}", name="add_to_cart")
     * @param $id
     * @param Cart $cart
     * @return Response
     */
    public function add($id, Cart $cart): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/delete/", name="remove_mycart")
     * @param Cart $cart
     * @return Response
     */
    public function remove(Cart $cart): Response
    {
        $cart->remove();
        return $this->redirectToRoute('product');
    }


    /**
     * @Route("/cart/delete/{id}", name="remove_tocart")
     * @param Cart $cart
     * @return Response
     */
    public function delete($id,Cart $cart): Response
    {
        $cart->delete($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/decrease/{id}", name="decrease_tocart")
     * @param Cart $cart
     * @return Response
     */
    public function decrease($id,Cart $cart): Response
    {
        $cart->decrease($id);
        return $this->redirectToRoute('cart');
    }


}
