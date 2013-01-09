<?php
namespace Model;

/**
 * @Entity
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"mindMapCard" = "MindMapCard", "mindMap" = "MindMap"})
 */
abstract class MindMapNode {
  
  /**
   * @Id @Column(type="integer") @GeneratedValue
   * @var int
   */
  protected $id;
  
  /**
   * @ManyToOne(targetEntity="MindMapNode", inversedBy="children")
   **/
  protected $parent;
  
  /** 
   * @Column(type="decimal") 
   * @var double
   */
  protected $x;
  
  /** 
   * @Column(type="decimal") 
   * @var double
   */
  protected $y;
  
  /** 
   * @Column(type="boolean") 
   * @var boolean
   */
  protected $collapsed;
  
  public function getParent() {
    return $this->parent;
  }

  public function setParent(\Model\MindMap $parent) {
    $this->parent = $parent;
    $parent->getChildren()->add($this);
  }
  
  public function getX()
  {
    return $this->x;
  }
  
  public function setX($newX)
  {
    $this->x = $newX;
  }
  
  public function getY()
  {
    return $this->y;
  }
  
  public function setY($newY)
  {
    $this->y = $newY;
  }
  
  public function isCollapsed()
  {
    return $this->collapsed;
  }
  
  public function SetCollapsed($isCollapsed)
  {
    $this->collapsed = $isCollapsed;
  }
}

?>
