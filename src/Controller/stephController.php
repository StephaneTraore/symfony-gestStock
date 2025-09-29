<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\ApprosRepository;
use App\Repository\StocksRepository;
use App\Repository\VentesRepository;
use App\Repository\ClientsRepository;
use App\Repository\ProduitsRepository;
use App\Repository\CommandesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FournisseursRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\DependencyInjection\Loader\Configurator\request;


class stephController extends AbstractController
{
 #[Route('/profil', name: 'profil')]

public function profil(UserRepository $userRepository,
ProduitsRepository $produitsRepository,
FournisseursRepository $fournisseursRepository,
ClientsRepository $clientsRepository,
VentesRepository $ventesRepository,
ApprosRepository $approsRepository,
CommandesRepository $commandesRepository,
StocksRepository $stocksRepository,Request $request
,EntityManagerInterface $entityManager,

) {
    $user = $this->getUser();
    $connected = $userRepository->find($user);

    $produits = $produitsRepository ->findAll();
    $users = $userRepository ->findAll();
    $fournisseurss = $fournisseursRepository ->findAll();
    $clientss = $clientsRepository ->findAll();
    $ventess = $ventesRepository ->findAll();
    $appross = $approsRepository ->findAll();
    $commandess = $commandesRepository ->findAll();
    $stockss = $stocksRepository ->findAll();

   if($request->getMethod()=="POST")
   {
    $connected->setNom($request->request->get('nom'));
    $connected->setPrenom($request->request->get('prenom'));
    
    
    $entityManager->persist($connected);
    $entityManager->flush();

    return $this -> redirectToRoute('profil');

   }
    
    return $this -> render('profil.html.twig',[
        'users'=>$users,
        'produits'=>$produits,
        'fournisseurss'=>$fournisseurss,
        'clientss'=>$clientss,
        'ventess'=>$ventess,
        'appross'=>$appross,
        'commandess'=>$commandess,
        'stockss'=>$stockss,
    ]);
}

}