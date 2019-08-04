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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/api")
 */
class UserController extends AbstractController
{

    /**
     * @Route("/register", name="user_register", methods={"GET","POST"})
     */
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, SerializerInterface $serializer, ValidatorInterface $validator,PrestataireRepository $repo)
    {
        $values = json_decode($request->getContent());
       
        if(isset($values->username,$values->password)) {
            $utilisateur = new User();
            $utilisateur->setUsername($values->username);
            $utilisateur->setPassword($passwordEncoder->encodePassword($utilisateur, $values->password));
            $utilisateur->setRoles($values->roles);
            $utilisateur->setPrenom($values->prenom);
            $utilisateur->setNom($values->nom);
            $utilisateur->setTel($values->tel);
            $utilisateur->setCni($values->cni);
            $utilisateur->setAdresse($values->adresse);
            $utilisateur->setEmail($values->email);
            $utilisateur->setStatut($values->statut);
            $repo=$this->getDoctrine()->getRepository(Prestataire::class);
            $partenaires=$repo->find($values->partenaire);
            $utilisateur->setPartenaire($partenaires);
            
            $errors = $validator->validate($utilisateur);

            if(count($errors)) {
                $errors = $serializer->serialize($errors, 'json');
                return new Response($errors, 500, [
                    'Content-Type' => 'application/json'
                ]);
            }
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            $data = [
                'statu' => 201,
                'messag' => 'L\'utilisateur a été créé'
            ];

            return new JsonResponse($data, 201);
        }
        $data = [
            'statu' => 500,
            'messag' => 'Vous devez renseigner les clés username et password'
        ];
        return new JsonResponse($data, 500);

        
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
