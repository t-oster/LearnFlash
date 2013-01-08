{extends file="../main.tpl"}
{block name="content"}
  <h1>{$tag->getName()}</h1>
  <a class="editlink" href="{url action="edit" tagId=$tag->getId()}">edit</a>
  <a class="deletelink" href="{url action="delete" tagId=$tag->getId()}">delete</a>
  <h2>Color</h2>
  {$tag->getColor()}
  <h2>Cards</h2>
  <ul>
    {foreach $tag->getCards() as $c}
      <li><a href="{url controller="Cards" action="show" cardId=$c->getId()}">{$c->getTitle()}</a></li>
    {/foreach}
  </ul>
{/block}