<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TreeajoutTest extends WebTestCase
{
    public function testajout() 
    {
        $client = static::createClient([],[
                    'PHP_AUTH_USER' => 'zeynab',
                    'PHP_AUTH_PW' => '123',
        
             ]);
        $crawler = $client->request('POST', '/api/ajout',[],[],['CONTENT_TYPE'=>"application/json"],

        '{
            "rs": "sa",
            "ninea": "6e54k",
            "phone":7775185,
            "adresse":"km",
            "statut":"actif",
            "username":"kya",
            "password":"km",
            "roles": "CAISSIER",
            "prenom": "kya",
            "nom": "diop",
            "email": "kd@gmail.com",
            "cni": 748500222,
            "tel": 7747544,
            "solde":0
            
        }'
    );
        $rep=$client->getResponse();    
        var_dump($rep);
        $this->assertSame(500,$client->getResponse()->getStatusCode());
    }
       
}
