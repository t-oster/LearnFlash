<?php

namespace Manager;

/**
 * Description of MindMapManager
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class MindMapNodeManager extends BaseManager {
  
  public function getModelClassname() {
    return "Model\MindMapNode";
  }
  
  public function createMindMap($name, $x = 0, $y = 0, $isCollapsed = false, \Model\MindMap $parent = null)
  {
    $m = new \Model\MindMap();
    $m->setOwner($this->um->getLoggedInUser());
    $m->setX($x);
    $m->setY($y);
    if ($parent == null)
    {
      $m->setWidth(1024);
      $m->setHeight(768);
    }
    else
    {
      $m->setWidth(100);
      $m->setHeight(100);
    }
    $m->setCollapsed($isCollapsed);
    $m->setName($name);
    if ($parent != null)
    {
     $m->setParent($parent);
    }
    $this->em->persist($m);
    $this->em->flush();
    return $m;
  }
  
  public function updateNode(\Model\MindMapNode $map, $x, $y, $width, $height, $isCollapsed)
  {
    $map->setX($x);
    $map->setY($y);
    $map->setWidth($width);
    $map->setHeight($height);
    $map->setCollapsed($isCollapsed);
    $this->em->flush();
  }
  
  public function getTopLevelMindMaps(\Model\User $user = null)
  {
    if ($user == null)
    {
      $user = $this->um->getLoggedInUser();
    }
    $result = $this->em->getRepository("\Model\MindMap")->findBy(array(
        "parent" => null,
        "owner" => $user
    ));
    return $result;
  }
  
  public function addCardToMindMap(\Model\MindMap $map, \Model\Card $card, $x = 0, $y = 0, $isCollapsed = true)
  {
    $mc = new \Model\MindMapCard();
    $mc->SetCollapsed($isCollapsed);
    $mc->setCard($card);
    $mc->setX($x);
    $mc->setY($y);
    $mc->setWidth(160);
    $mc->setHeight(100);
    $mc->setParent($map);
    $this->em->persist($mc);
    $this->em->flush();
    return $mc;
  }
}

?>
