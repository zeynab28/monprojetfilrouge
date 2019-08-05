<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DepotControllerTest extends WebTestCase
{
    public function testajout()
    {
        $client = static::createClient([],[
                    'PHP_AUTH_USER' => 'ndioufa',
                    'PHP_AUTH_PW' => 'bopp',
        
             ]);
        $crawler = $client->request('POST', '/api/depot',[],[],['CONTENT_TYPE'=>"application/json"],

        '{
            
            "compte":12,
            "montant":75000,
            "user": 29
        }'
    );
        $rep=$client->getResponse();    
        var_dump($rep);
        $this->assertSame(401,$client->getResponse()->getStatusCode());
    }
}
