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
<div class="clear"></div>
<br/>
<b>Selected cards: </b>
<span id="countAll"></span><br/>
<b>Unlearned cards in selection: </b>
<span id="countUnlearned"></span><br/>
<br/>