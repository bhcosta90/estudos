<?php

namespace Application\Controller;

use Swagger\Annotations as SWG;
use src\Abstracts\AbstractRestfulController;

class IndexRestController extends AbstractRestfulController
{
    /*
     * @SWG\Get(
     *     path="/application/api/{id}",
     *     tags={"Teste de Api"},
     *     @SWG\Parameter(name="id", type="integer", in="path"),
     *     @SWG\Response(
     *      response="200",
     *      description="An example resource",
     *      examples={"application/json": {"teste": "teste"}},
     *      schema={"$ref": "#/definitions/Usuario"}
     *     ),
     *     @SWG\Response(response="500", description="An example resource")
     * )
     */
    public function get($id)
    {
        $response = $this->getResponseWithHeader()
            ->setContent(json_encode([__METHOD__ . ' get current data with id =  ' . $id]));
        return $response;
    }

    public function getList()
    {
        $response = $this->getResponseWithHeader()
            ->setContent(json_encode([__METHOD__ . ' get the list of data']));
        return $response;
    }

    /*
     * @SWG\Post(
     *     ="/application/api/{id}",
     *     tags={"Teste de Api"},
     *     @SWG\Parameter(name="id", type="string", in="query"),
     *     @SWG\Response(
     *      response="200",
     *      description="An example resource",
     *      examples={"application/json": {"teste": "teste"}},
     *      schema={"$ref": "#/definitions/Usuario"}
     *     ),
     *     @SWG\Response(response="500", description="An example resource")
     * )
     */
    public function create($data)
    {
        $response = $this->getResponseWithHeader()
            ->setContent(__METHOD__ . ' create new item of data :
                                                    <b>' . $data['name'] . '</b>');
        return $response;
    }

    public function update($id, $data)
    {
        $response = $this->getResponseWithHeader()
            ->setContent(__METHOD__ . ' update current data with id =  ' . $id .
                ' with data of name is ' . $data['name']);
        return $response;
    }

    public function delete($id)
    {
        $response = $this->getResponseWithHeader()
            ->setContent(__METHOD__ . ' delete current data with id =  ' . $id);
        return $response;
    }

    // configure response
    public function getResponseWithHeader()
    {
        /**
         * @var $response \Zend\Http\PhpEnvironment\Response
         */
        $response = $this->getResponse();
        $response->getHeaders()
            //make can accessed by *
            ->addHeaderLine('Access-Control-Allow-Origin', '*')
            //set allow methods
            ->addHeaderLine('Access-Control-Allow-Methods', 'POST PUT DELETE GET')
        ->addHeaderLine('Content-type', 'text/json');

        return $response;
    }
}