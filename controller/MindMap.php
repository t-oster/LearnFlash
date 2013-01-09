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
    $this->assignToView("mindmap", $this->mnm->findById($mindMapId));
  }
          
  
/*  public function loadRegister($name, $email, $login, $password) {
    $result = $this->getUserManager()->register($name, $email, $login, $password);
    if ($result === true) {
      $this->addInfo("Sucessfully registered. You can now login");
      $this->redirect("Login");
    } else {
      $this->addError("Error. Registering failed: $result");
      $this->redirect();
    }
  }*/

}

?>
