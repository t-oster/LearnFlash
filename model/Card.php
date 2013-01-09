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
   * @OneToMany(targetEntity="Answer", mappedBy="card")
   *
   * @var Answer[]
   */
  protected $answers;

  public function __construct() {
    $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    $this->answers = new \Doctrine\Common\Collections\ArrayCollection();
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

  public function getAnswers() {
    return $this->answers;
  }

  public function addAnswer(Tag $answer) {
    $this->answers->add($answer);
    $answer->getAnswers()->add($this);
  }

  public function removeAnswers(Tag $answer) {
    $this->answers->removeElement($answer);
    $answer->getAnswers()->removeElement($this);
  }

}

?>
