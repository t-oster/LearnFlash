<?php
namespace Model;

/**
 * @Entity
 */
class MindMap extends MindMapNode {
  
  /**
   * @Column(type="string")
   * @var String
   */
  protected $name;
  
  /**
   * @OneToMany(targetEntity="MindMapNode", mappedBy="parent", nullable=true)
   **/
  protected $children;
  
  /**
   * @ManyToOne(targetEntity="User", inversedBy="mindMaps")
   * @JoinColumn(name="user_id", referencedColumnName="id")
   * @var User
   */
  protected $owner;
  
  public function __construct() 
  {
     $this->children = new \Doctrine\Common\Collections\ArrayCollection();
  }

  public function getName()
  {
    return $this->name;
  }
  
  public function setName($newName)
  {
    $this->name = $newName;
  }
  
  public function getChildren()
  {
    return $this->children;
  }
  
  public function getOwner()
  {
    return $this->owner;
  }
  
  public function setOwner($newOwner)
  {
    $this->owner = $newOwner;
  }
}

?>
