<?php
namespace Cliente\V1\Rest\Cliente;

class ClienteResourceFactory
{
    public function __invoke($services)
    {
        $em = $services->get('Doctrine\ORM\EntityManager');
        return new ClienteResource($em);
    }
}
