{extends file="../main.tpl"}

{block name="head"}
  <link rel="stylesheet" href="css/cards.css" />
  <script type="text/javascript"
    src="https://c328740.ssl.cf1.rackcdn.com/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
  </script>
{/block}

{block name="content"}
<h1 id="title">{$card->getTitle()}</h1>
<span id="cardsLeftNote">{count($smarty.session.toLearn)} cards left</span>
<div id="tagList">
{include file="./../tags/taglist.tpl" tags=$card->getTags()}
</div>
<div class="clear"></div>
<center>
<div id="buttons">
  <form action="{url action="next"}" method="POST">
    <input id="cardId" type="hidden" name="cardId" value="{$card->getId()}"/>
      <button class="button" id="show">Show answer</button>
      <div id="result" style="display: none;">
    {if $smarty.session.usesm2 == true }
      <button class="button" type="submit" name="result" value="0" title= "complete blackout">0</button>
      <button class="button" type="submit" name="result" value="1" title="incorrect response; the correct one remembered">1</button>
      <button class="button" type="submit" name="result" value="2" title="incorrect response; where the correct one seemed easy to recall">2</button>
      <button class="button" type="submit" name="result" value="3" title="correct response recalled with serious difficulty">3</button>
      <button class="button" type="submit" name="result" value="4" title="correct response after a hesitation">4</button>
      <button class="button" type="submit" name="result" value="5" title="perfect response">5</button>
    {else}
      <button class="button" type="submit" name="result" value="1">Forgotten</button>
      <button class="button" type="submit" name="result" value="2">I was close</button>
      <button class="button" type="submit" name="result" value="3">I knew it</button>
      <button class="button" type="submit" name="result" value="4">Boring</button>
    {/if}
    </div>
  </form>
</div>
<div id="frontSide" class="card">
  {$frontHtml}
</div>
<div class="clear"></div>
<div id="backSide" class="card" style="display: none;">
  {$backHtml}
</div>
</center>
<script type="text/javascript">
  $("#show").click(function(){
    $("#show").hide();
    $("#backSide").slideDown(500);
    $("#result").fadeIn(1000);
    return false;
  });
  /*
   Instead of using the form, we use ajax to update only the important parts
  */
  $('button[type="submit"]').click(function(){
    var result = $(this).val();
    $("#result").hide();
    $("#show").fadeIn(1000);
    $("#frontSide").slideUp(500);
    $("#backSide").slideUp(500);
    $.post(
      '{url action="next"}',
      {
        cardId: $("#cardId").val(),
        result: result
      },
      function(cardInfo) {
        if (cardInfo == "end")
        {
            success("You did it.");
            $("#frontSide").html("No more cards to learn");
            $("#frontSide").fadeIn(1000);
            $("#show").hide();
            $("#tagList").hide();
            $("#title").hide();
            $("#cardsLeftNote").hide();
        }
        else
        {
          $("#frontSide").html(cardInfo.frontHtml);
          $("#backSide").html(cardInfo.backHtml);
          $("#cardId").val(cardInfo.cardId);
          $("#tagList").load('{url controller="tags" action="taglist"}', { cardId: cardInfo.cardId});
          $("#cardsLeftNote").html(cardInfo.cardsLeft+" cards left");
          $("#title").html(cardInfo.title);
          $("#frontSide").slideDown(500);
        }
      },
      "json"
    );
    return false;
  });
</script>
{/block}