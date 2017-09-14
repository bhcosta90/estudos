<?php

namespace Automovel\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity @ORM\Table(name="automovel_dados")
**/
class AutomovelDados {
    /** @ORM\Id @ORM\ManyToOne(targetEntity="Automovel") */
    protected $automovel;

    /** @ORM\Id @ORM\Column(type="string") */
    protected $chave;

    /** @ORM\Column(type="string") */
    protected $valor;
}

?>
