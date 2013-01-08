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
  
  public function loadPrepareLearning($all = false, $byTag = false, $tagIds = array(), $random = false, $unlearned = false)
  {
    //TODO select cards by given criteria
    //save IDs in session
    $cards = $this->cm->getCardsByUser($this->getUserManager()->getLoggedInUser());
    $_SESSION["toLearn"] = array();
    foreach ($cards as $c)
    {
      $_SESSION["toLearn"] []= $c->getId();
    }
    $this->redirect(null, "next");
  }
  
  public function loadNext()
  {
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
