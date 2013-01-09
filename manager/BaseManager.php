<?php
namespace Manager;

/**
 * Description of BaseManager
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
abstract class BaseManager
{
  abstract function getModelClassname();

  /**
   *
   * @var \Doctrine\ORM\EntityManager
   */
  protected $em;
  
  /**
   *
   * @var Manager\UserManager
   */
  protected $um;

  public function __construct()
  {
    global $entityManager;
    $this->em = $entityManager;
    $this->um = new \Manager\UserManager();
  }

  public function findById($id)
  {
    return $this->em->getRepository($this->getModelClassname())->find($id);
  }

  public function deleteById($id)
  {
    $c = $this->findById($id);
    if ($c == null)
    {
      return $this->getModelClassname()." with id $id does not exist";
    }
    else
    {
      $this->em->remove($c);
      $this->em->flush();
      return true;
    }
  }
}

?>
