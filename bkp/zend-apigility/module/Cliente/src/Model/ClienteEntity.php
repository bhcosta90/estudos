<?php
/**
 * Created by PhpStorm.
 * User: bhcosta90
 * Date: 09/10/17
 * Time: 22:02
 */

namespace Cliente\Model;


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