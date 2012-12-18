{extends file="../main.tpl"}
{block name="content"}
<h2> Your cards </h2>
<a href="{url action="add"}">Add</a>
<ul>
{foreach $cards as $c}
  <li>{$c->getTitle()}</li>
{/foreach}
</ul>
{/block}