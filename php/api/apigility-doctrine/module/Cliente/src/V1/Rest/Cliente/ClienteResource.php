<?php
namespace Cliente\V1\Rest\Cliente;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Cliente\V1\Rest\Cliente\ClienteEntity;

class ClienteResource extends AbstractResourceListener
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
        $cliente = new ClienteEntity();
        $cliente->setNome($data->nome);
        $this->em->persist($cliente);
        $this->em->flush();

        return new ApiProblem(200, 'Cliente cadastrado com sucesso');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $cliente = $this->em->getReference(ClienteEntity::class, $id);
        if($cliente){
            $this->em->remove($cliente);
            $this->em->flush();
            return new ApiProblem(200, 'Cliente deletado com sucesso');
        }

        return new ApiProblem(404, 'Cliente não encontrado');
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
        $qb->from(ClienteEntity::class, 'e');
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
        $qb->from(ClienteEntity::class, 'e');

        return new ClienteCollection($qb->getQuery()->getArrayResult());
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
        $cliente = $this->em->getReference(ClienteEntity::class, $id);
        $cliente->setNome($data->nome);
        $this->em->flush();

        return new ApiProblem(200, 'Cliente atualizado com sucesso');
    }
}
