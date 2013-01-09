<?php

namespace Model;

/**
 * @Entity
 */
class MindMapCard {
    /**
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   * @var int
   */
  protected $id;

    /**
   *
   * @ManyToOne(targetEntity="Card", inversedBy="mindMapCards")
   *
   * @var Card
   */
  protected $owner;
   public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }
    public function getOwner() {
    return $this->owner;
  }

  public function setOwner(User $owner) {
    $this->owner = $owner;
    $owner->getMindMapCards()->add($this);
  }
}
?>
