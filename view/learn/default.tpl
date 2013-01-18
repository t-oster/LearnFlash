{extends file="../main.tpl"}
{block name="content"}
<h2>Which Cards do you want to learn?</h2>
<form id="form" action="{url action="prepareLearning"}" method="POST">
  {include file="./../cards/selectCardsFormElements.tpl"}
<label for="order">Order:</label>
<select class="updateInfo" name="order">
  <option value="random">random order</option>
  <option value="creation">creation order</option>
  <option value="average" selected="selected">average result</option>
  <option value="last">last result</option>
  <option value="sm2">SM2-Algorithm</option>
</select>
<input id="go" type="submit" value="Start Learning"/>
</form>
{include file="./../cards/selectCardsScript.tpl"}
{/block}