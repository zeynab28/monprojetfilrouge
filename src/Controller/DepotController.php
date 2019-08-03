<?php

namespace App\Controller;

use App\Entity\Depot;
use App\Entity\Compte;
use App\Entity\User;
use App\Form\DepotType;
use App\Repository\CompteRepository;
use App\Repository\DepotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;



/**
 * @Route("/api")
 */
class DepotController extends AbstractController
{
  /**
    * @Route("/depot" , name="depot" , methods={"POST"})
    */
    public function depot(Request $request,EntityManagerInterface $entityManager,CompteRepository $reposi ): Response
    {
       
        $values = json_decode($request->getContent());

        $depot = new Depot();
        $depot->setDate(new \DateTime());
        $depot->setMontant($values->montant);
        
        $data=json_decode($request->getContent(),true);
        $repo=$this->getDoctrine()->getRepository(Compte::class);
        $compt=$repo->find($data["compte"]);
        
        $compt->setSolde($compt->getSolde()+$depot->getMontant());
       
        $depot->setCompte($compt);
        $repo=$this->getDoctrine()->getRepository(User::class);

        $caissier=$repo->find($data['user']);
        $depot->setUser($caissier);
         
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($depot);
            $entityManager->persist($compt);

            $entityManager->flush();
        
        return new Response('Le depot a été effectuer',Response::HTTP_CREATED);
        
      
        
       
    }
}
