<?php

namespace Todo\Model;

use Exception;
use Zend\Db\TableGateway\TableGateway;

class TodoTable
{
    protected $tableGateway;

    public function __construct(TableGateway $gateway)
    {
        $this->tableGateway = $gateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getTodo($id)
    {
        $id = (int) $id;
        $set = $this->tableGateway->select(['id' => $id]);
        $row = $set->current();
        if (!$row) {
            throw new Exception("Il n'y a pas de tâche avec l'id $id ");
        }
        return $row;
    }

    public function saveTodo(Todo $todo)
    {
        $data = [
            'title' => $todo->getTitle(),
            'description' => $todo->getDescription(),
            'completed' => $todo->getCompleted()
        ];
        $id = (int) $todo->getId();

        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getTodo($id)) {
                $this->tableGateway->update($data, ['id' => $id]);
            } else {
                throw new Exception("l'identifiant de la tâche passé à getTodo n'existe pas");
            }
        }
    }

    public function deleteTodo($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}
