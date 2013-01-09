<?php

namespace Manager;

/**
 * Description of AnswerManager
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class AnswerManager extends BaseManager {
  
  public function getModelClassname() {
   return "Model\Answer"; 
  }

  public function create(\Model\User $u, \Model\Card $c, $rating)
  {
    $a = new \Model\Answer();
    $a->setCard($c);
    $a->setOwner($u);
    $a->setRating($rating);
    $a->setTimestamp(time());
    $this->em->persist($a);
    $this->em->flush();
  }
}

?>
