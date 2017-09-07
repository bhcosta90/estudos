<?php

namespace Application\Controller\Factory;

use Application\Controller\IndexRestController;
use src\Abstracts\Factory;

class IndexRestFactory extends Factory
{
    protected $controller = IndexRestController::class;
}