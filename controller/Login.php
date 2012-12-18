<?php
namespace Controller;

/**
 * Description of Login
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class Login extends BaseController{
  
  /**
   *
   * @var Manager\UserManager
   */
  protected $um;
  
  public function __construct() {
    global $userManager;
    $this->um = $userManager;
  }
  
  public function loadDefault($redirect = null)
  {
    $this->assignToView("redirect", $redirect);
  }
  public function loadLogin($login, $password, $redirect = null)
  {
    $result = $this->um->login($login, $password);
    if ($result == true)
    {
      $this->addInfo("Welcome ".$this->um->getLoggedInUser()->getName().".");
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
    $this->um->logout();
    $this->redirect("login");
  }
}

?>
