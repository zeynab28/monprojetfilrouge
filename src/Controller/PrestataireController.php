<?php

namespace App\Controller;

use App\Entity\Prestataire;
use App\Entity\User;
use App\Entity\Compte;
use App\Form\PrestataireType;
use App\Repository\PrestataireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api")
 */
class PrestataireController extends AbstractController
{
    /**
     * @Route("/ajout", name="userataire_index", methods={"POST"})
     */
    public function ajout(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $random=random_int(100000,999999);
        $values = json_decode($request->getContent());

        $user= new User();
        $user->setUsername($values->username);
        $user->setPassword($passwordEncoder->encodePassword($user, $values->password));
        $user->setRoles(array('ROLE_ADMIN'));
        $user->setPrenom($values->prenom);
        $user->setNom($values->nom);
        $user->setTel($values->tel);
        $user->setCni($values->cni);
        $user->setAdresse($values->adresse);
        $user->setEmail($values->email);
        $user->setStatut($values->statut);
      

        $prest= new Prestataire();
        $prest->setNinea($values->ninea);
        $prest->setRs($values->rs);
        $prest->setNom($values->nom);
        $prest->setAdresse($values->adresse);
        $prest->setStatut($values->statut);

        $user->setPartenaire($prest);


        $comp= new Compte();
        $comp->setNumbcompte($random);
        $comp->setSolde($values->solde);
        $comp->setPartenaire($prest);

        $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($user);
        $entityManager->persist($prest);
        $entityManager->persist($comp);
        $entityManager->flush();

        
          
        return new Response('Le partenaire a été ajouté',Response::HTTP_CREATED); 
    }


    /**
     * @Route("/liste", name="list_prestataire", methods={"GET"})
     */
    public function index(PrestataireRepository $partenaire, SerializerInterface $serializer)
    {
        $partenariat = $partenaire->findAll();
        $data = $serializer->serialize($partenariat, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
