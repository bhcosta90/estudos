<?php
namespace Automovel\V1\Rest\Usuario;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Automovel\Entity\Usuario;
use Automovel\V1\Rest\Usuario\UsuarioCollection;

class UsuarioResource extends AbstractResourceListener
{
    private $em;
    public function __construct($em) {
        $this->em = $em;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $user = $this->em->getRepository(Usuario::class)->findOneByLogin($data->login) ?? new Usuario();
        //
        if(!$user->getId()){
            $user->setLogin($data->login);
            $user->setSenha($data->senha);

            $this->em->persist($user);
            $this->em->flush();

            return new ApiProblem(200, [
                "mensagem" => 'Usuário cadastrado com sucesso',
                "token" => $user->getToken()
            ]);
        }

        return new ApiProblem(503, 'Usuário já cadastrado em nosso sistema');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $user = $this->em->getRepository(Usuario::class)->find($id);
        //
        if($user){
            $this->em->remove($user);
            $this->em->flush();

            return new ApiProblem(200, 'Usuário deletado com sucesso');
        }

        return new ApiProblem(404, 'Não foi possível deletar o usuário');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('e');
        $qb->from(Usuario::class, 'e');
        $qb->where('e.id = :id');
        $qb->setParameters(array(
            'id' => $id
        ));
        return $qb->getQuery()->getArrayResult();
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('e');
        $qb->from(Usuario::class, 'e');
        return new UsuarioCollection($qb->getQuery()->getArrayResult());
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
