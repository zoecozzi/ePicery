<?php
namespace App\MyClass;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

class Cart 
{
    private $session;
    private $entityManager;

    public function __construct(private RequestStack $requestStack, private EntityManagerInterface $em)
    {
        $this->session = $this->requestStack->getSession();
        $this->entityManager = $em;
    }

    public function add(int $id)
    {
        $cart = $this->session->get('cart', []);
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        $this->session->set('cart', $cart);
    }

    public function remove(int $id)
    {
        $cart = $this->session->get('cart', []);
        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }
        $this->session->set('cart', $cart);
    }

    public function getFullCart(): array
    {
        $cartComplete = [];
        $cart = $this->session->get('cart', []);
        foreach ($cart as $id => $quantity) {
            $product = $this->entityManager->getRepository(Product::class)->findOneById($id);
            if (!$product) {
                $this->remove($id);
                continue;
            }
            $cartComplete[] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }
        return $cartComplete;
    }

    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->getFullCart() as $item) {
            $total += $item['product']->getPriceHt() * $item['quantity'];
        }
        return $total;
    }

    public function delete()
    {
        $this->session->remove('cart');
    }
}