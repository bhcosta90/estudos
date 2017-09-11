<?php

namespace Application\Controller;

use src\Abstracts\AbstractRestfulController;
use Application\Entity\Usuario;

class RestClienteController extends AbstractRestfulController
{
    public function get($id)
    {
        $response = $this->getResponseWithHeader()
            ->setContent(__METHOD__ . ' get current data with id =  ' . $id);
        return $response;
    }

    public function getList()
    {
        $response = $this->getResponseWithHeader()
            ->setContent(__METHOD__ . ' get the list of data');
        return $response;
    }

    public function create($data)
    {
        $email = strtolower($data["login"]);
        $user = $this->getEntityManager()->getRepository(Usuario::class)->findOneByLogin($email) ?? new Usuario();

        if($user->getId()){
            return $this->getResponseWithHeader()
                ->setContent(json_encode([
                "status" => "E",
                "mensagem" => "Usuário já cadastrado em nosso sistema",
                "tempo" => [
                    "total" => tempoExecucao(MICRO),
                    "inicio" => MICRO,
                    "fim" => floatval(microtime())
                ]
            ]));
        }else{
            $user->setLogin($email);
            $user->setSenha($data["senha"]);

            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();

            return $this->getResponseWithHeader()
                ->setContent(json_encode([
                "status" => "S",
                "mensagem" => "Usuário cadastrado com sucesso",
                "tempo" => [
                    "total" => tempoExecucao(MICRO),
                    "inicio" => MICRO,
                    "fim" => floatval(microtime())
                ]
            ]));
        }

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
            ->addHeaderLine('Access-Control-Allow-Methods', 'POST PUT DELETE GET');

        return $response;
    }
}
