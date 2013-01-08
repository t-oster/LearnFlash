{extends file="../main.tpl"}
{block name="content"}
<h2>Which Cards do you want to learn?</h2>
<form action="{url action="prepareLearning"}" method="POST">
<input id="rdAll" type="radio" name="all" value="true"/>All<br/>
<input id="rdTags" type="radio" name="byTag" value="true"/>By Tags<br/>
<div id="tags" style="display: none;">
{foreach $tags as $t}
  <input type="checkbox" name="tagIds[]" value="{$t->getId()}"/>{include file="../tags/tag.tpl" tag=$t}<br/>
{/foreach}
</div>

<h3>Options</h3>
<input type="checkbox" name="random" value="true"/>Random order<br/>
<input type="checkbox" name="unlearned" vlaue="true"/>Only unlearned cards</br>
<input type="submit" value="Go">/
</form>
<h3>Info</h3>
TODO: Update via Ajax on change
Selected cards: 42<br/>
Unlearned cards in selection: 23<br/>

<script type="text/javascript">
  $("#rdAll").click(function(){
    $("#rdTags").removeAttr("checked");
    $("#tags").hide();
  });
  $("#rdTags").click(function(){
    $("#tags").fadeIn(1000);
    $("#rdAll").removeAttr("checked");
  });
  $("#go").click(function(){
    
  });
</script>
{/block}