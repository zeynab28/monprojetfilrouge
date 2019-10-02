<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Depot;
use App\Entity\Compte;
use App\Form\DepotType;
use App\Repository\DepotRepository;
use App\Repository\CompteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        
        $depot = new Depot();
        $form = $this->createForm(DepotType::class, $depot);
        $data=$request->request->all();
        $form->submit($data);
        $depot->setDate(new \DateTime());
        $repo=$this->getDoctrine()->getRepository(Compte::class);
        $compt=$repo->find($data["compte"]);
        var_dump($data["compte"]);
        //die();
        $compt->setSolde($compt->getSolde()+$depot->getMontant());
       
        $depot->setCompte($compt);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($depot); 
        $entityManager->persist($compt);

        $entityManager->flush();  
        
        return new Response('Le depot a été effectuer',Response::HTTP_CREATED);
        
      
        
       
    }

    /**
     * @Route("/liste_depot", name="list_depot", methods={"GET"})
     */
    public function index(DepotRepository $dep, SerializerInterface $serializer)
    {
        $depots = $dep->findAll();
        $data = $serializer->serialize($depots, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    }
}
