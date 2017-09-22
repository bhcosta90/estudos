<?php
namespace Automovel\V1\Rest\Usuario;

use Psr\Container\ContainerInterface;

class UsuarioResourceFactory
{
    public function __invoke(ContainerInterface $services)
    {
        $em = $services->get('Doctrine\ORM\EntityManager');
        return new UsuarioResource($em);
    }
}
