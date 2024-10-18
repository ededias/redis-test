<?php

namespace App\Controller;

use App\Service\RedisService;
use App\Service\ViaCEPService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ZipcodeController extends AbstractController 
{

    public function __construct(
        private ViaCEPService $service, // service para realizar requisição para API do viacep 
        private RedisService $redisService // service do redis 
        ) {}

    #[Route('/zipcode/{code}')]
    public function getZipcode($code): JsonResponse
    {
        try {

            $response = $this->service->loadZipCode($code);
            // busca dados do CEP para verificar se o dado esta armazenado anteriormente
            $responseRedis = $this->redisService->get('zipcode');
            // valida para verificar se o valor já existe
            if (!$responseRedis) {
                // caso não exista salva no redis
                $this->redisService->save($response, 'zipcode');
            }
            // retorna a requisição
            return $this->json([$response], 200);
        } catch (\Exception $th) {
            return $this->json([], 200);
        }
    }

}