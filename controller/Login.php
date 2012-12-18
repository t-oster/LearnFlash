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
    $this->assignToView("redirect", $redirect);
  }
  public function loadLogin($login, $password, $redirect = null)
  {
    $result = $this->getUserManager()->login($login, $password);
    if ($result === true && $this->getUserManager()->getLoggedInUser() != null)
    {
      $this->addInfo("Welcome ".$this->getUserManager()->getLoggedInUser()->getName().".");
      if ($redirect == null)
      {
        $this->redirect("Home");
      }
      else
      {
        header("Location: ".$redirect);
        exit;
      }
    }
    else
    {
      $this->addError("Login failed: $result");
      $this->redirect(null, "default", array("redirect" => $redirect));
    }
  }
  public function loadLogout()
  {
    $this->getUserManager()->logout();
    $this->redirect("login");
  }
}

?>
