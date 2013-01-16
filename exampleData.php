<?php

set_time_limit(0);

$um = new Manager\UserManager();
$um->register("Max Mustermann", "max@musterstadt.eu", "test", "test");
$um->login("test", "test");

$cm = new \Manager\CardsManager();

import_dir(__DIR__.'/exampleCards', array());


function import_dir($path, $tags)
{
  global $cm;
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
        $cm->importFile($f, array_merge($tags, array($entry)));
      }
    }
  }
}

$mnm = new Manager\MindMapNodeManager();
$map = $mnm->createMindMap("niceMindMap");
$cards = $cm->getCardsByUser($um->getLoggedInUser());
$x=0;
foreach ($cards as $c){
  if($x++ == 5) break;
  $mnm->addCardToMindMap($map, $c);
}
$a = $mnm->createMindMap("untermap",300,200,false,$map);
$b = $mnm->createMindMap("untermap",600,300,true,$map);
$lm = new Manager\MindMapLinkManager;
$lm->createLink($a, $b, "is an", false, true);

?>
