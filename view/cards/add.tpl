{extends file="../main.tpl"}
{block name="content"}
<form action="{url action="create"}" method="POST">
  <label for="title">Title</label>
  <input type="text" id="title" name="title"/>
  <label for="frontHtml">Front</label>
  <textarea id="frontHtml" name="frontHtml"></textarea>
  <label for="backHtml">Back</label>
  <textarea id="backHtml" name="backHtml"></textarea>
  <input type="submit" value="Create"/>
  or <a href="{url}">Cancel</a>
</form>
{/block}