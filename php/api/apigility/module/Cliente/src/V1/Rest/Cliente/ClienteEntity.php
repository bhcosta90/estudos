<?php
namespace Cliente\V1\Rest\Cliente;

class ClienteEntity
{
    private $id;
    public $nome;

    public function getArrayCopy() {
        return array(
            'id' => $this->id,
            'nome' => $this->nome,
        );
    }

    public function exchangeArray($data) {
        foreach($data as $key=>$value){
            if(in_array($key, array('id','nome'))){
                $this->$key = $value;
            }
        }
    }
}
