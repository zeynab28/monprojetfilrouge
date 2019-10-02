<?php

namespace App\Controller;

use App\Entity\Beneficiaire;
use App\Entity\Transactions;
use App\Form\BeneficiaireType;
use App\Form\TransactionsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BeneficiaireRepository;
use App\Repository\TransactionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 */
class BeneficiaireController extends AbstractController
{
     /**
     * @Route("/retrait", name="tranfertok" ,methods={"POST"})
     */
    public function retrait(Request $request, EntityManagerInterface $entityManager )
    {
      
 $values = json_decode($request->getContent()); 
 $user = $this->getUser();
 $retrait= $this->getDoctrine()->getRepository(Transactions::class)->findOneBy(['code' => $values->code]);
 
          if(!$retrait ){
             return new Response('Le code saisi est incorecte .Veuillez ressayer un autre  '); 
           }else{
              $retrait->setDateretrait(new \DateTime());
              $retrait->setType("retrait");
              $retrait->setcni();
              
             // $compte=$user->getCompte();
              $retrait->setUser($user);
          //  var_dump($retrait->getComenvoi());
          //     die();
  //  $mo= $compte->getSolde()+$retrait->getMontant()+$retrait->getComenvoi();
  //  $retrait->setMontant($mo);
          $entityManager->persist($retrait);
          $entityManager->flush(); 
          if (!$retrait)
   {
   return new Response('erreur  '); 
   }
   return new Response('retrait fait  '. $retrait->getMontant()); 
   }
      
  
  }
  
         /** 
          *  @Route("/retrait_test", name="tranfert" ,methods={"POST"})
          */
          public function test (Request $request,TransactionsRepository $transRepo, EntityManagerInterface $entityManager,SerializerInterface $serializer )
          {
              $trans = new Transactions();
              $form = $this->createForm(TransactionsType::class, $trans);
              $form->handleRequest($request);
              $data = $request->request->all();
              $form->submit($data);
              if ($form->isSubmitted()) {
                  $transRepo = $this->getDoctrine()->getRepository(Transactions::class)->findOneBy(['code' => $data]);
                  if (!$transRepo) {
                      return $this->json([
                          'mesag' => 'Code incorrect'
                      ]);
                  }else{
                      $data = $serializer->serialize($transRepo, 'json');
                      return new Response($data, 200, [
                          'Content-Type' => 'application/json'
                      ]);
                  }
              }
      }
}
