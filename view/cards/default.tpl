{extends file="../main.tpl"}
{block name="content"}
<h2> Your cards </h2>
<a class="button" href="{url action="add"}">Add</a>
<div id="cards">
{foreach $cards as $c}
  <div class="card">
    <a class="getTitle" href="{url action="show" cardId=$c->getId()}">{$c->getTitle()}</a>
    <a class="deleteLink" href="{url action="delete" cardId=$c->getId()}">delete</a>
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