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
    $linksMap = array();
    foreach ($links as $l)
    {
      $linksMap["link".$l->getId()] = array(
        "id" => $l->getId(),
        "leftId" => "node".$l->getLeftNode()->getId(),
        "rightId" => "node".$l->getRightNode()->getId(),
        "state" => "clean",
        "text" => $l->getText(),
        "leftArrow" => $l->isLeftArrow(),
        "rightArrow" => $l->isRightArrow()
      );
    }
    $this->assignToView("linksAsJson", json_encode($linksMap));
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
  
  public function loadNode($nodeId, $cardId = null, $name = null)
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
    $this->assignToView("nodeId", $nodeId);
    $this->assignToView("node",$node);
  }
  
  public function loadLinkText($linkId, $text, $x, $y)
  {
    $link = new \Model\MindMapLink();
    $link->setText($text);
    $this->assignToView("linkId", $linkId);
    $this->assignToView("link", $link);
    $this->assignToView("x", $x);
    $this->assignToView("y", $y);
  }
  
  public function loadSaveChanges($mindMapId, $changesAsJson)
  {
    $errors = array();
    //used to map the temporary id of nodes to the new database ids
    $newNodes = array();
    $changes = json_decode($changesAsJson);
    foreach ($changes as $c)
    {
      if ($c->state == "new")
      {
        $parent = $this->mnm->findById($mindMapId);
        if ($c->type == "card")
        {
          $card = $this->cm->findById($c->cardId);
          $nc = $this->mnm->addCardToMindMap($parent, $card, $c->x, $c->y, $c->collapsed);
          $newNodes["node".$c->id] = $nc;
        }
        else if ($c->type == "map")
        {
          $m = $this->mnm->createMindMap($c->name, $c->x, $c->y, $c->collapsed, $parent);
          $newNodes["node".$c->id] = $m;
        }
        else if ($c->type == "link")
        {
          $left = null;
          $right = null;
          $lid = substr($c->leftId, 4);
          if (substr($c->leftId, 4, 1) == "-")
          {//the link refers to a new created node
            $left = $newNodes[$c->leftId];
          }
          else 
          {
            $left = $this->mnm->findById($lid);
          }
          $rid = substr($c->rightId, 4);
          if (substr($c->rightId, 4, 1) == "-")
          {//the link refers to a new created node
            $right = $newNodes[$c->rightId];
          }
          else 
          {
            $right = $this->mnm->findById($rid);
          }
          $this->lm->createLink($left, $right, $c->text, $c->leftArrow, $c->rightArrow);
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
