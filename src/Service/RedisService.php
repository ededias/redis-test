<?php

namespace App\Service;

use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

// use Symfony\Component\Cache\Adapter\RedisAdapter;


// $cache = new RedisAdapter(
//     \Redis $redisConnection,
// );

class RedisService 
{

    public function __construct(
        private CacheInterface $cache
        ) {}

    public function save(array $payload, String $key): ?String 
    {
        try {
            $this->cache->get($key, function (ItemInterface $item) use ($payload) {
                $item->expiresAfter(86400);
                return $payload;
            });
        } catch (\Exception $e) {
            return $e->getMessage();
        }    
    }

    public function get(String $key): ?array
    {
        try {
            return $this->cache->get($key, function (ItemInterface $item) {
                return null;
            });
        } catch (\Exception $e) {  
            return $e->getMessage();
        } 
    }
}