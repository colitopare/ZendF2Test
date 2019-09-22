<?php

namespace Todo\Model;

use Exception;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;

// implements InputFilterAwareInterface
// doc: https://framework.zend.com/manual/1.10/fr/zend.filter.input.html
class Todo implements InputFilterAwareInterface
{
  private $id;
  private $title;
  private $description;
  private $completed;

  protected $inputFilter;

  // InputFilterAwareInterface oblige d'implémenter les 2 méthodes suivantes
  public function setInputFilter(InputFilterInterface $inputFilter)
  {
    throw new \Exception("Non Implémenter");
  }


  public function getInputFilter()
  {
    if (!$this->inputFilter) {
      $inputFilter = new InputFilter;

      $inputFilter->add(array(
        'name'     => 'id',
        'required' => true,
        'filters'  => array(
          array('name' => 'Int'),
        ),
      ));

      $inputFilter->add(array(
        'name'     => 'title',
        'required' => true,
        'filters'  => array(
          // supprime les balises
          array('name' => 'StripTags'),
          // supprime les espaces blancs
          array('name' => 'StringTrim'),
        ),
        // vérifie l'encodage et la taille mini et max
        'validators' => array(
          array(
            'name'    => 'StringLength',
            'options' => array(
              'encoding' => 'UTF-8',
              'min'      => 1,
              'max'      => 100,
            ),
          ),
        ),
      ));

      $inputFilter->add(array(
        'name'     => 'description',
        'required' => true,
        'filters'  => array(
          array('name' => 'StripTags'),
          array('name' => 'StringTrim'),
        ),
        'validators' => array(
          array(
            'name'    => 'StringLength',
            'options' => array(
              'encoding' => 'UTF-8',
              'min'      => 1,
              'max'      => 250,
            ),
          ),
        ),
      ));

      $this->inputFilter = $inputFilter;
    }

    return $this->inputFilter;
  }



  /**
   * Get the value of complete
   */
  public function getCompleted()
  {
    return $this->completed;
  }

  /**
   * Set the value of complete
   *
   * @return  self
   */
  public function setCompleted($completed)
  {
    $this->completed = $completed;

    return $this;
  }

  /**
   * Get the value of description
   */
  public function getDescription()
  {
    return $this->description;
  }

  /**
   * Set the value of description
   *
   * @return  self
   */
  public function setDescription($description)
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Get the value of title
   */
  public function getTitle()
  {
    return $this->title;
  }

  /**
   * Set the value of title
   *
   * @return  self
   */
  public function setTitle($title)
  {
    $this->title = $title;

    return $this;
  }

  /**
   * Get the value of id
   */
  public function getId()
  {
    return $this->id;
  }

  /**
   * Set the value of id
   *
   * @return  self
   */
  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  // Cette méthode va permettre d'échanger les données entre la BDD et la classe Todo
  public function exchangeArray($data)
  {
    $this->id = (isset($data['id'])) ? $data['id'] : null;
    $this->title = (isset($data['title'])) ? $data['title'] : null;
    $this->description = (isset($data['description'])) ? $data['description'] : null;
    $this->completed = (isset($data['completed'])) ? $data['completed'] : null;
  }
}
