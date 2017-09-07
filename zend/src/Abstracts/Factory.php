<?php
/**
 * Created by PhpStorm.
 * User: bhcosta90
 * Date: 07/09/17
 * Time: 00:37
 */

namespace src\Abstracts;


use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

abstract class Factory
{
    protected $controller;

    public function __invoke(ContainerInterface $container)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        return new $this->controller($entityManager, $container);
    }
}
