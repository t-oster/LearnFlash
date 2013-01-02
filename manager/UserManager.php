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
    if ($this->getUser($login) != null)
    {
      return "User with login '$login' already exists";
    }
    $u = new \Model\User();
    $u->setEmail($email);
    $u->setLogin($login);
    $u->setName($name);
    $u->setPassword($password);
    $this->entityManager->persist($u);
    $this->entityManager->flush();
    return true;
  }
  public function login($login, $password)
  {
    $u = $this->getUser($login);
    if ($u == null)
    {
      return "Wrong username";
    }
    if ($u->checkPassword($password))
    {
      $_SESSION["login"] = $login;
      $this->currentUser = $u;
      return true;
    }
    return "Wrong password";
  }
  public function logout()
  {
    session_destroy();
  }
  public function getLoggedInUser()
  {
    if ($this->currentUser == null && isset($_SESSION["login"]))
    {
      $this->currentUser = $this->getUser($_SESSION["login"]);
      if ($this->currentUser == null)
      {
        $_SESSION["login"] = null;
      }
    }
    return $this->currentUser;
  }
  public function getUser($login)
  {
    return $this->entityManager->getRepository("Model\User")->findOneBy(array("login" => $login));
  }
}

?>
