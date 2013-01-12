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
   * @var \Manager\TagsManager
   */
  private $tm;
  
  /**
   * @var \Manager\MindMapLinkManager
   */
  private $lm;
  public function __construct()
  {
    $this->mnm = new \Manager\MindMapNodeManager();
    $this->cm = new \Manager\CardsManager();
    $this->tm = new \Manager\TagsManager();
    $this->lm = new \Manager\MindMapLinkManager();
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
    $links = $this->lm->findByMindMap($currentMindMap);
    $this->assignToView("links", $links);
    $linksArray = array();
    foreach ($links as $l)
    {
      $linksArray [] = array(
        "id" => $l->getId(),
        "leftId" => $l->getLeftNode()->getId(),
        "rightId" => $l->getRightNode()->getId(),
        "state" => "clean",
        "text" => $l->getText(),
        "leftArrow" => $l->isLeftArrow(),
        "rightArrow" => $l->isRightArrow()
      );
    }
    $this->assignToView("linksAsJson", json_encode($linksArray));
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
  
  public function loadNode($cardId = null, $name = null)
  {
    if ($cardId != null)
    {
      $card = $this->cm->findById($cardId);
      $node = new \Model\MindMapCard();
      $node->setCard($card);
    }
    else if ($name != null)
    {
      $node = new \Model\MindMap();
      $node->setName($name);
    }
    $this->assignToView("node",$node);
  }
  
  public function loadSaveChanges($mindMapId, $changesAsJson)
  {
    $errors = array();
    $changes = json_decode($changesAsJson);
    foreach ($changes as $c)
    {
      if ($c->state == "new")
      {
        $parent = $this->mnm->findById($mindMapId);
        if ($c->type == "card")
        {
          $card = $this->cm->findById($c->cardId);
          $this->mnm->addCardToMindMap($parent, $card, $c->x, $c->y, $c->collapsed);
        }
        else if ($c->type == "map")
        {
          $this->mnm->createMindMap($c->name, $c->x, $c->y, $c->collapsed, $parent);
        }
        else if ($c->type == "link")
        {
          //TODO
        }
      }
      else if ($c->state == "updated")
      {
        if ($c->type == "card" || $c->type == "map")
        {
          $node = $this->mnm->findById($c->id);
          $this->mnm->updateNode($node, $c->x, $c->y, $c->collapsed);
        }
        else if ($c->type == "link")
        {
          //TODO
        }
      }
      else if ($c->state == "deleted")
      {
        if ($c->type == "card" || $c->type == "map")
        {
          $this->mnm->deleteById($c->id);
        }
        else if ($c->type == "link")
        {
          $this->lm->deleteById($c->id);
        }
      }
    }
    echo json_encode($errors);
    $this->dontRender();  
  }
}

?>
