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
    $this->assignToView("redirect", $redirect);
  }
  public function loadLogin($login, $password, $redirect = null)
  {
    $um = new \Manager\UserManager();
    if ($um->login($login, $password))
    {
      $this->addInfo("Welcome ".$um->getLoggedInUser()->getName().".");
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
      $this->addError("Login failed");
      $this->redirect(null, "default", array("redirect" => $redirect));
    }
  }
}

?>
