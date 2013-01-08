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
<div id="result" style="display: none;">
  <button>Forgotten</button>
  <button>I was close</button>
  <button>I knew it</button>
  <button>Boaring</button>
</div>
<script type="text/javascript">
  $("#show").click(function(){
    $("#show").fadeOut(1000);
    $("#backSide").fadeIn(1000);
    $("#result").fadeIn(1000);
  });
</script>
{/block}