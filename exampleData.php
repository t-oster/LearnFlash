<?php

set_time_limit(0);

$um = new Manager\UserManager();
$um->register("Max Mustermann", "max@musterstadt.eu", "test", "test");
$um->login("test", "test");

$cm = new \Manager\CardsManager();

import_dir(__DIR__.'/exampleCards', array());

function import_file($path, $tags)
{
  global $cm, $um;
  $f = fopen($path, "r");
  while(!feof($f))
  {
    $line = fgets($f);
    $qa = explode("\t", $line);
    if (!isset($qa[0]) || !isset($qa[1]) || $qa[0] == "" || $qa[1] == "")
    {
      continue;
    }
    $cm->createCard($um->getLoggedInUser(), "", $qa[0], $qa[1], $tags);
  }
  fclose($f);
}

function import_dir($path, $tags)
{
  $dir = opendir($path);
  while (false !== ($entry = readdir($dir)))
  {
    $f = $path."/".$entry;
    if (strlen($entry) > 2)
    {
      if (is_dir($f))
      {
        import_dir($f, array_merge($tags, array($entry)));
      }
      else if (is_file($f))
      {
        import_file($f, array_merge($tags, array($entry)));
      }
    }
  }
}

$mnm = new Manager\MindMapNodeManager();
$map = $mnm->createMindMap("niceMindMap");
$cards = $cm->getCardsByUser($um->getLoggedInUser());
foreach ($cards as $c){
  $mnm->addCardToMindMap($map, $c);
}

?>
