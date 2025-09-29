<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Repository\ApprosRepository;
use App\Repository\CategoriesRepository;
use App\Repository\ClientsRepository;
use App\Repository\CommandesRepository;
use App\Repository\FournisseursRepository;
use App\Repository\ProduitsRepository;
use App\Repository\StocksRepository;
use App\Repository\UserRepository;
use App\Repository\VentesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\InputBag;


class AdminController extends AbstractController
{
#[Route('/admin', name: 'app_admin')]
    
    public function index(UserRepository $userRepository,
    ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository,
    ): Response
    {
       

        $produits = $produitsRepository ->findAll();
        $users = $userRepository ->findAll();
        $fournisseurss = $fournisseursRepository ->findAll();
        $clientss = $clientsRepository ->findAll();
        $ventess = $ventesRepository ->findAll();
        $appross = $approsRepository ->findAll();
        $commandess = $commandesRepository ->findAll();
        $stockss = $stocksRepository ->findAll();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
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


    #[Route('/condition', name: 'vers_condition')]
    #[isGranted('ROLE_USER')]
    public function condition(UserRepository $userRepository,
    ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository,
    
    ) {
        
        
        $produits = $produitsRepository ->findAll();
        $users = $userRepository ->findAll();
       
        $fournisseurss = $fournisseursRepository ->findAll();
        $clientss = $clientsRepository ->findAll();
        $ventess = $ventesRepository ->findAll();
        $appross = $approsRepository ->findAll();
        $commandess = $commandesRepository ->findAll();
        $stockss = $stocksRepository ->findAll();
       
       
        return $this -> render('admin/condition.html.twig',[
            'users'=>$users,
            'produits'=>$produits,
            'fournisseurss'=>$fournisseurss,
            'clientss'=>$clientss,
            'ventess'=>$ventess,
            'appross'=>$appross,
            'commandess'=>$commandess,
            'stockss'=>$stockss,
            
           
        ]
        );
    
    }

    #[Route('/', name: 'vers_accueil')]
    public function accueil() {
        
        return $this -> render('accueil.html.twig');
    }

    #[Route('/administrateur', name: 'administrateur')]
    public function administrateur() {
        
        return $this -> render('administrateur.html.twig');
    }
    
    // #[Route('/profil', name: 'profil')]
    // public function profil(UserRepository $userRepository,
    // ProduitsRepository $produitsRepository,
    // FournisseursRepository $fournisseursRepository,
    // ClientsRepository $clientsRepository,
    // VentesRepository $ventesRepository,
    // ApprosRepository $approsRepository,
    // CommandesRepository $commandesRepository,
    // StocksRepository $stocksRepository,
    // ) {

    //     $produits = $produitsRepository ->findAll();
    //     $users = $userRepository ->findAll();
    //     $fournisseurss = $fournisseursRepository ->findAll();
    //     $clientss = $clientsRepository ->findAll();
    //     $ventess = $ventesRepository ->findAll();
    //     $appross = $approsRepository ->findAll();
    //     $commandess = $commandesRepository ->findAll();
    //     $stockss = $stocksRepository ->findAll();
        
    //     return $this -> render('profil.html.twig',[
    //         'users'=>$users,
    //         'produits'=>$produits,
    //         'fournisseurss'=>$fournisseurss,
    //         'clientss'=>$clientss,
    //         'ventess'=>$ventess,
    //         'appross'=>$appross,
    //         'commandess'=>$commandess,
    //         'stockss'=>$stockss,
    //     ]);
    // }

    #[Route('/e_commerce', name: 'vers_e_commerce')]
    public function e_commerce(UserRepository $userRepository,
    ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository,
    CategoriesRepository $categoriesRepository,
    ) {
        
        
        $produits = $produitsRepository ->findAll();
        $categories=$categoriesRepository->findAll();
        $users = $userRepository ->findAll();
        $fournisseurss = $fournisseursRepository ->findAll();
        $clientss = $clientsRepository ->findAll();
        $ventess = $ventesRepository ->findAll();
        $appross = $approsRepository ->findAll();
        $commandess = $commandesRepository ->findAll();
        $stockss = $stocksRepository ->findAll();
       
        return $this -> render('e_commerce.html.twig',[
            'users'=>$users,
            'produits'=>$produits,
            'fournisseurss'=>$fournisseurss,
            'clientss'=>$clientss,
            'ventess'=>$ventess,
            'appross'=>$appross,
            'commandess'=>$commandess,
            'stockss'=>$stockss,
            'categories'=> $categories,
        ]);
    }

    #[Route('/macategorie/{categorie}', name: 'cate')]
    public function categorie(
        $categorie,
        CategoriesRepository $categoriesRepository,
        ProduitsRepository $produitsRepository,
        UserRepository $userRepository,
        FournisseursRepository $fournisseursRepository,
        ClientsRepository $clientsRepository,
        VentesRepository $ventesRepository,
        ApprosRepository $approsRepository,
        CommandesRepository $commandesRepository,
        StocksRepository $stocksRepository,    
    ) {

       
        
        $produits = $produitsRepository->findBy(['categories'=>$categorie]);
        $produit= $produitsRepository->findAll();
       

    
        $categories=$categoriesRepository->findAll();
        $users = $userRepository ->findAll();
        $fournisseurss = $fournisseursRepository ->findAll();
        $clientss = $clientsRepository ->findAll();
        $ventess = $ventesRepository ->findAll();
        $appross = $approsRepository ->findAll();
        $commandess = $commandesRepository ->findAll();
        $stockss = $stocksRepository ->findAll();
        

        if(array_key_exists($categorie,$produit)) 
        {

            return $this -> render('ordinateur.html.twig',[ 
                'produits'=>$produits,
                'produit'=>$produit[$categorie],
               
                'users'=>$users,
                'fournisseurss'=>$fournisseurss,
                'clientss'=>$clientss,
                'ventess'=>$ventess,
                'appross'=>$appross,
                'commandess'=>$commandess,
                'stockss'=>$stockss,
                'categories'=> $categories,
            ]);
        }
        
        
        // return $this -> render('ordinateur.html.twig',[
        //     'produits'=>$produits,
        //     'produit'=>$produit
            
        // ]);
    }
    #[Route('/redirege', name: 'redirige')]
    public function redirige(UserRepository $userRepository)
    {
        $user= $this->getUser();
        $connected = $userRepository->find($user);
        

        if($connected->getRoles()[0]=='ROLE_ADMIN')
        {
            return $this->redirectToRoute('vers_condition');
        }
        else
        {
            return $this->redirectToRoute('vers_e_commerce');
        }
    }


    // #[Route('/profil/edit', name: 'profil')]
    // public function editProfil(Request $request,
    //  EntityManagerInterface $entityManagerInterface,
    //  UserRepository $userRepository)
    // {

    //     if($this->getUser()->getRoles()==['ROLE_ADMIN,ROLE_USER'])
    //     {
    //         return $this->redirectToRoute('vers_condition');
    //     }
    //     else
    //     {
    //         return $this->redirectToRoute('vers_e_commerce');
    //     }
    // }




   

    
}
