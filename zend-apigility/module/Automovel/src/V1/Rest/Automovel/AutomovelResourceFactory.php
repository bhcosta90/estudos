<?php
namespace Automovel\V1\Rest\Automovel;

class AutomovelResourceFactory
{
    public function __invoke($services)
    {
        $em = $services->get('Doctrine\ORM\EntityManager');
        return new AutomovelResource($em);
    }
}
