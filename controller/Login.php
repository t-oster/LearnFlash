<?php
namespace Controller;

/**
 * Description of Login
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class Login extends BaseController{
    
  public function loadDefault($redirect = null)
  {
    //prevent from redirecting to login itselt
    if ($redirect != null && strpos(strtolower($redirect), "login") > 0)
    {
      $redirect = null;
    }
    $this->assignToView("redirect", urldecode($redirect));
  }
  public function loadLoginAjax($login, $password)
  {
    echo json_encode($this->getUserManager()->login($login, $password));
    $this->dontRender();
  }
  public function loadLogout()
  {
    $this->getUserManager()->logout();
    $this->redirect("login");
  }
}

?>
