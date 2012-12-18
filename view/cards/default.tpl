{extends file="../main.tpl"}
{block name="content"}
<h2> Your cards </h2>
<a href="{url action="add"}">Add</a>
<ul id="cards">
{foreach $cards as $c}
  <li>{$c->getTitle()} <a class="deleteLink" href="{url action="delete" cardId=$c->getId()}">delete</a></li>
{/foreach}
</ul>
<script type="text/javascript">
  $("#cards a.deleteLink").click(function()
  {
    var link = this;
    $.getJSON($(this).attr("href"), null, function(result)
    {
      if (result == true)
      {
          var li = $(link).parents("li");
          li.fadeOut("normal", function()
          {
            li.remove();
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