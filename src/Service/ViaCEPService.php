<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ViaCEPService 
{

    public function __construct(
        private HttpClientInterface $client
        ) {}

    public function loadZipCode($zipcode) 
    {
        try {
            $response = $this->client->request("GET","https://viacep.com.br/ws/{$zipcode}/json/");
            
            $content = $response->toArray();

            return $content;

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}