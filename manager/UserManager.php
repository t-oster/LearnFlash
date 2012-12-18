<?php
namespace Manager;

/**
 * Description of UserManager
 *
 * @author Thomas Oster <thomas.oster@rwth-aachen.de>
 */
class UserManager {
  private $currentUser;
  /**
   *
   * @var Doctrine\ORM\EntityManager
   */
  private $entityManager;
  public function __construct() 
  {
    global $entityManager;
    $this->entityManager = $entityManager;
  }
  
  public function register($name, $email, $login, $password)
  {
    //TODO: create new User and save in the database
    return true;
  }
  public function login($login, $password)
  {
    //TODO get User-Entity from Database and check password
    $_SESSION["login"] = $login;
  }
  public function logout()
  {
    session_destroy();
  }
  public function getLoggedInUser()
  {
    if ($this->currentUser == null && isset($_SESSION["login"]))
    {
      //TODO get User-entity from database and save as currentUser
    }
    return $this->currentUser;
  }
}

?>
