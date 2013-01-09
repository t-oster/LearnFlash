<?php

namespace Model;

/**
 * @Entity
 */
class MindMap {
 
      /**
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   * @var int
   */
  protected $id;
  
  /**
   * @Column(type="string")
   * @var string
   */
  protected $name;
  
  /**
   *
   * @ManyToOne(targetEntity="User", inversedBy="mindMaps")
   *
   * @var User
   */
  protected $owner;
  
  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }
  
  public function getName() {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
  }
  
  public function getOwner() {
    return $this->owner;
  }

  public function setOwner(User $owner) {
    $this->owner = $owner;
    $owner->getMindMaps()->add($this);
  }
  
}
?>
