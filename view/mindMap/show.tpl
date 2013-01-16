{extends file="../main.tpl"}
{block name="head"}
  <script type="text/javascript" src="js/mindMap/show.js"></script>
  <link rel="stylesheet" href="css/mindMap.css"/>
{/block}

{block name="mainContent"}
<h2>{$mindmap->getName()}</h2>
  <a href="javascript:saveChanges();" id="save" class="button">Save</a>{include file="./addMindMapForm.tpl" text="Add Submap"}

  <div id="mindMapContainer">
    <div id="mindMap">
    {foreach $mindmap->getChildren() as $c}    
      {include file="./node.tpl" node=$c nodeId=$c->getId()}
    {/foreach}
    {foreach $links as $l}
      {include file="./linkText.tpl" linkId=$l->getId() link=$l x=($l->getLeftNode()->getX()+$l->getRightNode()->getX())/2 y=($l->getLeftNode()->getY()+$l->getRightNode()->getY())/2}
    {/foreach}
    </div>
  </div>
  
  <script type="text/javascript">
    saveChangesUrl = "{url action="saveChanges" mindMapId=$mindmap->getId()}";
    newNodeUrl ="{url action="node"}";
    newLinkTextUrl = "{url action="linkText"}";
    mindMapLinks = {$linksAsJson};
  </script>
  {include file="./editLinkDialog.tpl"}
{/block}

{block name="sidebar"}
  {include file="./cardList.tpl"}
{/block}
