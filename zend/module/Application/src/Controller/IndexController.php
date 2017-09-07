<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use src\Abstracts\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Http\Client as HttpClient;
#https://samsonasik.wordpress.com/2012/10/31/zend-framework-2-step-by-step-create-restful-application/

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $client = new HttpClient();
        $client->setAdapter('Zend\Http\Client\Adapter\Curl');

        $client->setUri('http://nginx/application/api/1');

        $response = $client->send();

        if (!$response->isSuccess()) {
            // report failure
            $message = $response->getStatusCode() . ': ' . $response->getReasonPhrase();

            $response = $this->getResponse();
            $response->setContent($message);
            return $response;
        }
        $body = $response->getBody();

        $response = $this->getResponse();
        $response->setContent($body);
        return $response;
        //return new ViewModel();
    }
}
