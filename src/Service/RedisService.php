<?php

namespace App\Service;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class RedisService 
{

    public function __construct(
        private CacheInterface $cachePool
        ) {}

    public function save(array $payload, String $key): ?String 
    {
        try {
            
            $value = $this->cachePool->get($key, function () use ($payload) {
                return $payload;
            });
            return $value;
        } catch (\Exception $e) {
            
            return null;
        }    
    }

    public function get(String $key): ?string
    {
        try {
            return $this->cachePool->get($key, function (ItemInterface $item) {
                // Caso não exista no cache, você pode gerar o objeto aqui
                return null; // Ou gere um objeto novo
            });
            return $value;
        } catch (\Exception $e) {  
            return null;
        } 
    }
}