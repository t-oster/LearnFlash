{extends file="../main.tpl"}
{block name="head"}
  <link rel="stylesheet" href="css/mindMap.css" />
{/block}
{block name="content"}
<h2>Mindmap</h2>
<h3>Here you see an overview of all your mindmap.</h3>

      {foreach $mindmaps as $mm}
        <p><a href="{url action="show" mindMapId=$mm->getId()}">{$mm->getName()}</a><p>
      {/foreach}
      
      {include file="./addMindMapForm.tpl"}

{/block}