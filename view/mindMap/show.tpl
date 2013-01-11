{extends file="../main.tpl"}
{block name="head"}
  <script type="text/javascript" src="js/mindMap/show.js"></script>
  <link rel="stylesheet" href="css/mindMap.css"/>
{/block}

{block name="mainContent"}
<h2>Mindmap</h2>
  Displaying MindMap with name="{$mindmap->getName()}"
  <button id="save">Save</button>
  <div id="mindMap">
    <canvas id="linkLayer" width="800" height="600">
    </canvas>
  {foreach $mindmap->getChildren() as $c}    
    {include file="./node.tpl" node=$c}
  {/foreach}
  </div>
  <script type="text/javascript">
    updateNodesUrl = "{url action="updateNodes"}";
    mindMapLinks = {$linksAsJson};
  </script>
{/block}

{block name="sidebar"}
  {include file="./cardList.tpl"}
{/block}
