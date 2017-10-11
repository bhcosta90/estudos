<?php
namespace Cliente\V1\Rest\Cliente;

class ClienteResourceFactory
{
    public function __invoke($services)
    {
        $db = $services->get('DB\Sistema');
        return new ClienteResource($db);
    }
}
