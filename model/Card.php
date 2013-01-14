<?php

namespace Model;

/**
 * Description of Card
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 * @Entity
 */
class Card {

  /**
   * @Id
   * @Column(type="integer")
   * @GeneratedValue
   * @var int
   */
  protected $id;

  /**
   * @Column(type="integer")
   * @var int
   */
  protected $lastResult = 0;
  
  /**
   * @Column(type="integer")
   * @var int
   */
  protected $countResult1 = 0;
  
  /**
   * @Column(type="integer")
   * @var int
   */
  protected $countResult2 = 0;
  
  /**
   * @Column(type="integer")
   * @var int
   */
  protected $countResult3 = 0;
  
  /**
   * @Column(type="integer")
   * @var int
   */
  protected $countResult4 = 0;
  
  /**
   * for assigning the right repetition
   * date for SM-2 algorithm
   * 
   * @Column(type="datetime", nullable=true)
   * @var int
   */
  protected $lastAnswered = null;
  
  /**
   * easiness-factor for SM-2 algorithm
   * 
   * @Column(type="decimal")
   * @var double
   */
  protected $easiness = 2.5;
  
  /**
   * @Column(type="integer")
   * @var int
   */
  protected $repetitions = 0;
  
  /**
   * @Column(type="string")
   * @var string
   */
  protected $title;

  /**
   * @Column(type="string")
   * @var string
   */
  protected $frontHtml;

  /**
   * @Column(type="string")
   * @var string
   */
  protected $backHtml;

  /**
   *
   * @ManyToOne(targetEntity="User", inversedBy="cards")
   *
   * @var User
   */
  protected $owner;

  /**
   *
   * @ManyToMany(targetEntity="Tag", mappedBy="cards")
   *
   * @var Tags[]
   */
  protected $tags;
  
   /**
   * @OneToMany(targetEntity="MindMapCard", mappedBy="card")
   *
   * @var MindMapCard[]
   */
  protected $mindMapCards;
  
  public function __construct() {
    $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    $this->mindMapCards= new \Doctrine\Common\Collections\ArrayCollection();
  }

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getTitle() {
    return $this->title;
  }

  public function setTitle($title) {
    $this->title = $title;
  }

  public function getFrontHtml() {
    return $this->frontHtml;
  }

  public function setFrontHtml($frontHtml) {
    $this->frontHtml = $frontHtml;
  }

  public function getBackHtml() {
    return $this->backHtml;
  }

  public function setBackHtml($backHtml) {
    $this->backHtml = $backHtml;
  }

  public function getOwner() {
    return $this->owner;
  }

  public function setOwner(User $owner) {
    $this->owner = $owner;
    $owner->getCards()->add($this);
  }

  public function getTags() {
    return $this->tags;
  }

  public function addTag(Tag $tag) {
    $this->tags->add($tag);
    $tag->getCards()->add($this);
  }

  public function removeTag(Tag $tag) {
    $this->tags->removeElement($tag);
    $tag->getCards()->removeElement($this);
  }
  
  public function getMindMapCards() {
    return $this->mindMapCards;
  }
  
  public function getLastResult() {
    return $this->lastResult;
  }

  public function setLastResult($lastResult) {
    $this->lastResult = $lastResult;
  }

  public function getCountResult1() {
    return $this->countResult1;
  }

  public function getCountResult2() {
    return $this->countResult2;
  }

  public function getCountResult3() {
    return $this->countResult3;
  }

  public function getCountResult4() {
    return $this->countResult4;
  }

  public function getLastAnswered() {
    return $this->lastAnswered;
  }

  public function setLastAnswered($lastAnswered) {
    $this->lastAnswered = $lastAnswered;
  }

  public function getEasiness() {
    return $this->easiness;
  }

  public function setEasiness($easiness) {
    $this->easiness = $easiness;
  }

  public function resetResults() {
    $this->countResult1 = 0;
    $this->countResult2 = 0;
    $this->countResult3 = 0;
    $this->countResult4 = 0;
    $this->lastResult = 0;
    $this->lastAnswered = null;
    $this->easiness = 2.5;
    $this->repetitions = 0;
  }
  
  public function getCountAnswers()
  {
    return $this->countResult1 + $this->countResult2 + $this->countResult3 + $this->countResult4;
  }
  
  public function getAverageResult()
  {
    $count = $this->getCountAnswers();
    return $count == 0 ? 0 : ($this->countResult1+2*$this->countResult2+3*$this->countResult3+4*$this->countResult4) / $count;
  }
  
  public function addResult($result) {
    switch ($result)
    {
      case 1:
      {
        $this->countResult1++;
        break;
      }
      case 2:
      {
        $this->countResult2++;
        break;
      }
      case 3:
      {
        $this->countResult3++;
        break;
      }
      case 4: 
      {
        $this->countResult4++;
        break;
      }
    }
    $this->lastResult = $result;
    $this->lastAnswered = new \DateTime();
  }
 
  public function getRepetitions() {
    return $this->repetitions;
  }

  public function setRepetitions($repetitions) {
    $this->repetitions = $repetitions;
  }

}

?>
