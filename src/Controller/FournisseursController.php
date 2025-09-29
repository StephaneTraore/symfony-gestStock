<?php

namespace App\Controller;

use App\Entity\Fournisseurs;
use App\Form\FournisseursType;
use App\Repository\ApprosRepository;
use App\Repository\ClientsRepository;
use App\Repository\CommandesRepository;
use App\Repository\FournisseursRepository;
use App\Repository\ProduitsRepository;
use App\Repository\StocksRepository;
use App\Repository\UserRepository;
use App\Repository\VentesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/fournisseurs')]
class FournisseursController extends AbstractController
{
    #[Route('/', name: 'app_fournisseurs_index', methods: ['GET'])]
    public function index(FournisseursRepository $fournisseursRepository,
    UserRepository $userRepository,
    ProduitsRepository $produitsRepository,
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
        return $this->render('fournisseurs/index.html.twig', [
            'fournisseurs' => $fournisseursRepository->findAll(),
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

    #[Route('/new', name: 'app_fournisseurs_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,
    UserRepository $userRepository,
    ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository): Response
    {
        $fournisseur = new Fournisseurs();
        $form = $this->createForm(FournisseursType::class, $fournisseur);
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
            $entityManager->persist($fournisseur);
            $entityManager->flush();

            return $this->redirectToRoute('app_fournisseurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fournisseurs/new.html.twig', [
            'fournisseur' => $fournisseur,
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

    #[Route('/{id}', name: 'app_fournisseurs_show', methods: ['GET'])]
    public function show(Fournisseurs $fournisseur,
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
        return $this->render('fournisseurs/show.html.twig', [
            'fournisseur' => $fournisseur,
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

    #[Route('/{id}/edit', name: 'app_fournisseurs_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fournisseurs $fournisseur, EntityManagerInterface $entityManager,
    UserRepository $userRepository,
    ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository): Response
    {
        $form = $this->createForm(FournisseursType::class, $fournisseur);
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
            $entityManager->flush();

            return $this->redirectToRoute('app_fournisseurs_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fournisseurs/edit.html.twig', [
            'fournisseur' => $fournisseur,
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

    #[Route('/{id}', name: 'app_fournisseurs_delete', methods: ['POST'])]
    public function delete(Request $request, Fournisseurs $fournisseur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fournisseur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($fournisseur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_fournisseurs_index', [], Response::HTTP_SEE_OTHER);
    }
}
