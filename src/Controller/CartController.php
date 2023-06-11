<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\MyClass\Cart;

class CartController extends AbstractController
{

    #[Route('/cart', name: 'app_cart')]
    public function index(Cart $cart): Response
    {
      
        return $this->render('cart/index.html.twig', [
            'cart' => $cart ->getFullCart(),
            'total'=>$cart->getTotal()
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add(Cart $cart, int $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('app_cart');
    }
    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    public function remove(Cart $cart, int $id): Response
    {
        $cart->remove($id);
        return $this->redirectToRoute('app_cart');
    }
    #[Route('/cart/delete', name: 'app_cart_delete')]
    public function delete(Cart $cart): Response
    {
        $cart->delete();
        return $this->redirectToRoute('app_cart');
    }
}
