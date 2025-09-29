<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Form\CommandesType;
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
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/commandes')]
class CommandesController extends AbstractController
{
    #[Route('/', name: 'app_commandes_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(CommandesRepository $commandesRepository,
    ClientsRepository $clientsRepository, 
    UserRepository $userRepository,
    ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
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
        return $this->render('commandes/index.html.twig', [
            'commandes' => $commandesRepository->findAll(),
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

    #[Route('/new', name: 'app_commandes_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager,
    ClientsRepository $clientsRepository, 
    UserRepository $userRepository,
    ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository): Response
    {
        $commande = new Commandes();
        $form = $this->createForm(CommandesType::class, $commande);
        $form->handleRequest($request);

        $users = $userRepository ->findAll();
        $fournisseurss = $fournisseursRepository ->findAll();
        $produits = $produitsRepository ->findAll();
        $clientss = $clientsRepository ->findAll();
        $ventess = $ventesRepository ->findAll();
        $appross = $approsRepository ->findAll();
        $commandess = $commandesRepository ->findAll();
        $stockss = $stocksRepository ->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('app_commandes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commandes/new.html.twig', [
            'commande' => $commande,
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

    #[Route('/{id}', name: 'app_commandes_show', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function show(Commandes $commande,
    ClientsRepository $clientsRepository, 
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
        return $this->render('commandes/show.html.twig', [
            'commande' => $commande,
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

    #[Route('/{id}/edit', name: 'app_commandes_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Commandes $commande, EntityManagerInterface $entityManager,
    ClientsRepository $clientsRepository, 
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
        $form = $this->createForm(CommandesType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commandes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commandes/edit.html.twig', [
            'commande' => $commande,
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

    #[Route('/{id}', name: 'app_commandes_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Commandes $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commandes_index', [], Response::HTTP_SEE_OTHER);
    }
}
