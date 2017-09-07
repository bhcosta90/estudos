<?php

namespace Application\Controller\Factory;


use Application\Controller\IndexController;
use src\Abstracts\Factory;

class IndexFactory extends Factory
{
    protected $controller = IndexController::class;
}