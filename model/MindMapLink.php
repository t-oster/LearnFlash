<?php
namespace Model;

/**
 * Description of MindMapLink
 *
 * @author maus
 * @Entity
 */
class MindMapLink {

  /**
   * @Id @Column(type="integer") @GeneratedValue
   * @var int
   */
  protected $id;
  
  /**
   * @Column(type="string")
   * @var String
   */
  protected $text;
  
  /**
   * @Column(type="boolean")
   * @var boolean
   */
  protected $leftArrow;
  
  /**
   * @Column(type="boolean")
   * @var boolean
   */
  protected $rightArrow;
  
  /**
   * @OneToOne(targetEntity="MindMapNode")
   * @JoinColumn(name="mindMapNode_id", referencedColumnName="id")
   * @var User
   */
  protected $leftNode;
  
  /**
   * @OneToOne(targetEntity="MindMapNode")
   * @JoinColumn(name="mindMapNode_id", referencedColumnName="id")
   * @var User
   */
  protected $rightNode;
  
  public function getLeftNode()
  {
    return $this->leftNode;
  }
  
  public function setLeftNode($newLeftNode)
  {
    $this->leftNode = $newLeftNode;
  }
  
  public function getRightNode()
  {
    return $this->rightNode;
  }
  
  public function setRightNode($newRightNode)
  {
    $this->rightNode = $newRightNode;
  }
  
  public function IsLeftArrow()
  {
    return $this->leftArrow;
  }
  
  public function setLeftArrow($isLeftArrow)
  {
    $this->leftArrow = $isLeftArrow;
  }
  
  public function IsRightArrow()
  {
    return $this->rightArrow;
  }
  
  public function setRightArrow($isRightArrow)
  {
    $this->rightArrow = $isRightArrow;
  }
}

?>
