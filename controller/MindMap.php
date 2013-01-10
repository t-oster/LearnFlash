<?php

namespace Controller;

/**
 * Description of Register
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */

class MindMap extends BaseController {
  
  /**
   * @var \Manager\MindMapNodeManager
   */
  private $mnm;
  
  /**
   * @var \Manager\CardsManager
   */
  private $cm;
  
  /**
   *
   * @var \Manager\TagsManager
   */
  private $tm;
  public function __construct()
  {
    $this->mnm = new \Manager\MindMapNodeManager();
    $this->cm = new \Manager\CardsManager();
    $this->tm = new \Manager\TagsManager();
  }
  
  public function loadDefault(){
    $this->assignToView("mindmaps", $this->mnm->getTopLevelMindMaps());
  }
 
  public function loadShow($mindMapId)
  {
    $currentMindMap = $this->mnm->findById($mindMapId);
    $this->assignToView("mindmap", $currentMindMap);
    $this->assignToView("cards", $this->cm->getCardsByUser());
    $this->assignToView("tags", $this->tm->getTagsByUser());
    //TODO
    $this->assignToView("linksAsJson", "[]");
  }
   
  public function loadCardListBody($tagId = -1)
  {
    $cards = $this->cm->findCards(null, $tagId == -1 ? null : array($tagId));
    $this->assignToView("cards", $cards);
  }
  
  public function loadAddMindMap($name)
  {
    $map = $this->mnm->createMindMap($name);
    $this->addInfo("MindMap ".$name." sucessfully created.");
    $this->redirect(null,"show",array("mindMapId"=>$map->getId()));
  }
  
  public function loadNode($nodeId)
  {
    $node = $this->mnm->findById($nodeId);
    $this->assignToView("node",$node);
  }
  
  public function loadUpdateNodes($ids, $xs, $ys, $collapseds)
  {
    for ($i = 0; $i < count($ids); $i++)
    {
      $node = $this->mnm->findById($ids[$i]);
      $this->mnm->updateNode($node, $xs[$i], $ys[$i], $collapseds[$i]);
    }
    echo "true";
    $this->dontRender();
  }
}

?>
