{extends file="../main.tpl"}
{block name="content"}
  <h1>{$tag->getName()}</h1>
  <h2>Color</h2>
  {$tag->getColor()}
  <h2>Cards</h2>
  <ul>
    {foreach $tag->getCards() as $c}
      <li><a href="{url controller="Cards" action="show" cardId=$c->getId()}">{$c->getTitle()}</a></li>
    {/foreach}
  </ul>
{/block}