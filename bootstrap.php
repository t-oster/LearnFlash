<?php
//initialize autoloader
spl_autoload_register (function ($classname){
  $file = lcfirst(str_replace("\\", "/", $classname)).".php";
  if (is_file($file))
  {
    include $file;
    return true;
  }
  return false;
});

//initialize smarty
require('lib/php/Smarty-3.1.12/libs/Smarty.class.php');
$smarty = new Smarty();
$smarty->setCacheDir("tmp");
$smarty->setCompileDir("tmp");

//initialize doctrine
date_default_timezone_set("Europe/Berlin");
// Setup Autoloader (1)
require 'lib/php/DoctrineORM-2.3.0/Doctrine/ORM/Tools/Setup.php';
Doctrine\ORM\Tools\Setup::registerAutoloadDirectory("lib/php/DoctrineORM-2.3.0");
$config = new Doctrine\ORM\Configuration(); // (2)
// Proxy Configuration (3)
$config->setProxyDir(__DIR__.'/tmp');
$config->setProxyNamespace('tmp');
$config->setAutoGenerateProxyClasses(true);
// Mapping Configuration (4)
$driverImpl = $config->newDefaultAnnotationDriver(__DIR__."/model");
$config->setMetadataDriverImpl($driverImpl);
// Caching Configuration (5)
$cache = new \Doctrine\Common\Cache\ArrayCache();
$config->setMetadataCacheImpl($cache);
$config->setQueryCacheImpl($cache);
// database configuration parameters (6)
$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/tmp/db.sqlite',
    'driverOptions' => array(1002=>'SET NAMES utf8')
);
// obtaining the entity manager (7)
$evm = new Doctrine\Common\EventManager();
$entityManager = \Doctrine\ORM\EntityManager::create($conn, $config, $evm);
// check if the database exists
if (!is_file($conn["path"]))
{
  if (!is_dir(dirname($conn["path"])))
  {
    mkdir(dirname($conn["path"]));
  }
  $tool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
  //find all classes in entities
  $dir = opendir(__DIR__.'/model');
  $classes = array();
  while (false !== ($entry = readdir($dir)))
  {
      if (strlen($entry) > 4 && substr($entry, -4) == ".php")
      {
        $className = 'Model\\'.substr($entry, 0, strlen($entry)-4);
        $classes []= $entityManager->getClassMetadata($className);
      }
  }
  $tool->createSchema($classes);
  $validator = new \Doctrine\ORM\Tools\SchemaValidator($entityManager);
  $errors = $validator->validateMapping();
  if (count($errors) > 0) {
    foreach($errors as $e)
    {
      // Lots of errors!
      echo implode("\n\n", $e);
    }
    unlink("tmp/db.sqlite");
    exit;
  }
  include "exampleData.php";
}
?>
