<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;

/*
 * @SWG\Definition()
 */
 
/**
* @ORM\Entity @ORM\Table(name="usuario")
**/
class Usuario {
    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue **/
    /*
     * @var string
     *
     * @SWG\Property(
     *     description="Referencia do Usuário"
     * )
     */
    protected $id;

    /** @ORM\Column(type="string") **/
    /*
     * @var string
     *
     * @SWG\Property(
     *     property="_links",
     *     @SWG\Property(
     *         property="self",
     *         @SWG\Property(type="string", property="href")
     *     ),
     *     @SWG\Property(
     *         property="MyOtherModelLink",
     *         @SWG\Property(type="string", property="href")
     *     )
     * )
     */
    protected $login;

    /** @ORM\Column(type="string") **/
    protected $senha;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $token;

    /** @ORM\Column(type="string", nullable=true) **/
    protected $dataAtivo;

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