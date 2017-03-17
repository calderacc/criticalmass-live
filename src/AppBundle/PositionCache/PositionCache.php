<?php

namespace AppBundle\ViewStorage;

use AppBundle\Entity\Position;
use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class PositionCache
{
    /** @var AbstractAdapter $cache */
    protected $cache;

    public function __construct()
    {
        $this->cache = new FilesystemAdapter();
    }

    public function getPositionListJson(): string

    public function countView(Position $position)
    {
        $cacheItem = $this->cache->getItem('position_cache');

        if (!$cacheItem->isHit()) {
            $positionStorage = [];
        } else {
            $positionStorage = $cacheItem->get();
        }

        $viewDateTime = new \DateTime('now', new \DateTimeZone('UTC'));

        $user = $this->tokenStorage->getToken()->getUser();
        $userId = null;

        if ($user instanceof User) {
            $userId = $user->getId();
        }

        $view =
            [
                'className' => $this->getClassName($viewable),
                'entityId' => $viewable->getId(),
                'userId' => $userId,
                'dateTime' => $viewDateTime->format('Y-m-d H:i:s')
            ];

        $viewStorage[] = $view;
        $viewStorageItem->set($viewStorage);

        $this->cache->save($viewStorageItem);
    }

    protected function getClassName(ViewableInterface $viewable): string
    {
        $namespaceClass = get_class($viewable);
        $namespaceParts = explode('\\', $namespaceClass);

        $className = array_pop($namespaceParts);

        return $className;
    }
}