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
   * @ManyToMany(targetEntity="MindMapNode")
   * @JoinTable(name="mindMap_mindMapNodes",
   *      joinColumns={@JoinColumn(name="mindMapNode_id", referencedColumnName="id")},
   *      inverseJoinColumns={@JoinColumn(name="mindMap_id", referencedColumnName="id", unique=true)}
   *      )
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
