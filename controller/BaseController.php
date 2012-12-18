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
  
  private $doRender = true;

  /**
   * This function loads the entityManager and smarty into the object
   */
  public function load()
  {
    global $entityManager;
    global $smarty;
    $this->em = $entityManager;
    $this->smarty = $smarty;
  }
  public function getEntityManager()
  {
    return $this->em;
  }
  
  public function assignToView($name, $object)
  {
    $this->smarty->assign($name, $object);
  }
  
  public function render($action)
  {
    if ($this->doRender)
    {
      $parts = explode("\\", get_class($this));
      $templateFile = "view/".lcfirst($parts[count($parts)-1])."/".lcfirst($action).".tpl";
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
  
  public function redirect($controller, $action, $params)
  {
    $redirecturl = "index.php?controller=$controller&action=$action";
    foreach ($params as $key=>$value)
    {
      $redirecturl .= "&$key=$value";
    }
    header("Location: $redirecturl");
    $this->dontRender();
  }
}

?>
