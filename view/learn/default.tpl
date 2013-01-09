{extends file="../main.tpl"}
{block name="content"}
<h2>Which Cards do you want to learn?</h2>
<form id="form" action="{url action="prepareLearning"}" method="POST">
<input class="updateInfo" id="rdAll" type="radio" name="selection" value="all"/>All<br/>
<input class="updateInfo" id="rdTags" type="radio" name="selection" value="byTags"/>By Tags<br/>
<div id="tags" style="display: none;">
{foreach $tags as $t}
  <input class="updateInfo" type="checkbox" name="tagIds[]" value="{$t->getId()}"/>{include file="../tags/tag.tpl" tag=$t}<br/>
{/foreach}
</div>

<h3>Options</h3>
<input class="updateInfo" type="checkbox" name="random" value="true"/>Random order<br/>
<input class="updateInfo" type="checkbox" name="unlearned" vlaue="true"/>Only unlearned cards</br>
<input id="go" type="submit" value="Go">
</form>
<h3>Info</h3>
Selected cards: <span id="countAll">42</span><br/>
Unlearned cards in selection: <span id="countUnlearned">42</span><br/>

<script type="text/javascript">
  $("#rdAll").click(function(){
    $("#tags").hide();
  });
  $("#rdTags").click(function(){
    $("#tags").fadeIn(1000);
  });
  $(".updateInfo").click(function(){
    $("#countAll").html("");
    $("#countUnlearned").html("");
    $.getJSON("{url action="prepareLearning"}", $("#form").serialize(), function(result){
      $("#countAll").html(result.all);
      $("#countUnlearned").html(result.unlearned);
    });
  });
</script>
{/block}