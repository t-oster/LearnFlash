{extends file="../main.tpl"}
{block name="content"}
  <h2>Tag: {$tag->getName()}</h2><br />
  {include file="./../tags/tag.tpl" tag=$tag}
  <br/><br/><br/><br/>
  <a class="button edit" href="{url action="edit" tagId=$tag->getId()}">Edit Tag</a>
  <a class="button delete" href="{url action="delete" tagId=$tag->getId()}">Delete Tag</a>
  <a class="button" href="{url controller='learn' action='default' tag=$tag->getId()}">Learn Cards</a> 
  <a class="button" href="{url controller='cards' action='export' tag=$tag->getId()}">Export Cards</a> 
  <br/><br/>
  <h3>Cards with this tag:</h3>
  <table class="cardinfo">
    <thead>
      <tr>
        <th>Title</th>
        <th>Answered</th>
        <th>Average result</th>
      </tr>
    </thead>
    <tbody>
    {foreach $tag->getCards() as $c}
      <tr>
        <td><a href="{url controller="Cards" action="show" cardId=$c->getId()}">{$c->getTitle()}</a></td>
        <td>{$c->getCountAnswers()}</td>
        <td>{$c->getAverageResultText()}</td>
      </tr>
    {/foreach}
    </tbody>
  </table>
{/block}