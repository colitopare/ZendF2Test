<?php

namespace Todo\Controller;

use Todo\Model\Todo;
use Todo\Form\TodoForm;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * IndexController
 *
 * @author
 *
 * @version
 *
 */
class IndexController extends AbstractActionController
{
    protected $todoTable;

    public function getTodoTable()
    {
        return $this->todoTable;
    }

    /**
     * Action par d�faut - Lister les t�ches
     */
    public function indexAction()
    {
        $todos = $this->getTodoTable()->fetchAll();
        return ['todos' => $todos];
    }

    /**
     * Cr�er une nouvelle t�che
     *
     */
    public function createAction()
    {
        $form = new TodoForm;

        $request = $this->getRequest();
        if ($request->isPost()) {
            $todo = new Todo;
            $form->setInputFilter($todo->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $todo->exchangeArray($form->getData());
                $this->getTodoTable()->saveTodo($todo);

                return $this->redirect()->toRoute('todo');
            }
        }
        return ['form' => $form];
    }

    /**
     * Editer une t�che
     *
     */
    public function editAction()
    {
        $id = $this->params()->fromRoute('id', 0);
        if (!$id) {
            throw new \Exception("id is wrong");
        }

        try {
            $todo = $this->todoTable->getTodo($id);
        } catch (\Exception $e) {
            throw $e;
        }

        $form = new TodoForm;
        $form->bind($todo);
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($todo->getInputFilter());
            if ($form->isValid()) {
                $todo->exchangeArray($request->getPost()->toArray());
                $this->getTodoTable()->saveTodo($todo);

                return $this->redirect()->toRoute('todo');
            }
        }
        return [
            'id' => $id,
            'form' => $form
        ];
    }

    /**
     * Supprimer une t�che
     *
     */
    public function deleteAction()
    { }
}
