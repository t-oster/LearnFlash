{extends file="../main.tpl"}
{block name="content"}
<h2>Which Cards do you want to learn?</h2>
<form id="form" action="{url action="prepareLearning"}" method="POST">
  <label>Selection</label>
  <input class="updateInfo" id="rdAll" type="radio" {if $tag == null}checked="checked"{/if} name="selection" value="all"/>All<br/>
<input class="updateInfo" id="rdTags" type="radio" {if $tag != null}checked="checked"{/if} name="selection" value="byTags"/>By Tags<br/>
<div id="tags" style="margin-top: 10px;">
{foreach $tags as $t}
  <div class=wrap> <input {if $tag == null}disabled="disabled"{elseif $tag == $t->getId()}checked="checked"{/if} class="updateInfo" type="checkbox" name="tagIds[]" value="{$t->getId()}"/>{include file="../tags/tag.tpl" tag=$t}</div>
{/foreach}
</div>
<div class="clear"></div>
<br/>
<input class="updateInfo" type="checkbox" name="unlearned" vlaue="true"/>Only unlearned cards<br/>
<label for="order">Order:</label>
<select class="updateInfo" name="order">
  <option value="random">random order</option>
  <option value="creation">creation order</option>
  <option value="average" selected="selected">average result</option>
  <option value="last">last result</option>
  <option value="sm2">SM2-Algorithm</option>
</select>
<b>Selected cards: </b>
<span id="countAll"></span><br/>
<b>Unlearned cards in selection: </b>
<span id="countUnlearned"></span><br/>
<br/>
<input id="go" type="submit" value="Start Learning"/>
</form>

<script type="text/javascript">
  {if $tag == null}
    $("#tags .tag").addClass("grey");
  {/if}
  $("#rdAll").click(function(){
    $("#tags input").attr("disabled", "disabled");
    $("#tags .tag").addClass("grey");
  });
  $("#rdTags").click(function(){
    $("#tags input").removeAttr("disabled");
    $("#tags .tag").removeClass("grey");
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