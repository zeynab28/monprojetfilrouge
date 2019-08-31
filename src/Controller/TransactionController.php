<?php

namespace App\Controller;

use App\Entity\Compte;
use App\Entity\Tarifs;
use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\TarifsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 */
class TransactionController extends AbstractController
{
   

    /**
     * @Route("/envoi", name="transaction_new", methods={"GET","POST"})
     */
    public function envoi(Request $request, EntityManagerInterface $entityManager,
    SerializerInterface $serializer, ValidatorInterface $validator):Response
    {
        
        $envoi = new Transaction();
        
        $form = $this->createForm(TransactionType::class,$envoi);
        $user = $this->getUser();
// var_dump($user);
        $data = $request->request->all();
        $form->submit($data);

            $envoi->setDatetransaction(new \DateTime());
            $envoi->setType("envoi");
            while (true) {
                if (time() % 1 == 0) {
                    $alea = rand(100,1000000);
                    break;
                }else {
                    slep(1);
                }
            }
            $envoi->setCodetransaction($alea);
           
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
            $entityManager->flush();
           
 return new Response('Le transfert a été effectué avec succés. Voici le code : '.$envoi->getCodetransaction());
            }
            else{
    
    return new Response('Le solde de votre compte ne vous permet d effectuer une transaction');
            }



   
    }

   
    

}
