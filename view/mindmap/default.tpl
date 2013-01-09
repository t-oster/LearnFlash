{extends file="../main.tpl"}
{block name="content"}
<h2>Mindmap</h2>
<h3>Here you see an overview of all your cards in form of a mindmap.</h3>
      {foreach $cards as $c}
        {c->}
        {
          text: "{$t->getName()}",
          weight: "{count($t->getCards())}",
          link: "{url controller="Tags" action="show" tagId=$t->getId()}"
        },
      {/foreach}
{/block}