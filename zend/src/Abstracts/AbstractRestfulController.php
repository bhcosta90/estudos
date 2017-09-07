<?php
/**
 * Created by PhpStorm.
 * User: bhcosta90
 * Date: 06/09/17
 * Time: 23:19
 */

namespace src\Abstracts;

use src\Traits\Base;
use Zend\Mvc\Controller\AbstractRestfulController as c;

abstract class AbstractRestfulController extends c
{
    use Base;
}