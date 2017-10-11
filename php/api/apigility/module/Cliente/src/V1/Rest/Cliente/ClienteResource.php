<?php
namespace Cliente\V1\Rest\Cliente;

use Cliente\V1\Rest\Cliente\ClienteEntity;
use Zend\Paginator\Adapter\DbTableGateway;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;
use Zend\Db\TableGateway\TableGateway,
    Zend\Db\ResultSet\ResultSet;

class ClienteResource extends AbstractResourceListener
{
    /**
     * @var \Zend\Db\Adapter\Adapter
     */
    private $tableGateway;

    public function __construct($db) {
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new ClienteEntity());
        $this->tableGateway = new TableGateway('cliente', $db, null, $resultSet);
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $entity = new ClienteEntity();
        $data = json_decode(json_encode($data), true);
        $entity->exchangeArray($data);
        $data = $entity->getArrayCopy();
        $this->tableGateway->insert($data);
        $data['id'] = $this->tableGateway->getLastInsertValue();

        return $data;
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $result = $this->fetch($id);
        if(!$result){
            return new ApiProblem(404, 'Registro não encontrado');
        }
        $this->tableGateway->delete(array('id' => $id));
        return new ApiProblem(200, 'Registro deletado com sucesso', null, "Register Deleted");
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
        $result = $this
            ->tableGateway
            ->select(
                array(
                    'id' => $id
                )
            )
            ->current();
        return $result;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $dbTableGatewayAdapter = new DbTableGateway($this->tableGateway, null, null);
        return new ClienteCollection($dbTableGatewayAdapter);
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
        $result = $this->fetch($id);
        if(!$result){
            return new ApiProblem(404, 'Registro não encontrado');
        }
        $data = json_decode(json_encode($data), true);
        $result->exchangeArray($data);
        $data = $result->getArrayCopy();
        $this->tableGateway->update($data, array('id' => $id));
        return $data;
    }
}
