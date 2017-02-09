<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

abstract class AbstractController extends Controller
{
    protected function getEntityList(): array
    {
        $cache = new FilesystemAdapter();

        $cacheItem = $cache->getItem('ride-list');

        if (!$cacheItem->isHit()) {
            return [];
        }

        $jsonList = $cacheItem->get();

        $entityList = [];

        foreach ($jsonList as $json) {
            /** @var Ride $entity */
            $entity = $this->get('jms_serializer')->deserialize($json, 'AppBundle\Entity\Ride', 'json');
            array_unshift($entityList, $entity);
        }

        return $entityList;
    }
}