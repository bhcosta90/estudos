<?php

namespace src\entities;

use src\traits\Data;

/**
* @Entity @Table(name="usuario")
**/
class Usuario {
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;

    /** @Column(type="string") **/
    protected $login;

    /** @Column(type="string") **/
    protected $senha;

    /** @Column(type="string", nullable=true) **/
    protected $token;

    /** @Column(type="string", nullable=true) **/
    protected $dataAtivo;

    use Data;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = md5(time() . $token);
        return $this;
    }

    function valida($senha){
        return password_verify($senha, $this->senha) ? $this : false;
    }

}

?>
