<?php
namespace Cliente\V1\Rest\Cliente;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

class ClienteCollection extends Paginator
{
    public function __construct($userCollection) {
        parent::__construct(new ArrayAdapter($userCollection));
    }
}
