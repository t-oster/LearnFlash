<?php
require 'bootstrap.php';

function generate_url($controller, $action = "default", $params = null)
{
  $redirecturl = "index.php?controller=$controller&action=$action";
  if ($params != null)
  {
    foreach ($params as $key=>$value)
    {
      $redirecturl .= "&$key=$value";
    }
  }
  return $redirecturl;
}

$controller = isset($_GET["controller"]) ? $_GET["controller"] : "login";
$action = isset($_GET["action"]) ? $_GET["action"] : "default";

//plugin for the smarty {url} tag
$smarty->registerPlugin("function","url", "smarty_url_tag");
function smarty_url_tag($params, $smarty)
{
  global $controller;
  $ctrl = empty($params["controller"]) ? $controller : $params["controller"];
  $act = empty($params["action"]) ? "default" : $params["action"];
  $pars = array();
  foreach ($params as $key=>$value)
  {
    if ($key != "controller" && $key != "action")
    {
      $pars[$key] = $value;
    }
  }
  return generate_url($ctrl, $act, $pars);
}

$smarty->registerPlugin("function","clear_errors", "smarty_clear_errors_tag");
function smarty_clear_errors_tag($params, $smarty)
{
  unset($_SESSION["error"]);
}

$smarty->registerPlugin("function","clear_infos", "smarty_clear_infos_tag");
function smarty_clear_infos_tag($params, $smarty)
{
  unset($_SESSION["info"]);
}

$controllerClass = "Controller\\".ucfirst($controller);
$actionMethod = "load".ucfirst($action);

if (!class_exists($controllerClass))
{
  echo "Error: No such class: ".$controllerClass;
  exit;
}

session_start();

$userManager = new Manager\UserManager();
if ($userManager->getLoggedInUser() == null && $controller != "login" && $controller != "register")
{
  header("Location: ".generate_url("login", "default", array("redirect" => $_SERVER["REQUEST_URI"])));
  exit;
}
$controllerInstance = new $controllerClass();
$controllerInstance->load();
if (method_exists($controllerInstance, $actionMethod))
{
  //fill all action parameters with GET/POST parameters
  $r = new ReflectionMethod($controllerClass, $actionMethod);
  $pars = array();
  $params = $r->getParameters();
  foreach ($params as $param) {
      $name = $param->getName();
      if (isset($_POST[$name]))
      {
        $pars[$name] = $_POST[$name];
      }
      else if (isset($_GET[$name]))
      {
        $pars[$name] = $_GET[$name];
      }
      else if ($param->isOptional())
      {
        $pars[$name] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
      }
      else
      {
        echo "Error: The Method $controllerClass -> $actionName() needs the parameter $name, which is neither in GET nor in POST";
        exit;
      }
  }
  call_user_method_array($actionMethod, $controllerInstance, $pars);
}
$controllerInstance->render($action);