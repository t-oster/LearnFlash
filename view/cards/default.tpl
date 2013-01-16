{extends file="../main.tpl"}

{block name="head"}
  <link rel="stylesheet" href="css/cards.css" />
{/block}

{block name="content"}
<h2> Your cards </h2>
<a class="button" href="{url action="add"}">New Card</a>

<div id="cards">
{foreach $cards as $c}
  <div class="card">
    <a class="title" href="{url action="show" cardId=$c->getId()}">{$c->getTitle()}</a>
    <a class="editButton" href="{url action="edit" cardId=$c->getId()}">Edit</a>
    <a class="deleteButton" href="{url action="delete" cardId=$c->getId()}">Delete</a>
    <p>Answered: {if $c->getCountAnswers() == 1}1 time{else}{$c->getCountAnswers()} times{/if}</p>
    <p>Average result: {$c->getAverageResult()}</p>
    {include file="../tags/taglist.tpl" tags=$c->getTags()}
  </div>
  
{/foreach}
</div>
<hr class=freeBox>
<script type="text/javascript">
  $("#cards a.deleteLink").click(function()
  {
    var link = this;
    $.getJSON($(this).attr("href"), null, function(result)
    {
      if (result == true)
      {
          var card = $(link).parents("div.card");
          card.fadeOut("normal", function()
          {
            card.remove();
          });
          info("Card deleted", 2);
      }
      else
      {
          error(result);
      }
    });
    //prevent the link from executing
    return false;
  });
</script>
{/block}