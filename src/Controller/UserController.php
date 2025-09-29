<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Form\UserType;
use App\Service\MailerService;
use Doctrine\DBAL\Types\DateType;
use App\Repository\UserRepository;
use App\Repository\ApprosRepository;
use App\Repository\StocksRepository;
use App\Repository\VentesRepository;
use App\Repository\ClientsRepository;
use PhpParser\Node\Expr\AssignOp\Div;
use App\Repository\ProduitsRepository;
use App\Repository\CommandesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FournisseursRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(UserRepository $userRepository,ProduitsRepository $produitsRepository,
    FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository ): Response
    {
        $users = $userRepository ->findAll();
        $produits = $produitsRepository ->findAll();
        $fournisseurss = $fournisseursRepository ->findAll();
        $clientss = $clientsRepository ->findAll();
        $ventess = $ventesRepository ->findAll();
        $appross = $approsRepository ->findAll();
        $commandess = $commandesRepository ->findAll();
        $stockss = $stocksRepository ->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
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


    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager, 
    UserPasswordHasherInterface $encoder,
    ProduitsRepository $produitsRepository,UserRepository $userRepository,
    FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository,
    MailerService $mailerService,
     TokenGeneratorInterface $tokenGeneratorInterface, ): Response

    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $produits = $produitsRepository ->findAll();
        $users = $userRepository ->findAll();
        $fournisseurss = $fournisseursRepository ->findAll();
        $clientss = $clientsRepository ->findAll();
        $ventess = $ventesRepository ->findAll();
        $appross = $approsRepository ->findAll();
        $commandess = $commandesRepository ->findAll();
        $stockss = $stocksRepository ->findAll();
        

        if ($form->isSubmitted() && $form->isValid()) {
            $tokenRegistration = $tokenGeneratorInterface->generateToken();
           $password=$user->getPassword();
           $user->setRoles([$request->request->get("role")]);
           $encoder->hashPassword($user,$password);
           $user->setPassword($encoder->hashPassword($user,$password));
           $user ->setTokenRegistration($tokenRegistration);
            $entityManager->persist($user);
            $entityManager->flush();

            $mailerService->send(
                $user->getEmail(),
                'confirmation du compte utilisateur',
                'registration_confirmation.html.twig',
                [
                    'user'=>$user,
                    'token'=>$tokenRegistration,
                    'lifeTimeToken'=>$user->getTokenRegistrationLifeTime()->format('d-m-Y-H-i-s')
                ]
            );
           
            $this->addFlash('success','Votre compte à bien été crée, veuillez verifier votre e-mail pour l\'activer ');
          
            return $this->redirectToRoute('app_user_new', [], Response::HTTP_SEE_OTHER);
        }
        
        

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
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

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function show(User $user, ProduitsRepository $produitsRepository,UserRepository $userRepository,
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
        
        return $this->render('user/show.html.twig', [
            'user' => $user,
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

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager, 
    ProduitsRepository $produitsRepository,
    UserRepository $userRepository,FournisseursRepository $fournisseursRepository,
    ClientsRepository $clientsRepository,
    VentesRepository $ventesRepository,
    ApprosRepository $approsRepository,
    CommandesRepository $commandesRepository,
    StocksRepository $stocksRepository,UserPasswordHasherInterface $encoder,
    ): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $produits = $produitsRepository ->findAll();
        $users = $userRepository->findAll();
        $fournisseurss = $fournisseursRepository ->findAll();
        $clientss = $clientsRepository ->findAll();
        $ventess = $ventesRepository ->findAll();
        $appross = $approsRepository ->findAll();
        $commandess = $commandesRepository ->findAll();
        $stockss = $stocksRepository ->findAll();

        if ($form->isSubmitted() && $form->isValid()) {

            $password=$user->getPassword();
            $encoder->hashPassword($user,$password);
            $user->setPassword($encoder->hashPassword($user,$password));
           
            $user->setRoles([$request->request->get("role")]);
            $entityManager->flush();

          

                $this->addFlash('success','Votre compte à été bien modifier, veuillez verifier votre e-mail pour l\'activer ');
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
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

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
   
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
