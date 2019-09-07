<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Prestataire;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PrestataireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/api")
 */
class UserController extends FOSRestController
{
    private $passwordEncoder;

public function __construct(UserPasswordEncoderInterface $passwordEncoder)
{
  $this->passwordEncoder = $passwordEncoder;
}

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

//             if($form->isSubmitted() && $form->isValid())
// {
    
            $utilisateur->setRoles(["ROLE_USER"]);
            $utilisateur->setUpdatedAt(new \DateTime());
            $utilisateur->setImageFile($file);
            $utilisateur->setPassword($passwordEncoder->encodePassword($utilisateur,
             $form->get('password')->getData()
            )
            );
             
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            
            return new Response('Le partenaire a été ajouté',Response::HTTP_CREATED);

     

   // }  
    
    }
    // /**
    // * @Route("/login_check", name="login", methods={"POST"})
    // */
    // public function login(Request $request)
    //{
    // $user = $this->getUser();
    //   return $this->json([
    //      'username' => $user->getUsername(),
 //       'roles' => $user->getRoles()
     //  ]);}

    /**
     * @Route("/acces", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {$data=
        [
            'status' => 200,
            'messagess' => 'désolé vous etes bloqué'
        ];
      
        return new JsonResponse($data);
    }

    /**
     * @Route("/bloquer", name="bloquer", methods={"POST"})
     */
    #public function userBloquer(Request $request, UserRepository $userRepo,EntityManagerInterface $entityManager): Response
    #{
      #  $values = json_decode($request->getContent());

        #$bloq=$userRepo->findOneByUsername($values->username);
       #if($bloq->getStatut()=="bloquer" ){

        #$bloq->setStatut("actif");
       # $bloq->setRoles(["ROLE_USER"]);
          
        #  }
       #elseif($bloq->getStatut()=="actif")
       #{
           #$bloq->setStatut("bloquer");
           #$bloq->setRoles(["ROLE_USERLOCK"]);
      # }

        #$entityManager->flush();
        #$data=
        #[
          #  'status' => 200,
           # 'message' => 'message bloqué/débloqué'
        #];
      
        #return new JsonResponse($data);

        
   # }
    /**
     * @Route("/login_check", name="login", methods={"POST"})
     * @param JWTEncoderInterface $JWTEncoder
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException
     */
    public function login(Request $request, JWTEncoderInterface  $JWTEncoder)
    { 
   
       $values = json_decode($request->getContent());
        $username   = $values->username; 
        $password   = $values->password; 
            $repo = $this->getDoctrine()->getRepository(User::class);
            $user = $repo-> findOneBy(['username' => $username]);
            if(!$user){
                return $this->json([
                        'messagee' => 'Username incorrect'
                    ]);
            }

            $isValid = $this->passwordEncoder
            ->isPasswordValid($user, $password);
            if(!$isValid){ 
                return $this->json([
                    'message' => 'Mot de passe incorect'
                ]);
            }
            if($user->getStatut()=="inactif"){
                return $this->json([
                    'message' => 'ACCÈS REFUSÉ vous ne pouvez pas connecter !'
                ]);
            }
            $token = $JWTEncoder->encode([
                'username' => $user->getUsername(),
                'exp' => time() + 86400 // 1 day expiration
            ]);

            return $this->json([
                'token' => $token
            ]);
    }
   

    
     /**
    * @Route("/user/bloquer_user/{id}", name="status",methods={"GET"})
    */
    public function status(User $user)
    {
        if($user->getStatut()=="actif"){
            $user->setStatut("inactif");
           
        }else{
            $user->setStatut("actif");
          
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
       # return $this->handleView($this->view([$this->statut=>'ok'],Response::HTTP_CREATED));
    return new JsonResponse('user bloqué/débloqué');
    }
 
   
    /**
     * @Route("/liste_user", name="list_user", methods={"GET"})
     */
    public function index(UserRepository $user, SerializerInterface $serializer)
    {
        $con=$this->getUser();
        $users = $user->findBy(['partenaire'=>$con->getPartenaire()]);
        $data = $serializer->serialize($users, 'json');
        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }  
}
