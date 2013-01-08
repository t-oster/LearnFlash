<?php
namespace Controller;

/**
 * Description of Learn
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class Learn extends BaseCards{
  
  public function loadDefault()
  {
    $tm = new \Manager\TagsManager();
    $tags = $tm->getTagsByUser($this->getUserManager()->getLoggedInUser());
    $this->assignToView("tags", $tags);
  }
  
  public function loadPrepareLearning($selection = "all", $tagIds = null, $random = false, $unlearned = false, $ajax)
  {
    //TODO select cards by given criteria
    //save IDs in session
    $cards = $this->cm->getCardsByUser($this->getUserManager()->getLoggedInUser());
    $_SESSION["toLearn"] = array();
    $count_unlearned = 0;
    $count = 0;
    foreach ($cards as $c)
    {
      $_SESSION["toLearn"] []= $c->getId();
      $count++;
      if (true) //TODO: if card is not learned aka no answer exists
      {
        $count_unlearned++;
      }
    }
    if ($ajax)
    {
      echo json_encode(array("all" => $count, "unlearned" => $count_unlearned));
      $this->dontRender();
    }
    else
    {
      $this->redirect(null, "next");
    }
  }
  
  public function loadNext($cardId = null, $result = null)
  {
    if ($cardId != null && $result != null)
    {
      //TODO save answer for first card
      //remove first card
      echo "Result: $result";
    }
    if (count($_SESSION["toLearn"]) <= 0)
    {
      $this->redirect();
      return;
    }
    $card = $this->findCardOrError(array_pop($_SESSION["toLearn"]));
    $this->assignToView("card", $card);
    $this->assignToView("frontHtml", $this->replaceReferencesWithLinks($card->getFrontHtml()));
    $this->assignToView("backHtml", $this->replaceReferencesWithLinks($card->getBackHtml()));
  }
}

?>
