<?php

namespace app\entities;

use app\traits\Data;

/**
* @Entity @Table(name="automovel")
**/
class Automovel {
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="string") **/
    protected $nome;

    /** @Column(type="string", length=3) **/
    protected $uf;

    /** @Column(type="string") **/
    protected $cidade;

    /** @Column(type="text") **/
    protected $descricao;

    /**
    * @ManyToOne(targetEntity="Usuario")
    */
    protected $usuario;

    use Data;
}

?>
