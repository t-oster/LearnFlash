<?php
namespace Model;

/**
 * @Entity
 */
class MindMapCard extends MindMapNode {
  
  /**
   * @ManyToOne(targetEntity="Card", inversedBy="mindMapCards")
   * @JoinColumn(name="card_id", referencedColumnName="id")
   * @var Card
   */
  protected $card;
  
  public function getCard()
  {
    return $this->card;
  }
  
  public function setCard($newCard)
  {
    $this->card = $newCard;
  }
  
}

?>
