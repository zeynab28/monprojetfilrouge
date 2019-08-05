<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AjoutControllerTest extends WebTestCase
{
    

    public function testajout()
    {
        $client = static::createClient([],[
                    'PHP_AUTH_USER' => 'ndioufa',
                    'PHP_AUTH_PW' => 'bopp',
        
             ]);
        $crawler = $client->request('POST', '/api/register',[],[],['CONTENT_TYPE'=>"application/json"],

        '{
            
            "username": "sarlem",
            "password": "110025",
            "adresse": "aroser",
            "tel": 77788784,
            "statut": "actif",
            "nom":"adida",
            "roles": ["ADMIN"],
            "prenom":"seck",
            "cni": 777777,
            "partenaire": 2,
            "email":"dija@gmail.com"
        }'
    );
        $rep=$client->getResponse();    
        var_dump($rep);
        $this->assertSame(401,$client->getResponse()->getStatusCode());
    }
   

   
       
    
    
}
