<?php
namespace Automovel\V1\Rest\Usuario;

class UsuarioResourceFactory
{
    public function __invoke($services)
    {
        $em = $services->get('Doctrine\ORM\EntityManager');
        return new UsuarioResource($em);
    }
}
