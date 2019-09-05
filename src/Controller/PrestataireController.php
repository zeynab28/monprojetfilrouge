<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Compte;
use App\Form\UserType;
use App\Form\CompteType;
use App\Entity\Prestataire;
use App\Form\PrestataireType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TarifsRepository;
use App\Repository\PrestataireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/prestataire")
 */
class PrestataireController extends AbstractController
{
    /**
     * @Route("/ajout", name="userataire_index", methods={"POST"})
     */
    public function ajout(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $random=random_int(100000,999999);
        $prest= new Prestataire();
        $form = $this->createForm(PrestataireType::class, $prest);
        $data=$request->request->all();
        $form->submit($data);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($prest);
        $entityManager->flush();

        $compt = new Compte();
        $form = $this->createForm(CompteType::class, $compt);
        $data=$request->request->all();
        $form->submit($data);
        $compt->setNumbcompte($random);
        $compt->setPartenaire($prest);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($compt);
        $entityManager->flush();

        $utilisateur = new User();
        $form=$this->createForm(UserType::class , $utilisateur);
        $form->handleRequest($request);
        $data=$request->request->all();
        $file= $request->files->all()['imageName'];
        $form->submit($data);
        $utilisateur->setRoles(["ROLE_ADMIN"]);
        $utilisateur->setUpdatedAt(new \DateTime());
        $utilisateur->setImageFile($file);
        $utilisateur->setPassword($passwordEncoder->encodePassword($utilisateur,
        $form->get('password')->getData()
            )
            );
        $entityManager = $this->getDoctrine()->getManager();
        $utilisateur->setPartenaire($prest);
        $utilisateur->setCompte($compt);
        $entityManager->persist($utilisateur);
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
