<?php
namespace Controller;
/**
 * Description of Register
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class Register extends BaseController
{
  public function loadDefault()
  {
    $this->assignToView("world", "World!!");
  }
}

?>
