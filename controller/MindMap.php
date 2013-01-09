<?php

namespace Controller;

/**
 * Description of Register
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */

class MindMap extends BaseController {
  
  /*
   * @var \Manager\MindMapNodeManager
   * @var \Model\MindMap
   */
  private $mnm;
  public function __construct()
  {
    $this->mnm = new \Manager\MindMapNodeManager();
  }
  
  public function loadDefault(){
    $u = $this->getUserManager()->getLoggedInUser();
    $this->assignToView("mindmaps", $this->mnm->getTopLevelMindMaps($u));
  }
 
  public function loadShow($mindMapId)
  {
    $currentMindMap = $this->mnm->findById($mindMapId);
    //$this->assignToView("mindmap", $this->mnm->findById($mindMapId));
    $this->assignToView("mindmap", $currentMindMap);
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
  
  public function loadUpdate($nodeId, $x, $y, $isCollapsed)
  {
    $node = $this->mnm->findById($nodeId);
    $this->mnm->updateNode($map, $x, $y, $isCollapsed);
  }
}

?>
