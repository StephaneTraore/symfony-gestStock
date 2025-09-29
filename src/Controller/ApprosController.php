<?php

namespace App\Controller;

use App\Entity\Appros;
use App\Entity\Stocks;
use App\Form\ApprosType;
use App\Repository\ApprosRepository;
use App\Repository\ClientsRepository;
use App\Repository\CommandesRepository;
use App\Repository\FournisseursRepository;
use App\Repository\ProduitsRepository;
use App\Repository\StocksRepository;
use App\Repository\UserRepository;
use App\Repository\VentesRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/appros')]
class ApprosController extends AbstractController
{
    #[Route('/', name: 'app_appros_index', methods: ['GET'])]
    public function index(ApprosRepository $approsRepository,
    ClientsRepository $clientsRepository, 
    UserRepository $userRepository,
    ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    VentesRepository $ventesRepository,
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
        return $this->render('appros/index.html.twig', [
            'appros' => $approsRepository->findAll(),
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

    #[Route('/new', name: 'app_appros_new', methods: ['GET', 'POST'])]
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
        $appro = new Appros();
        $form = $this->createForm(ApprosType::class, $appro);
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
            $stock = $stocksRepository->findOneBy(['nomProduit'=>$appro->getNomProduit()]);
            if ($stock)
            {
                $stock->setQuantite($stock->getQuantite()+ $appro->getQuantite());
                
                $entityManager->persist($appro);
            }
            else 
            {
                $stock=new Stocks();
                $stock->setNomProduit($appro->getNomProduit());
                $stock->setNomFournisseur($appro->getNomFornisseur());
                $stock->setQuantite($appro->getQuantite());
                $stock->setPrixUnitaire($appro->getPrix());
                $stock->setDateReception(new DateTime());
                $entityManager -> persist($stock);
            }
            $entityManager->persist($appro);
            $entityManager->flush();

            return $this->redirectToRoute('app_appros_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('appros/new.html.twig', [
            'appro' => $appro,
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

    #[Route('/{id}', name: 'app_appros_show', methods: ['GET'])]
    public function show(Appros $appro,
    ClientsRepository $clientsRepository, 
    UserRepository $userRepository,
    ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository
    ): Response
    {
        $users = $userRepository ->findAll();
        $fournisseurss = $fournisseursRepository ->findAll();
        $produits = $produitsRepository ->findAll();
        $clientss = $clientsRepository ->findAll();
        $ventess = $ventesRepository ->findAll();
        $appross = $approsRepository ->findAll();
        $commandess = $commandesRepository ->findAll();
        $stockss = $stocksRepository ->findAll();
        return $this->render('appros/show.html.twig', [
            'appro' => $appro,
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

    #[Route('/{id}/edit', name: 'app_appros_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Appros $appro, EntityManagerInterface $entityManager,
    ClientsRepository $clientsRepository, 
    UserRepository $userRepository,
    ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository): Response
    {
        $form = $this->createForm(ApprosType::class, $appro);
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
            $entityManager->flush();

            return $this->redirectToRoute('app_appros_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('appros/edit.html.twig', [
            'appro' => $appro,
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

    #[Route('/{id}', name: 'app_appros_delete', methods: ['POST'])]
    public function delete(Request $request, Appros $appro, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appro->getId(), $request->request->get('_token'))) {
            $entityManager->remove($appro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_appros_index', [], Response::HTTP_SEE_OTHER);
    }
}
