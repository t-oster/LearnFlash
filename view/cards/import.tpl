{extends file="../main.tpl"}

{block name="head"}
  <link rel="stylesheet" href="css/cards.css" />
{/block}

{block name="content"}
<h2>Import cards from file</h2>
<form enctype="multipart/form-data" action="{url action="doImport"}" method="POST"">
    <p>
      <label for="format">File format:</label>
      <select name="format">
        <option value="tabs">Tab separated Q/A</option>
        <option value="lines">Line separated Q/A</option>
      </select>
    </p>
    <p>
      <label for="file">File:</label>
      <input type="file" name="file"/>
    </p>
    <p>
      {include file="./../tags/tagInputField.tpl" tags=$tags value=""}
    </p>
    <p>
      <input type="submit" value="Import"/>
    </p>
</form>
{/block}