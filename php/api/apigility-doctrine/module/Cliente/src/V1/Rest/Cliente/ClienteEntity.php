<?php

namespace Cliente\V1\Rest\Cliente;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity @ORM\Table(name="cliente")
**/
class ClienteEntity {
    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;

    /** @ORM\Column(type="string") **/
    protected $nome;

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

}
