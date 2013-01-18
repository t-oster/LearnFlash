{extends file="../main.tpl"}

{block name="head"}
  <link rel="stylesheet" href="css/cards.css" />
{/block}

{block name="content"}
<h2>Export cards</h2>
<form id="form" target="_blank" action="{url action='doExport'}" method="POST">
  {include file="./../cards/selectCardsFormElements.tpl"}
  <input type="hidden" name="order" value="creation"/>
  <p>
    <label for="format">File format:</label>
    <select name="format">
      <option value="tabs">Tab separated Q/A</option>
      <option value="lines">Line separated Q/A</option>
    </select>
  </p>
  <p>
    <input type="submit" value="Export"/>
  </p>
</form>
{include file="./../cards/selectCardsScript.tpl"}
{/block}