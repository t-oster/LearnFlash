<?php
namespace Controller;

/**
 * Description of Learn
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class Learn extends BaseCards{
  
  public function loadDefault($ignoreSession = false, $tag = null)
  {
    if (!$ignoreSession && isset($_SESSION["toLearn"]) && count($_SESSION["toLearn"]) > 0)
    {
      $this->redirect(null, "continueQuestion", array("tag" => $tag));
      return;
    }
    $tm = new \Manager\TagsManager();
    $tags = $tm->getTagsByUser($this->getUserManager()->getLoggedInUser());
    $this->assignToView("tags", $tags);
    $this->assignToView("tag", $tag);
  }
  
  public function loadContinueQuestion($tag = null)
  {
    $this->assignToView("tag", $tag);
  }
  
  public function loadCountSelection($selection = "all", $tagIds = null, $order = "creation", $unlearned = false)
  {
    $cards = $this->cm->findCards(null, $selection == "all" ? null : $tagIds, $unlearned);
    $count_unlearned = 0;
    $now = new \DateTime();
    $count = 0;
    foreach ($cards as $c)
    {
      if ($order == "sm2")
      {
        if ($c->getLastAnswered() != null)
        {
          $diffInDays = $now->diff($c->getLastAnswered())->format("%a");
          $interval= ceil($this->sm2RepetitionInterval($c->getRepetitions(),$c->getEasiness()));
          if ($diffInDays < $interval)//TODO CHECK IF IN INTERVAL)
          {
            continue;
          }
        }
      }
      $count++;
      if ($c->isUnlearned())
      {
        $count_unlearned++;
      }
    }
    echo json_encode(array("all" => $count, "unlearned" => $count_unlearned));
    $this->dontRender();
  }
  
  private function sm2RepetitionInterval($n, $e)
  {
    if($n==0)return 0;
    if($n==1)return 1;     
    if($n==2)return 6;
    if($n>2) return $this->sm2RepetitionInterval($n-1)*$e;     
  }
  
  public function loadPrepareLearning($selection = "all", $tagIds = null, $order = "creation", $unlearned = false)
  {
    $cards = $this->cm->findCards(null, $selection == "all" ? null : $tagIds, $unlearned);
    $_SESSION["usesm2"]=false;
    if ($order == "random")
    {
      shuffle($cards);
    }
    else if ($order == "average")
    {
      usort($cards, function($c1, $c2){return $c1->getAverageResult() <= $c2->getAverageResult() ? -1 : 1;});
    }
    else if ($order == "last")
    {
      usort($cards, function($c1, $c2){return $c1->getLastResult() <= $c2->getLastResult() ? -1 : 1;});
    }
    else if ($order == "sm2")
    {
      $_SESSION["usesm2"]=true;
      $result=array();
      $now = new \DateTime();
      foreach ($cards as $c)
      {
        if ($c->getLastAnswered() == null)
        {
          $result []= $c;
          continue;
        }
        $diffInDays = $now->diff($c->getLastAnswered())->format("%a");
        $interval= ceil($this->sm2RepetitionInterval($c->getRepetitions(),$c->getEasiness()));
        if ($diffInDays >= $interval)//TODO CHECK IF IN INTERVAL)
        {
          $result []= $c;
        }
      }
      $cards = $result;
    }
    $_SESSION["toLearn"] = array();
    foreach ($cards as $c)
    {
      $_SESSION["toLearn"] []= $c->getId();
    }
    $this->redirect(null, "next");
  }
  
  public function loadNext($cardId = null, $result = null, $ajax = false)
  {
    if ($cardId != null && $result != null)
    {
      if($_SESSION["usesm2"]==false)
      {
        $this->cm->cardAnswered($cardId, $result);
        $_SESSION["toLearn"] = array_slice($_SESSION["toLearn"], 1);
      }
      else 
      {
        $this->cm->cardAnsweredsm2($cardId, $result);
        $_SESSION["toLearn"] = array_slice($_SESSION["toLearn"], 1);
        if($result<4)
        {
          $_SESSION["toLearn"] []=$cardId;
        }    
      }
    }
    if (count($_SESSION["toLearn"]) <= 0)
    {
      if ($ajax)
      {
        echo json_encode("end");
        $this->dontRender();
        return;
      }
      else
      {
        $this->redirect();
        return;
      }
    }
    $card = $this->findCardOrError($_SESSION["toLearn"][0]);
    if ($ajax)
    {
      echo json_encode(array(
          "title" => $card->getTitle(),
          "cardId" => $card->getId(),
          "cardsLeft" => count($_SESSION["toLearn"]),
          "frontHtml" => $this->replaceReferencesWithLinks($card->getFrontHtml()),
          "backHtml" => $this->replaceReferencesWithLinks($card->getBackHtml())
      ));
      $this->dontRender();
    }
    else 
    {
      $this->assignToView("card", $card);
      $this->assignToView("frontHtml", $this->replaceReferencesWithLinks($card->getFrontHtml()));
      $this->assignToView("backHtml", $this->replaceReferencesWithLinks($card->getBackHtml()));
    }
  }
}

?>
