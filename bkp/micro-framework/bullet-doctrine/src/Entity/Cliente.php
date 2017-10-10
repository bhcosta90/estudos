<?php
/**
 * Created by PhpStorm.
 * User: bhcosta90
 * Date: 27/09/17
 * Time: 22:39
 */

namespace Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class Cliente
 * @ORM\Entity
 * @ORM\Table(name="cliente")
 */
class Cliente
{
    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $nome;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
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