{extends file="../main.tpl"}
{block name="mainContent"}
<h2>Mindmap</h2>
  Displaying MindMap with name="{$mindmap->getName()}"
  <div id="mindMap" style="position: relative">
  {foreach $mindmap->getChildren() as $c}
    
    {include file="./node.tpl" node=$c}

    <br/>
  {/foreach}
  </div>
{/block}

{block name="sidebar"}

  {include file="./cardList.tpl"}

{/block}
