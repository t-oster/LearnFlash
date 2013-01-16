<?php
namespace Manager;
/**
 * Description of CardsManager
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class CardsManager extends BaseManager{
  
  public function importFile($path, $tags, $format = "tabs")
  {
    $f = fopen($path, "r");
    $i = 0;
    $count = 0;
    while(!feof($f))
    {
      $line = fgets($f);
      if ($format == "tabs")
      {
        $qa = explode("\t", $line);
      }
      else if ($format == "lines")
      {
        $qa[$i] = $line;
        $i = 1-$i;
        if ($i == 0)
        {
          continue;
        }
      }
      else
      {
        throw new \Exception("Unknown format '$format'");
      }
      if (!isset($qa[0]) || !isset($qa[1]) || $qa[0] == "" || $qa[1] == "")
      {
        continue;
      }
      $this->createCard(null, "", $qa[0], $qa[1], $tags);
      $count++;
    }
    fclose($f);
    return $count;
  }
  
  public function setTags(\Model\Card $c, array $itags)
  {
    //remove all empty tags, create 2 arrays
    //containing trimmed tag and lower-case trimmed tag
    $ltags = array();
    $tags = array();
    foreach ($itags as $t)
    {
      $t = trim($t);
      if ($t != "")
      {
        $ltags []= strtolower($t);
        $tags [] = $t;
      }
    }
    $this->em->beginTransaction();
    //find all tags, which have to be removed
    $toRemove = array();
    foreach ($c->getTags() as $t)
    {
      if (!in_array(strtolower($t->getName()), $ltags))
      {
        $toRemove []= $t;
      }
    }
    foreach ($toRemove as $t)
    {
      $c->removeTag($t);
    }
    //find all tags which have to be added
    $newtags = array();
    foreach ($tags as $t)
    {
      foreach ($c->getTags() as $tt)
      {
        if (strtolower($tt->getName()) == strtolower($t))
        {
          continue 2;
        }
      }
      //not found
      $newtags []= $t;
    }
    $tm = new TagsManager();
    foreach ($newtags as $t)
    {
      //try to find existing tag
      $tag = $tm->findByName(strtolower($t));
      if ($tag == null)
      {
        $tag = $tm->createTag($t, "#00ff00");
      }
      $c->addTag($tag);
    }
    $this->em->flush();
    $this->em->commit();
  }

  public function createCard(\Model\User $owner = null, $title, $frontHtml, $backHtml, $tags = null)
  {
    if ($owner == null)
    {
      $owner = $this->um->getLoggedInUser();
    }
    $this->em->beginTransaction();
    $c = new \Model\Card();
    $c->setOwner($owner);
    $owner->getCards()->add($c);
    $c->setTitle($title);
    $c->setFrontHtml($frontHtml);
    $c->setBackHtml($backHtml);
    $this->em->persist($c);
    $this->em->flush();
    if ($c->getTitle() == "")
    {
      $c->setTitle("#".$c->getId());
    }
    if ($tags != null)
    {
      $this->setTags($c, $tags); 
    }
    $this->em->flush();
    $this->em->commit();
    return $c;
  }
  
  public function updateCard($cardId, $title, $frontHtml, $backHtml, $tags = null)
  {
    $c = $this->findById($cardId);
    $c->setTitle($title);
    $c->setFrontHtml($frontHtml);
    $c->setBackHtml($backHtml);
    if ($tags != null)
    {
      $this->setTags($c, $tags);
    }
    $this->em->flush();
    return $c;
  }
  
  /**
   * Update a card with a regular answer, result is 1-4
   * @param type $cardId
   * @param type $result
   */
  public function cardAnswered($cardId, $result)
  {
    $c = $this->findById($cardId);
    $c->addResult($result);
    $this->em->flush();
    return $c;
  }
  
  public function cardAnsweredSm2($cardId, $q)
  {
    $c = $this->findById($cardId);
    $c->addSm2Result($q);
    $this->em->flush();
    return $c;   
  }

  public function findCards(\Model\User $u = null, $tagIds = null, $unlearned = false)
  {
    if ($u == null)
    {
      $u = $this->um->getLoggedInUser();
    }
    //TODO make more efficient with DQL query
    $cards = $this->getCardsByUser($u);
    $result = array();
    foreach ($cards as $c)
    {
      if ($tagIds != null)
      {
        $found = false;
        foreach ($c->getTags() as $t)
        {
          if (in_array($t->getId(), $tagIds))
          {
            $found = true;
          }
        }
        if (!$found)
        {
          continue;
        }
      }
      if ($unlearned == true && $c->getCountAnswers() != 0)
      {
        continue;
      }
      $result []= $c;
    }
    return $result;
  }
  
  public function findByTitle($title)
  {
    return $this->em->getRepository("\Model\Card")->findOneBy(array("title" => $title));
  }

  public function getCardsByUser(\Model\User $u = null)
  {
    if ($u == null)
    {
      $u = $this->um->getLoggedInUser();
    }
    return $this->em->getRepository("\Model\Card")->findBy(array("owner" => $u));
  }

  public function getModelClassname()
  {
    return "\Model\Card";
  }

  public function deleteById($id)
  {
    $c = $this->findById($id);
    foreach ($c->getTags() as $t)
    {
      $c->removeTag($t);
    }
    $this->em->flush();
    return parent::deleteById($id);
  }
}

?>
