<?php
namespace Automovel\V1\Rest\Automovel;

use Psr\Container\ContainerInterface;

class AutomovelResourceFactory
{
    public function __invoke(ContainerInterface $services)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $services->get('Doctrine\ORM\EntityManager');
        return new AutomovelResource($em);
    }
}
