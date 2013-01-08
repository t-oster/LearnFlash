<?php
namespace Controller;

/**
 * Description of Learn
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class Learn extends BaseCards{
  
  public function loadShow($cardId)
  {
    $card = $this->findCardOrError($cardId);
  }
}

?>
