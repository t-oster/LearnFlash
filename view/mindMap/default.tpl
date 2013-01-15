{extends file="../main.tpl"}
{block name="head"}
  <link rel="stylesheet" href="css/mindMap.css" />
{/block}
{block name="content"}
<h2>Your Mindmaps</h2>

{foreach $mindmaps as $mm}
  <p><a href="{url action="show" mindMapId=$mm->getId()}">{$mm->getName()}</a> ({count($mm->getChildren())} elements)
    <a href="{url action="delete" mindMapId=$mm->getId()}">delete</a>
  <p>
{/foreach}

{include file="./addMindMapForm.tpl"}

<script type="text/javascript">
  function addMindMap(name)
  {
    window.location = "{url action="addMindMap"}&name="+encodeURI(name);
  }
</script>
{/block}