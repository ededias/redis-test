<?php

namespace App\Service;

use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class RedisService 
{

    public function __construct(
        private CacheInterface $cachePool
        ) {}

    public function save(array $payload, String $key): ?array 
    {
        try {
          
            $value = $this->cachePool->get($key, function (ItemInterface $item) use ($payload) {
                $item->expiresAfter(84600);
                return $payload;
            });
            
            return $value;

        } catch (\Exception $e) {
            dump($e->getMessage());
            return null;
        }    
    }

    public function get(String $key): ?array    
    {
        try {
            return $this->cachePool->get($key, function (ItemInterface $item) {
                return null;
            });
            return $value;
        } catch (\Exception $e) {  
            return null;
        } 
    }
}