<?php
/**
 * Created by PhpStorm.
 * User: bhcosta90
 * Date: 06/09/17
 * Time: 23:21
 */

namespace src\Abstracts;

use src\Traits\Base;
use Zend\Mvc\Controller\AbstractActionController as c;

abstract class AbstractActionController extends c
{
    use Base;
}