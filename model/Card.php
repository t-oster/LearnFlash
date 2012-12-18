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

}

?>
