<?php

namespace Model;
class Answer {
  /**
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   * @var int
   */ 
  protected $id;
  
  /**
   * @Column(type="string")
   * @var int
   */
  protected $rating;
  
  /**
   * @Column(type="string")
   * @var date
   */
  protected $timestamp;
  
  
   /**
   *
   * @ManyToOne(targetEntity="Card", inversedBy="cards")
   *
   * @var Card
   */
  protected $card;
  
   /**
   *
   * @ManyToOne(targetEntity="User", inversedBy="cards")
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
  
  public function getRating() {
    return $this->rating;
  }
  
   public function setRating($rating) {
    $this->rating = $rating;
  }
  public function getTimestamp() {
    return $this->timestamp;
  }
  
   public function setTimestamp($timestamp) {
    $this->timestamp = $timestamp;
  }
  
    public function getOwner() {
    return $this->owner;
  }

   public function setOwner(User $owner) {
    $this->owner = $owner;
    $owner->getAnswers()->add($this);
  }
  
   public function getCard() {
    return $this->card;
  }

  public function setCard($card) {
    $this->email = $card;
  }
}
?>
