<?php
/**
 * Created by PhpStorm.
 * User: bhcosta90
 * Date: 07/09/17
 * Time: 00:35
 */

namespace src\Traits;


use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

trait Base
{
    private $container, $em;

    public function __construct(EntityManager $em, ContainerInterface $container)
    {
        $this->container = $container;
        $this->em = $em;
    }

    protected function getServiceManager(){
        return $this->container;
    }

    protected function getEntityManager(){
        return $this->em;
    }
}