<?php

namespace App\Controller;

use App\Entity\Beneficiaire;
use App\Entity\Transactions;
use App\Form\BeneficiaireType;
use App\Repository\BeneficiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
         if(!$retrait){
    return new Response('Le code saisi est incorecte .Veuillez ressayer un autre  '); 
  }else{
     $retrait->setDateretrait(new \DateTime());
     $retrait->setType("retrait");
     $retrait->setCni();
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
}
