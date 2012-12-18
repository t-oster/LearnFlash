<?php
namespace Model;

/**
 * Description of Tag
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 * @Entity
 */
class Tag {
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
   * @Column(type="string")
   * @var string
   */
  protected $color;
  /**
   *
   * @ManyToOne(targetEntity="User", inversedBy="tags")
   *
   * @var User
   */
  protected $owner;
  /**
   *
   * @ManyToMany(targetEntity="Card", inversedBy="tags")
   *
   * @var Card[]
   */
  protected $cards;
  
  public function __construct() {
    $this->cards = new \Doctrine\Common\Collections\ArrayCollection();
  }
  
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

  public function getColor() {
    return $this->color;
  }

  public function setColor($color) {
    $this->color = $color;
  }

  public function getOwner() {
    return $this->owner;
  }

  public function setOwner(User $owner) {
    $this->owner = $owner;
    $owner->getTags()->add($this);
  }

  public function getCards() {
    return $this->cards;
  }

}

?>
