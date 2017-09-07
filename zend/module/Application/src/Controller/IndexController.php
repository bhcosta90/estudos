<?php

namespace Application\Controller;

use src\Abstracts\AbstractActionController;
use src\Util\Http;

//use Zend\Http\Client as HttpClient;

#https://samsonasik.wordpress.com/2012/10/31/zend-framework-2-step-by-step-create-restful-application/
#https://github.com/Tony133/ZF3-ApiRest

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        /**
         * @var $response Http
         */
        $response = $this->getServiceManager()->get('http');
        $retorno = $response->get('http://nginx/application/api/1');

        $html = "";
        if ($retorno->getStatusCode()) {
            $html = $retorno->getBody();
        }

        $response = $this->getResponse();
        $response->setContent($html);

        return $response;
    }
}
