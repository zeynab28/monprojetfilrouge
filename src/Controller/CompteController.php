<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Form\CompteType;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PrestataireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 */
class CompteController extends AbstractController
{
   
    /**
     * @Route("/liste_compte", name="list_compte", methods={"GET"})
     */
    public function listecompte(CompteRepository $compte, SerializerInterface $serializer)
    {
        $listr = $compte->findAll();
        $data = $serializer->serialize($listr, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @Route("/compte", name="compte_new", methods={"POST"})
     */
     
        public function compte(Request $request, EntityManagerInterface $entityManager,PrestataireRepository $repo): Response
        {
            $jour = date('d');
            $mois = date('m');
            $annee = date('Y');
            $heure = date('H');
            $minute = date('i');
            $seconde= date('s');
            //$tata= date('ma');
            $random=$jour.$mois.$annee.$heure.$minute.$seconde;
    
            $dept = new Compte();
            $form = $this->createForm(CompteType::class, $dept);
            $data=json_decode($request->getContent(),true);
            $form->submit($data);
            $dept->setNumbcompte($random);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($dept);
                $entityManager->flush();
        
        return new Response('Le compte a été créer',Response::HTTP_CREATED);
}

}


   

