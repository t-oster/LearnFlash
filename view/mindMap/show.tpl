{extends file="../main.tpl"}
{block name="head"}
  <script type="text/javascript" src="js/mindMap/show.js"></script>
  <link rel="stylesheet" href="css/mindMap.css"/>
{/block}

{block name="mainContent"}
<h2>Mindmap</h2>
  Displaying MindMap with name="{$mindmap->getName()}"
  
  <button id="save" class="button">Save</button>{include file="./addMindMapForm.tpl"}
  <div id="mindMap">
    <canvas id="linkLayer">
    </canvas>
  {foreach $mindmap->getChildren() as $c}    
    {include file="./node.tpl" node=$c nodeId=$c->getId()}
  {/foreach}
  {foreach $links as $l}
    {include file="./linkText.tpl" linkId=$l->getId() link=$l x=($l->getLeftNode()->getX()+$l->getRightNode()->getX())/2 y=($l->getLeftNode()->getY()+$l->getRightNode()->getY())/2}
  {/foreach}
  </div>
  <script type="text/javascript">
    saveChangesUrl = "{url action="saveChanges" mindMapId=$mindmap->getId()}";
    newNodeUrl ="{url action="node"}";
    newLinkTextUrl = "{url action="linkText"}";
    mindMapLinks = {$linksAsJson};
  </script>
{/block}

{block name="sidebar"}
  {include file="./cardList.tpl"}
{/block}
