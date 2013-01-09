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
  
  public function createMindMap($name)
  {
    $m = new \Model\MindMap();
    $m->setOwner($this->um->getLoggedInUser());
    $m->setX(0);
    $m->setY(0);
    $m->setCollapsed(FALSE);
    $m->setName($name);
    $this->em->persist($m);
    $this->em->flush();
  }
  
  public function getTopLevelMindMaps(\Model\User $user)
  {
    $result = $this->em->getRepository("\Model\MindMap")->findBy(array(
        "parent" => null,
        "owner" => $user
    ));
    return $result;
  }
  
  public function addCardToMindMap(\Model\MindMap $map, \Model\Card $card, $x = 0, $y = 0, $isCollapsed = false)
  {
    $mc = new \Model\MindMapCard();
    $mc->SetCollapsed($isCollapsed);
    $mc->setCard($card);
  }
}

?>
