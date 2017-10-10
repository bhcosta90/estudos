<?php

namespace src\entities;

/**
* @Entity @Table(name="automovel_dados")
**/
class AutomovelDados {
    /** @Id @ManyToOne(targetEntity="Automovel") */
    protected $automovel;

    /** @Id @Column(type="string") */
    protected $chave;

    /** @Column(type="string") */
    protected $valor;
}

?>
