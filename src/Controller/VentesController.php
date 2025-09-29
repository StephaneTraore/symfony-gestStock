<?php

namespace App\Controller;

use App\Entity\Ventes;
use App\Form\VentesType;
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

#[Route('/ventes')]
class VentesController extends AbstractController
{
    #[Route('/', name: 'app_ventes_index', methods: ['GET'])]
    public function index(VentesRepository $ventesRepository,
    UserRepository $userRepository,ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,
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
        return $this->render('ventes/index.html.twig', [
            'ventes' => $ventesRepository->findAll(),
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

    #[Route('/new', name: 'app_ventes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,
    UserRepository $userRepository,ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository): Response
    {
        $vente = new Ventes();
        $form = $this->createForm(VentesType::class, $vente);
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

            $stock = $stocksRepository->findOneBy(['nomProduit'=>$vente->getNomProduit()]);
            if ($stock)
            {
                if($stock->getQuantite()> $vente->getQuantite())
                {
                $stock->setQuantite($stock->getQuantite() - $vente->getQuantite());
                $entityManager->persist($vente);
                }
                else
                {  
                return new Response('la quantite demandée n"existe pas dans le stock', Response::HTTP_OK);
                
                }
            }
            else
            {  
                return new Response('le produit n"existe pas', Response::HTTP_OK);
                
            }
            $entityManager->persist($vente);
            $entityManager->flush();

            return $this->redirectToRoute('app_ventes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ventes/new.html.twig', [
            'vente' => $vente,
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

    #[Route('/{id}', name: 'app_ventes_show', methods: ['GET'])]
    public function show(Ventes $vente,UserRepository $userRepository,
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
        return $this->render('ventes/show.html.twig', [
            'vente' => $vente,
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

    #[Route('/{id}/edit', name: 'app_ventes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ventes $vente, EntityManagerInterface $entityManager,
    UserRepository $userRepository,ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository): Response
    {
        $form = $this->createForm(VentesType::class, $vente);
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

            return $this->redirectToRoute('app_ventes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ventes/edit.html.twig', [
            'vente' => $vente,
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

    #[Route('/{id}', name: 'app_ventes_delete', methods: ['POST'])]
    public function delete(Request $request, Ventes $vente, EntityManagerInterface $entityManager,): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vente->getId(), $request->request->get('_token'))) {
            $entityManager->remove($vente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ventes_index', [], Response::HTTP_SEE_OTHER);
    }
}
