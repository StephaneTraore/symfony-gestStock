<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Entity\Orders;
use App\Entity\OrdersDetails;
use App\Repository\ProductsRepository;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/com', name: 'app_orders_')]
class OrdersController extends AbstractController
{
    #[Route('/ajout', name: 'add')]
    public function add(SessionInterface $session, ProduitsRepository $produitsRepository, EntityManagerInterface $em): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_USER');

        $panier = $session->get('panier', []);

        if($panier === []){
            $this->addFlash('success', 'Votre panier est vide');
            return $this->redirectToRoute('app_orders');
        }
        return $this->redirectToRoute('app_admin');
        

        //Le panier n'est pas vide, on crée la commande
        // $order = new Commandes();

        // On remplit la commande
        // $order->setNonClient($this->getUser());
        // $order->setReference(uniqid());

        // On parcourt le panier pour créer les détails de commande
        // foreach($panier as $item => $quantity){
        //     $orderDetails = new OrdersDetails();

        //     // On va chercher le produit
        //     $product = $produitsRepository->find($item);
            
        //     $price = $product->getPrixProduit();

        //     // On crée le détail de commande
        //     $orderDetails->setProducts($product);
        //     $orderDetails->setPrice($price);
        //     $orderDetails->setQuantity($quantity);

        //     $order->addOrdersDetail($orderDetails);
        // }

        // On persiste et on flush
        // $em->persist($order);
        // $em->flush();

        // $session->remove('panier');

        // $this->addFlash('message', 'Commande créée avec succès');
        // return $this->redirectToRoute('main');
    }
}
