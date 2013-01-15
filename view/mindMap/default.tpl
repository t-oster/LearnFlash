{extends file="../main.tpl"}
{block name="head"}
  <link rel="stylesheet" href="css/mindMap.css" />
{/block}
{block name="content"}
<h2>Your Mindmaps</h2>

{foreach $mindmaps as $mm}
  <ul class=mindMapUl>
     <li>({count($mm->getChildren())} elements)</li>
     <li><a href="{url action="show" mindMapId=$mm->getId()}">{$mm->getName()}</a></li>
    
     <li><a class="button" href="{url action="delete" mindMapId=$mm->getId()}">delete</a></li>
  </ul>
{/foreach}
<hr class="line"/>
{include file="./addMindMapForm.tpl"}

<script type="text/javascript">
  function addMindMap(name)
  {
    window.location = "{url action="addMindMap"}&name="+encodeURI(name);
  }
</script>
{/block}