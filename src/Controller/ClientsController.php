<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Form\ClientsType;
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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/clients')]

class ClientsController extends AbstractController
{
    #[Route('/', name: 'app_clients_index', methods: ['GET'])]
    public function index(ClientsRepository $clientsRepository, 
    UserRepository $userRepository,
    ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository): Response
    {
        $users = $userRepository ->findAll();
        $fournisseurss = $fournisseursRepository ->findAll();
        $produits = $produitsRepository ->findAll();
        $clientss = $clientsRepository ->findAll();
        $ventess = $ventesRepository ->findAll();
        $appross = $approsRepository ->findAll();
        $commandess = $commandesRepository ->findAll();
        $stockss = $stocksRepository ->findAll();
        return $this->render('clients/index.html.twig', [
            'clients' => $clientsRepository->findAll(),
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

    #[Route('/new', name: 'app_clients_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,
    UserRepository $userRepository,ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository): Response
    {
        $client = new Clients();
        $form = $this->createForm(ClientsType::class, $client);
        $form->handleRequest($request);
        $users = $userRepository ->findAll();
        $produits = $produitsRepository ->findAll();
        $fournisseurss = $fournisseursRepository ->findAll();
        $clientss = $clientsRepository ->findAll();
        $ventess = $ventesRepository ->findAll();
        $appross = $approsRepository ->findAll();
        $commandess = $commandesRepository ->findAll();
        $stockss = $stocksRepository ->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_clients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('clients/new.html.twig', [
            'client' => $client,
            'form' => $form,
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

    #[Route('/{id}', name: 'app_clients_show', methods: ['GET'])]
    public function show(Clients $client,  UserRepository $userRepository,
    ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository): Response
    {
        $users = $userRepository ->findAll();
        $produits = $produitsRepository ->findAll();
        $fournisseurss = $fournisseursRepository ->findAll();
        $clientss = $clientsRepository ->findAll();
        $ventess = $ventesRepository ->findAll();
        $appross = $approsRepository ->findAll(); 
        $commandess = $commandesRepository ->findAll();
        $stockss = $stocksRepository ->findAll();
        return $this->render('clients/show.html.twig', [
            'client' => $client,
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

    #[Route('/{id}/edit', name: 'app_clients_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Clients $client, EntityManagerInterface $entityManager,
    UserRepository $userRepository,
    ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository): Response
    {
        $users = $userRepository ->findAll();
        $produits = $produitsRepository ->findAll();
        $fournisseurss = $fournisseursRepository ->findAll();
        $clientss = $clientsRepository ->findAll();
        $ventess = $ventesRepository ->findAll();
        $appross = $approsRepository ->findAll();
        $commandess = $commandesRepository ->findAll();
        $stockss = $stocksRepository ->findAll();
        
        $form = $this->createForm(ClientsType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_clients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('clients/edit.html.twig', [
            'client' => $client,
            'form' => $form,
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

    #[Route('/{id}', name: 'app_clients_delete', methods: ['POST'])]
    public function delete(Request $request, Clients $client, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_clients_index', [], Response::HTTP_SEE_OTHER);
    }
}
