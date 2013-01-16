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
   * @ManyToOne(targetEntity="MindMap", inversedBy="children")
   **/
  protected $parent;
  
  /** 
   * @Column(type="integer") 
   * @var int
   */
  protected $x;
  
  /** 
   * @Column(type="integer") 
   * @var int
   */
  protected $y;
  
  /** 
   * @Column(type="integer") 
   * @var int
   */
  protected $width;
  
  /** 
   * @Column(type="integer") 
   * @var int
   */
  protected $height;
  
  /** 
   * @Column(type="boolean") 
   * @var boolean
   */
  protected $collapsed;
  
  public function getId(){
    return $this->id;
  }
  
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
  
  public function getWidth() {
    return $this->width;
  }

  public function setWidth($width) {
    $this->width = $width;
  }

  public function getHeight() {
    return $this->height;
  }

  public function setHeight($height) {
    $this->height = $height;
  }
  
  public function isCollapsed()
  {
    return $this->collapsed;
  }
  
  public function setCollapsed($isCollapsed)
  {
    $this->collapsed = $isCollapsed;
  }
  
  public function isMindMapCard()
  {
    return $this instanceof \Model\MindMapCard;
  }
}

?>
