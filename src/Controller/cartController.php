<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Repository\ProduitsRepository;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mime\Message;
use Symfony\Component\Routing\Annotation\Route;

use function PHPUnit\Framework\throwException;

#[Route('/cart',name: 'cart_')]
class cartController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(SessionInterface $session, ProduitsRepository $produitsRepository)
    {
        $panier = $session ->get('panier', []);
        // dd($panier);
        //  initialiser des variables
        $data = []; 
        $total = 0;
       

        foreach($panier as $id => $quantity)
        {
            $produits = $produitsRepository ->find($id);

            $data[] = [
                'Produits'=>$produits,
                'quantity'=>$quantity
            ];
            $total +=$produits->getPrixProduit() * $quantity;
        }
        return $this->render('cart/index.html.twig',[
            'data'=>$data,
            'total'=>$total,
        ]);
    }

    #[Route('/add/{id}', name: 'add')]
    public function add(Produits $produits, SessionInterface $session)
    {

        // recupere l'id du panier
        $id = $produits->getId();

        //on recupere le panier existant
        $panier = $session->get('panier',[]);

        // on ajoute le produit dans la session du panier s'il nexiste pas encore sinon on l'increment 

        if(empty($panier[$id]))
        {
            $panier[$id] = 1;
        }else{
            $panier[$id]++;
        }
        $session ->set('panier', $panier);
        // dd($session);

        // on redirige vers la page panier

        return $this ->redirectToRoute('cart_index');

    }

    #[Route('/remove/{id}', name: 'remove')]
    public function remove(Produits $produits, SessionInterface $session)
    {

        // recupere l'id du panier
        $id = $produits->getId();

        //on recupere le panier existant
        $panier = $session->get('panier',[]);

        // on ajoute le produit dans la session du panier s'il nexiste pas encore sinon on l'increment 

        if(!empty($panier[$id]))
        {
            if($panier[$id] >=0)
            {
                $panier[$id]--;
            }else{
                unset($panier);
            }
            
        
        }
    
        $session ->set('panier', $panier);
       
        // dd($session);

        // on redirige vers la page panier

        return $this ->redirectToRoute('cart_index');

    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Produits $produits, SessionInterface $session)
    {

        // recupere l'id du panier
        $id = $produits->getId();

        //on recupere le panier existant
        $panier = $session->get('panier',[]);

        // on ajoute le produit dans la session du panier s'il nexiste pas encore sinon on l'increment 

        if(!empty($panier[$id]))
        {
           unset($panier[$id]);
            
        
        }
        $session ->set('panier', $panier);
        // dd($session);

        // on redirige vers la page panier

        return $this ->redirectToRoute('cart_index');

    }

    #[Route('/empty', name: 'empty')]
    public function empty( SessionInterface $session)
    {

       

     
        $session ->remove('panier');
      

        // on redirige vers la page panier

        return $this ->redirectToRoute('cart_index');

    }
}