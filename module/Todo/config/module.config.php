<?php

use Todo\Model\TodoTable;
use Zend\Db\ResultSet\ResultSet;
use Todo\Model\Todo;
use Zend\Db\TableGateway\TableGateway;

return array(
    'router' => array(
        'routes' => array(
            'todo' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/todo[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Todo\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Todo\Model\TodoTable' =>  function($sm) {
                $tableGateway = $sm->get('TodoTableGateway');
                $table = new TodoTable($tableGateway);
                return $table;
            },
            'TodoTableGateway' => function ($sm) {
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $resultSetPrototype = new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Todo());
                return new TableGateway('todo', $dbAdapter, null, $resultSetPrototype);
            },
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Todo\Controller\Index' => 'Todo\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
