<?php

namespace App\Service;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class RedisService 
{

    public function __construct(
        private CacheInterface $cache
        ) {}

    public function save(array $payload, String $key) 
    {
        try {
            $this->cache->get($key, function (ItemInterface $item) use ($payload) {
                $item->expiresAfter(86400);
                return $payload;
            });
        } catch (\Exception $e) {
            return null;
        }    
    }

    public function get(String $key): ?array
    {
        try {
            return $this->cache->get($key, function (ItemInterface $item) {
                return null;
            });
        } catch (\Exception $e) {  
            return null;
        } 
    }
}