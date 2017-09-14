<?php

namespace Application\Controller\Factory;

use Application\Controller\RestClienteController;
use src\Abstracts\Factory;

class RestClienteFactory extends Factory
{
    protected $controller = RestClienteController::class;
}
