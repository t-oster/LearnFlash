{extends file="../main.tpl"}
{block name="content"}
<h1>{$card->getTitle()}</h1>
<div id="frontSide">
  {$frontHtml}
</div>
<div id="backSide" style="display: none;">
  {$backHtml}
</div>
<button id="show">Show answer</button>
<form action="{url action="next"}" method="POST" id="result" style="display: none;">
  <input type="hidden" name="cardId" value="{$card->getId()}"/>
  <button type="submit" name="result" value="0">Forgotten</button>
  <button type="submit" name="result" value="1">I was close</button>
  <button type="submit" name="result" value="2">I knew it</button>
  <button type="submit" name="result" value="3">Boaring</button>
</form>
<script type="text/javascript">
  $("#show").click(function(){
    $("#show").fadeOut(1000);
    $("#backSide").fadeIn(1000);
    $("#result").fadeIn(1000);
  });
</script>
{/block}