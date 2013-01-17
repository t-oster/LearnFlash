{extends file="../main.tpl"}
{block name="head"}
  <link rel="stylesheet" href="css/mindMap.css" />
{/block}
{block name="content"}
<h2>Your Mindmaps</h2>
{include file="./addMindMapForm.tpl" text="Add"}
<hr class="line"/>

{foreach $mindmaps as $mm}
  <ul class=mindMapUl>
     <li>{$mm->getName()}<span style="float:right;">({count($mm->getChildren())} elements)</span></li>
     <li><a class="button delete" href="{url action="delete" mindMapId=$mm->getId()}">Delete</a><a class="button edit" href="{url action="show" mindMapId=$mm->getId()}">Open</a></li>
  </ul>
{/foreach}

<script type="text/javascript">
  function addMindMap(name)
  {
    window.location = "{url action="addMindMap"}&name="+encodeURI(name);
  }
</script>
{/block}