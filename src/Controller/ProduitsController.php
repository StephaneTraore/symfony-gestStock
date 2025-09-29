<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\ProduitsType;
use App\Repository\UserRepository;
use App\Repository\ApprosRepository;
use App\Repository\StocksRepository;
use App\Repository\VentesRepository;
use App\Repository\ClientsRepository;
use App\Repository\ProduitsRepository;
use App\Repository\CommandesRepository;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FournisseursRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/produits')]
class ProduitsController extends AbstractController
{
    #[Route('/', name: 'app_produits_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(ProduitsRepository $produitsRepository, 
    UserRepository $userRepository,
    FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository,
    Request $request, 
    PaginatorInterface $paginator,): Response
    {

         // pour la pagination
         $pagination = $paginator ->paginate(

            $produitsRepository->paginationQuery(),
            $request->query->get('page', 1),
            3   
        );

        $users = $userRepository ->findAll();
        $produits = $produitsRepository->findAll();
        $fournisseurss = $fournisseursRepository ->findAll();
        $clientss = $clientsRepository ->findAll();
        $ventess = $ventesRepository ->findAll();
        $appross = $approsRepository ->findAll();
        $commandess = $commandesRepository ->findAll();
        $stockss = $stocksRepository ->findAll();
        return $this->render('produits/index.html.twig', [
            // 'produits' => $produitsRepository->findAll(),
            'pagination'=>$pagination,
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

    #[Route('/new', name: 'app_produits_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager, 
    UserRepository $userRepository,ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository, 
    StocksRepository $stocksRepository,
    ): Response
    {
        
        $users = $userRepository ->findAll();
        $produits = $produitsRepository->findAll();
        $fournisseurss = $fournisseursRepository ->findAll();
        $clientss = $clientsRepository ->findAll();
        $ventess = $ventesRepository ->findAll();
        $appross = $approsRepository ->findAll();
        $commandess = $commandesRepository ->findAll();
        $stockss = $stocksRepository ->findAll();
        $produit = new Produits();
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produits/new.html.twig', [
            'produit' => $produit,
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

    #[Route('/{id}', name: 'app_produits_show', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function show(Produits $produit, ProduitsRepository $produitsRepository,
    UserRepository $userRepository,FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository ): Response
    {
        $users = $userRepository ->findAll();
        $produits = $produitsRepository->findAll();
        $fournisseurss = $fournisseursRepository ->findAll();
        $clientss = $clientsRepository ->findAll();
        $ventess = $ventesRepository ->findAll();
        $appross = $approsRepository ->findAll();
        $commandess = $commandesRepository ->findAll();
        $stockss = $stocksRepository ->findAll();
        return $this->render('produits/show.html.twig', [
            'produit' => $produit,
            'produits'=>$produits,
            'users'=>$users,
            'fournisseurss'=>$fournisseurss,
            'clientss'=>$clientss,
            'ventess'=>$ventess,
            'appross'=>$appross,
            'commandess'=>$commandess,
            'stockss'=>$stockss,
            
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produits_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Produits $produit, EntityManagerInterface $entityManager,
    UserRepository $userRepository, ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository
    ): Response
    {
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);
        $users = $userRepository ->findAll();
        $produits = $produitsRepository->findAll();
        $fournisseurss = $fournisseursRepository ->findAll();
        $clientss = $clientsRepository ->findAll();
        $ventess = $ventesRepository ->findAll();
        $appross = $approsRepository ->findAll();
        $commandess = $commandesRepository ->findAll();
        $stockss = $stocksRepository ->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produits/edit.html.twig', [
            'produit' => $produit,
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

    #[Route('/{id}', name: 'app_produits_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
    }
}
