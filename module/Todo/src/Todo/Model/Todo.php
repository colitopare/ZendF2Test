<?php

namespace Todo\Model;

class Todo
{
  private $id;
  private $title;
  private $description;
  private $completed;


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
