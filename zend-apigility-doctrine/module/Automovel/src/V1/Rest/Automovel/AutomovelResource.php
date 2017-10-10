<?php
namespace Automovel\V1\Rest\Automovel;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Automovel\Entity\Usuario;
use Automovel\Entity\Automovel;
use Automovel\V1\Rest\Automovel\AutomovelCollection;

class AutomovelResource extends AbstractResourceListener
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
        if(!@$_SERVER['HTTP_AUTHORIZATION']){
            return new ApiProblem(503, 'Token não informado');
        }
        $user = $this->em->getRepository(Usuario::class)->findOneByToken($_SERVER['HTTP_AUTHORIZATION']);

        if(!$user){
            return new ApiProblem(503, 'Token inválido');
        }

        $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->em);

        $automovel = new Automovel();
        $automovel->setNome($data->nome);
        $automovel->setUsuario($user);
        $automovel->setCidade($data->cidade);
        $automovel->setDescricao($data->descricao);
        $automovel->setUf(mb_strtoupper($data->uf));

        $this->em->persist($automovel);
        $this->em->flush();

        return new ApiProblem(200, "Automóvel cadastrado com sucesso");
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
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
        $qb->from(Automovel::class, 'e');
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
        $qb->from(Automovel::class, 'e');

        return new AutomovelCollection($qb->getQuery()->getArrayResult());
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
        if(!@$_SERVER['HTTP_AUTHORIZATION']){
            return new ApiProblem(503, 'Token não informado');
        }
        $user = $this->em->getRepository(Usuario::class)->findOneByToken($_SERVER['HTTP_AUTHORIZATION']);

        if(!$user){
            return new ApiProblem(503, 'Token inválido');
        }

        $automovel = $this->em->find(Automovel::class, $id);

        if($automovel->getUsuario()->getToken() != $_SERVER['HTTP_AUTHORIZATION']){
            return new ApiProblem(503, 'Você não é o dono desse automóvel');
        }

        $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject($this->em);

        $automovel->setNome($data->nome);
        $automovel->setUsuario($user);
        $automovel->setCidade($data->cidade);
        $automovel->setDescricao($data->descricao);
        $automovel->setUf(mb_strtoupper($data->uf));

        $this->em->flush();

        return new ApiProblem(200, "Automóvel atualizado com sucesso");
    }
}
