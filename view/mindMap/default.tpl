{extends file="../main.tpl"}
{block name="content"}
<h2>Mindmap</h2>
<h3>Here you see an overview of all your cards in form of a mindmap.</h3>
      {foreach $mindmaps as $mm}
        <p>{$mm->getName()}<p>

      {/foreach}
{/block}