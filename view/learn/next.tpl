{extends file="../main.tpl"}

{block name="head"}
  <link rel="stylesheet" href="css/cards.css" />
{/block}

{block name="content"}
<h1 id="title">{$card->getTitle()}</h1>
<div id="tagList">
{include file="./../tags/taglist.tpl" tags=$card->getTags()}
</div>
<div id="buttons">
  <button id="show">Show answer</button>
  <form action="{url action="next"}" method="POST" id="result" style="display: none;">
    <input id="cardId" type="hidden" name="cardId" value="{$card->getId()}"/>
    {if $smarty.session.usesm2 == true }
      <button type="submit" name="result" value="0" title= "complete blackout">0</button>
      <button type="submit" name="result" value="1" title="incorrect response; the correct one remembered">1</button>
      <button type="submit" name="result" value="2" title="incorrect response; where the correct one seemed easy to recall">2</button>
      <button type="submit" name="result" value="3" title="correct response recalled with serious difficulty">3</button>
      <button type="submit" name="result" value="4" title="correct response after a hesitation">4</button>
      <button type="submit" name="result" value="5" title="perfect response">5</button>
    {else}
      <button type="submit" name="result" value="1">Forgotten</button>
      <button type="submit" name="result" value="2">I was close</button>
      <button type="submit" name="result" value="3">I knew it</button>
      <button type="submit" name="result" value="4">Boaring</button>
    {/if}
  </form>
</div>
<div id="frontSide">
  {$frontHtml}
</div>
<div id="backSide" style="display: none;">
  {$backHtml}
</div>
<script type="text/javascript">
  $("#show").click(function(){
    $("#show").hide();
    $("#backSide").slideDown(500);
    $("#result").fadeIn(1000);
  });
  /*
   Instead of using the form, we use ajax to update only the important parts
  */
  $('button[type="submit"]').click(function(){
    var result = $(this).val();
    $("#result").hide();
    $("#frontSide").slideUp(500);
    $("#backSide").slideUp(500);
    $.post(
      '{url action="next"}',
      {
        cardId: $("#cardId").val(),
        result: result
      },
      function(cardInfo) {
        $("#frontSide").html(cardInfo.frontHtml);
        $("#backSide").html(cardInfo.backHtml);
        $("#cardId").val(cardInfo.cardId);
        $("#tagList").load('{url controller="tags" action="taglist"}', { cardId: cardInfo.cardId});
        $("#title").html(cardInfo.title);
        $("#frontSide").slideDown(500);
        $("#show").show();
      },
      "json"
    );
    return false;
  });
</script>
{/block}