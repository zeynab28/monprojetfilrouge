<?php

namespace App\Controller;

use App\Entity\Transactions;
use App\Form\TransactionsType;
use App\Repository\TransactionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 */
class TransactionsController extends AbstractController
{
    /**
     * @Route("/liste_trans", name="list_trans", methods={"GET"})
     */
    public function index(TransactionsRepository $tra, SerializerInterface $serializer)
    {
        $transact = $tra->findAll();
        $data = $serializer->serialize($transact, 'json');

        return new Response($data, 200, [
            'Content-Type' => 'application/json'
        ]);
    } 
    
}
