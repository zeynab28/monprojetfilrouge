<?php

namespace App\Controller;


use App\Entity\Expediteur;
use App\Entity\Tarifs;
use App\Entity\Beneficiaire;
use App\Entity\Transactions;
use App\Form\ExpediteurType;
use App\Form\TransactionsType;
use App\Form\BeneficiaireType;
use App\Repository\ExpediteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ExpediteurController extends AbstractController
{
    
    /**
     * @Route("/send", name="tra", methods={"GET","POST"})
     */
    public function envoi(Request $request, EntityManagerInterface $entityManager,
    SerializerInterface $serializer, ValidatorInterface $validator):Response
    {
      
        $expediteur = new Expediteur();
        $form=$this->createForm(ExpediteurType::class , $expediteur);
        $form->handleRequest($request);
        $data=$request->request->all();
         $form->submit($data);
         $beneficiaire = new Beneficiaire();
         $form=$this->createForm(BeneficiaireType::class , $beneficiaire);
         $form->handleRequest($request);
         $data=$request->request->all();
          $form->submit($data);
          
        $envoi = new Transactions();
        
        $form = $this->createForm(TransactionsType::class,$envoi);
        $user = $this->getUser();
// var_dump($user);
        $data = $request->request->all();
        $form->submit($data);

            $envoi->setDateenvoi(new \DateTime());
            $envoi->setType("envoi");
            while (true) {
                if (time() % 1 == 0) {
                    $alea = rand(100,1000000);
                    break;
                }else {
                    slep(1);
                }
            }
            $envoi->setCode($alea);
           
            $vo=$form->get('montant')->getData();
            $frais= $this->getDoctrine()->getRepository(Tarifs::class)->findAll();
            foreach($frais as $values){
                $values->getBorneinferieure();
                $values->getBornesuperieure();
                $values->getFrais();
                if($vo>=$values->getBorneinferieure() && $vo<=$values->getBornesuperieure() ){
                $com=$values->getFrais();
            $envoi->setFrais($com);
            $envoi->setCometat(($com*30)/100);
            $envoi->setComsystem(($com*40)/100);
            $envoi->setComenvoi(($com*10)/100);
            $envoi->setComretrait(($com*20)/100);
                }
            }

            $compte=$user->getCompte();
            $envoi->setUser($user);

         
            if($compte->getSolde() > $envoi->getMontant() ){
                $montant= $compte->getSolde()-$envoi->getMontant()+$envoi->getComenvoi();
            
                $compte->setSolde($montant);
            $entityManager->persist($compte);
            $entityManager->persist($envoi);
            $entityManager->persist($expediteur);
            $entityManager->persist($beneficiaire);
            $entityManager->flush();
           
 return new Response('Le transfert a été effectué avec succés. Voici le code : '.$envoi->getCode());
            }
            else{
    
    return new Response('Le solde de votre compte ne vous permet d effectuer une transaction');
            }



   
    }
}
