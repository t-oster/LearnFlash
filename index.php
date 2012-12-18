<?php
require 'bootstrap.php';
$controller = isset($_GET["controller"]) ? $_GET["controller"] : "login";
$action = isset($_GET["action"]) ? $_GET["action"] : "default";

$controllerClass = "Controller\\".ucfirst($controller);
$actionMethod = "load".ucfirst($action);

if (!class_exists($controllerClass))
{
  echo "Error: No such class: ".$controllerClass;
  exit;
}
$controllerInstance = new $controllerClass();
$controllerInstance->load();
if (method_exists($controllerInstance, $actionMethod))
{
  $controllerInstance->$actionMethod();
}
$controllerInstance->render($action);