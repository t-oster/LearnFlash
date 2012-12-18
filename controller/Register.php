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
    $result = $um->register($name, $email, $login, $password);
    if ($result == true) {
      $this->addInfo("Sucessfully registered. You can now login");
      $this->redirect("Login");
    } else {
      $this->addError("Error. Registering failed: $result");
      $this->redirect();
    }
  }

}

?>
