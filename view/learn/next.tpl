{extends file="../main.tpl"}

{block name="head"}
  <link rel="stylesheet" href="css/cards.css" />
{/block}

{block name="content"}
<h1 id="title">{$card->getTitle()}</h1>
<div id="buttons">
  <button id="show">Show answer</button>
  <form action="{url action="next"}" method="POST" id="result" style="display: none;">
    <input id="cardId" type="hidden" name="cardId" value="{$card->getId()}"/>
    <button type="submit" name="result" value="0">Forgotten</button>
    <button type="submit" name="result" value="1">I was close</button>
    <button type="submit" name="result" value="2">I knew it</button>
    <button type="submit" name="result" value="3">Boaring</button>
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
      "{url action="next"}",
      {
        cardId: $("#cardId").val(),
        result: result
      },
      function(cardInfo) {
        $("#frontSide").html(cardInfo.frontHtml);
        $("#backSide").html(cardInfo.backHtml);
        $("#cardId").val(cardInfo.cardId);
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