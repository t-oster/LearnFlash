<?php

namespace Controller;

/**
 * Description of Register
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class Register extends BaseController {

  public function loadRegister($name, $email, $login, $password) {
    $um = new \Manager\UserManager();
    if ($um->register($name, $email, $login, $password)) {
      $this->addInfo("Sucessfully registered. You can now login");
      $this->redirect("Login");
    } else {
      $this->addError("Error. Registering failed");
      $this->redirect();
    }
  }

}

?>
