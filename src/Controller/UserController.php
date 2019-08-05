<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Prestataire;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\PrestataireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/api")
 */
class UserController extends FOSRestController
{

    /**
     * @Route("/register", name="user_register", methods={"GET","POST"})
     */
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, SerializerInterface $serializer, ValidatorInterface $validator,PrestataireRepository $repo)
    {
        
        
            $utilisateur = new User();
            $form=$this->createForm(UserType::class , $utilisateur);
            $form->handleRequest($request);
            $data=$request->request->all();
            $file= $request->files->all()['imageName'];
            $form->submit($data);

            if($form->isSubmitted() && $form->isValid())
{
            $utilisateur->setRoles(["ROLE_CAISSIER"]);
            $utilisateur->setUpdatedAt(new \DateTime());
            $utilisateur->setImageFile($file);
            $utilisateur->setPassword($passwordEncoder->encodePassword($utilisateur,
             $form->get('password')->getData()
            )
            );
            
          
            
            
            
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            

      $dat=[
          "statut"=>201,
          "messages"=>"user crée"
      ];
      return new JsonResponse($dat);

    }  
    $dat=[
        "statut" => 500,
        "messages" => "vous devez renseigner"
    ];
    return new JsonResponse($dat);
    }
     /**
     * @Route("/login_check", name="login", methods={"POST"})
     */
    public function login(Request $request)
    {
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles()
        ]);
    }

    /**
     * @Route("/acces", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {$data=
        [
            'status' => 200,
            'message' => 'désolé vous etes bloqué'
        ];
      
        return new JsonResponse($data);
    }

    /**
     * @Route("/bloquer", name="bloquer", methods={"POST"})
     */
    public function userBloquer(Request $request, UserRepository $userRepo,EntityManagerInterface $entityManager): Response
    {
        $values = json_decode($request->getContent());

        $bloq=$userRepo->findOneByUsername($values->username);
       if($bloq->getStatut()=="bloquer" ){

        $bloq->setStatut("actif");
        $bloq->setRoles(["ROLE_USER"]);
          
          }
       elseif($bloq->getStatut()=="actif")
       {
           $bloq->setStatut("bloquer");
           $bloq->setRoles(["ROLE_USERLOCK"]);
       }

        $entityManager->flush();
        $data=
        [
            'status' => 200,
            'message' => 'message bloqué/débloqué'
        ];
      
        return new JsonResponse($data);

        
    }

   
}
