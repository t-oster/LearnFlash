{extends file="../main.tpl"}
{block name="content"}
  <form action="{url action="update"}" method="POST">
    <input type="hidden" name="tagId" value="{$tag->getId()}"/>
    <label for="name">Name:</label>
    <input type="text" name="name" value="{$tag->getName()}"/>
    <label for="color">Color:</label>
    <input type="color" name="color" value="{$tag->getColor()}"/>
    <input type="submit" name="Save" value="Save"/>
or <a href="{url action="show" tagId=$tag->getId()}">Cancel</a>
  </form>
{/block}