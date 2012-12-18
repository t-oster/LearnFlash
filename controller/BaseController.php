<?php
namespace Controller;
/**
 * Description of BaseController
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class BaseController 
{
  /**
   *
   * @var Doctrine\ORM\EntityManager
   */
  private $em;
  /**
   *
   * @var Smarty
   */
  private $smarty;
  /**
   *
   * @var Manager\UserManager
   */
  private $um;
  
  private $doRender = true;

  /**
   * This function loads the entityManager and smarty into the object
   */
  public function load()
  {
    global $entityManager;
    global $userManager;
    global $smarty;
    $this->em = $entityManager;
    $this->um = $userManager;
    $this->smarty = $smarty;
  }
  public function getEntityManager()
  {
    return $this->em;
  }
  public function getUserManager()
  {
    return $this->um;
  }
  
  public function assignToView($name, $object)
  {
    $this->smarty->assign($name, $object);
  }
  
  private function getControllerName()
  {
    $parts = explode("\\", get_class($this));
    return lcfirst($parts[count($parts)-1]);
  }
  
  public function render($action)
  {
    if ($this->doRender)
    {
      $templateFile = "view/".$this->getControllerName()."/".lcfirst($action).".tpl";
      if (!is_file($templateFile))
      {
        echo "Error: No such file: $templateFile";
        exit;
      }
      $this->smarty->display($templateFile);
    }
  }
  
  public function dontRender()
  {
    $this->doRender = false;
  }
  
  public function redirect($controller = null, $action = "default", $params = null)
  {
    if ($controller == null)
    {
      $controller = $this->getControllerName();
    }
    $redirecturl = generate_url($controller, $action, $params);
    header("Location: $redirecturl");
    $this->dontRender();
  }
  
  public function addInfo($message)
  {
    if (!isset($_SESSION["info"]))
    {
      $_SESSION["info"] = array();
    }
    $_SESSION["info"][] = $message;
  }
  
  public function addError($message)
  {
    if (!isset($_SESSION["error"]))
    {
      $_SESSION["error"] = array();
    }
    $_SESSION["error"][] = $message;
  }
}

?>
