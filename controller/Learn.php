<?php
namespace Controller;

/**
 * Description of Learn
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class Learn extends BaseCards{
  
  public function loadDefault($ignoreSession = false)
  {
    if (!$ignoreSession && isset($_SESSION["toLearn"]) && count($_SESSION["toLearn"]) > 0)
    {
      $this->redirect(null, "continueQuestion");
      return;
    }
    $tm = new \Manager\TagsManager();
    $tags = $tm->getTagsByUser($this->getUserManager()->getLoggedInUser());
    $this->assignToView("tags", $tags);
  }
  
  public function loadCountSelection($selection = "all", $tagIds = null, $order = "creation", $unlearned = false)
  {
    $cards = $this->cm->findCards(null, $selection == "all" ? null : $tagIds, $unlearned);
    $count_unlearned = 0;
    $count = 0;
    foreach ($cards as $c)
    {
      $count++;
      if ($c->getCountAnswers() == 0)
      {
        $count_unlearned++;
      }
    }
    echo json_encode(array("all" => $count, "unlearned" => $count_unlearned));
    $this->dontRender();
  }
  
  public function loadPrepareLearning($selection = "all", $tagIds = null, $order = "creation", $unlearned = false)
  {
    $cards = $this->cm->findCards(null, $selection == "all" ? null : $tagIds, $unlearned);
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
      //TODO filter only cards which belong to the current time slot
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
      $this->cm->cardAnswered($cardId, $result);
      $_SESSION["toLearn"] = array_slice($_SESSION["toLearn"], 1);
    }
    if (count($_SESSION["toLearn"]) <= 0)
    {
      $this->redirect();
      return;
    }
    $card = $this->findCardOrError($_SESSION["toLearn"][0]);
    if ($ajax)
    {
      echo json_encode(array(
          "title" => $card->getTitle(),
          "cardId" => $card->getId(),
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
