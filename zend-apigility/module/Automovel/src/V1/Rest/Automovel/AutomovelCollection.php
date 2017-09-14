<?php
namespace Automovel\V1\Rest\Automovel;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;

class AutomovelCollection extends Paginator
{
    public function __construct($userCollection) {
        parent::__construct(new ArrayAdapter($userCollection));
    }
}
