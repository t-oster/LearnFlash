<?php

namespace Manager;

/**
 * Description of MindMapLinkManager
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class MindMapLinkManager extends BaseManager {

  public function getModelClassname() {
    return "\Model\MindMapLink";
  }
  
  public function createLink(\Model\MindMapNode $left, \Model\MindMapNode $right, $text = "", $leftArrow = false, $rightArrow = false)
  {
    $link = new \Model\MindMapLink();
    $this->em->persist($link);
    $this->updateLink($link, $left, $right, $text, $leftArrow, $rightArrow);
  }
  
  public function updateLink(\Model\MindMapLink $link, \Model\MindMapNode $left = null, \Model\MindMapNode $right = null, $text = null, $leftArrow = null, $rightArrow = null)
  {
    if ($left !== null) $link->setLeftNode($left);
    if ($right !== null) $link->setRightNode($right);
    if ($leftArrow !== null) $link->setLeftArrow($leftArrow);
    if ($rightArrow !== null) $link->setRightArrow($rightArrow);
    if ($text !== null) $link->setText($text);
    $this->em->flush();
  }

  public function findByMindMap(\Model\MindMap $currentMindMap)
  {
    //TODO
    //
    //$q = $this->em->cr
    return $this->em->getRepository($this->getModelClassname())->findAll();
  }
}

?>
