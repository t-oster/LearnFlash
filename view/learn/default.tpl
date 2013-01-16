{extends file="../main.tpl"}
{block name="content"}
<h2>Which Cards do you want to learn?</h2>
<form id="form" action="{url action="prepareLearning"}" method="POST">
  <label>Selection</label>
  <input class="updateInfo" id="rdAll" type="radio" checked="checked" name="selection" value="all"/>All<br/>
<input class="updateInfo" id="rdTags" type="radio" name="selection" value="byTags"/>By Tags<br/>
<div id="tags" class="disabled">
{foreach $tags as $t}
  <div class=wrap> <input class="updateInfo" type="checkbox" name="tagIds[]" value="{$t->getId()}"/>{include file="../tags/tag.tpl" tag=$t}</div>
{/foreach}
</div>
<input class="updateInfo" type="checkbox" name="unlearned" vlaue="true"/>Only unlearned cards<br/>
<label for="order">Order:</label>
<select class="updateInfo" name="order">
  <option value="random">random order</option>
  <option value="creation">creation order</option>
  <option value="average" selected="selected">average result</option>
  <option value="last">last result</option>
  <option value="sm2">SM2-Algorithm</option>
</select>
<label>Selected cards: </label>
<span id="countAll"></span><br/>
<label>Unlearned cards in selection: </label>
<span id="countUnlearned"></span><br/>
<br/>
<input id="go" type="submit" value="Go"/>
</form>

<script type="text/javascript">
  $("#rdAll").click(function(){
    $("#tags").addClass("disabled");
  });
  $("#rdTags").click(function(){
    $("#tags").removeClass("disabled");
  });
  function updateInfo()
  {
    $("#countAll").html("");
    $("#countUnlearned").html("");
    $.getJSON("{url action="countSelection"}", $("#form").serialize(), function(result){
      if(result.all==0)
      {
        $("#go").attr("disabled", "disabled");    
      }
      else 
      {
        $("#go").removeAttr("disabled");
      }
      $("#countAll").html(result.all);
      $("#countUnlearned").html(result.unlearned);
    });
  }
  $(".updateInfo").click(updateInfo);
  updateInfo();
</script>
{/block}