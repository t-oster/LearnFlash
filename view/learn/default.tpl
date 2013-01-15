{extends file="../main.tpl"}
{block name="content"}
<h2>Which Cards do you want to learn?</h2>
<form id="form" action="{url action="prepareLearning"}" method="POST">
  <input class="updateInfo" id="rdAll" type="radio" checked="checked" name="selection" value="all"/>All<br/>
<input class="updateInfo" id="rdTags" type="radio" name="selection" value="byTags"/>By Tags<br/>
<div id="tags" style="display: none;">
{foreach $tags as $t}
  <div class=wrap> <input class="updateInfo" type="checkbox" name="tagIds[]" value="{$t->getId()}"/>{include file="../tags/tag.tpl" tag=$t}</div>
{/foreach}
</div>
<input class="updateInfo" type="checkbox" name="unlearned" vlaue="true"/>Only unlearned cards<br/>
<h3>Options</h3>
<label for="order">Order:</label>
<select class="updateInfo" name="order">
  <option value="random">random order</option>
  <option value="creation">creation order</option>
  <option value="average" selected="selected">average result</option>
  <option value="last">last result</option>
  <option value="sm2">SM2-Algorithm</option>
</select>
<br/>
<input id="go" type="submit" value="Go"/>
</form>
<h3>Info</h3>
Selected cards: <span id="countAll"></span><br/>
Unlearned cards in selection: <span id="countUnlearned"></span><br/>

<script type="text/javascript">
  $("#rdAll").click(function(){
    $("#tags").hide();
  });
  $("#rdTags").click(function(){
    $("#tags").fadeIn(1000);
  });
  function updateInfo()
  {
    $("#countAll").html("");
    $("#countUnlearned").html("");
    $.getJSON("{url action="countSelection"}", $("#form").serialize(), function(result){
      $("#countAll").html(result.all);
      $("#countUnlearned").html(result.unlearned);
    });
  }
  $(".updateInfo").click(updateInfo);
  updateInfo();
</script>
{/block}