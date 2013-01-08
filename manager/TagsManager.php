<?php
namespace Manager;

/**
 * Description of TagsManager
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class TagsManager extends BaseManager
{

  public function findByName(\Model\User $owner, $name)
  {
    $query = $this->em->createQuery('SELECT t FROM \Model\Tag t WHERE LOWER(t.name) = :name and t.owner = :owner');
    $query->setParameter("owner", $owner);
    $query->setParameter("name", strtolower($name));
    return $query->getOneOrNullResult();
  }

  public function getTagsByUser(\Model\User $u)
  {
    return $this->em->getRepository("\Model\Tag")->findBy(array("owner" => $u));
  }

  public function createTag($name, \Model\User $owner, $color)
  {
    $tag = new \Model\Tag();
    $tag->setName($name);
    $tag->setOwner($owner);
    $tag->setColor($color);
    $this->em->persist($tag);
    return $tag;
  }
  
  public function updateTag($tagId, $name, $color)
  {
    $tag = $this->findById($tagId);
    if ($tag == null)
    {
      return "Tag with id $tagId doesn't exist";
    }
    $tag->setName($name);
    $tag->setColor($color);
    $this->em->flush();
    return true;
  }

  public function getModelClassname()
  {
    return "\Model\Tag";
  }
}

?>
