{extends file="../main.tpl"}
{block name="content"}
  <h2>Tag: {$tag->getName()}</h2><br />
  
  {include file="./../tags/tag.tpl" tag=$tag}
  <br /><br />
  <a class="button" href="{url action="edit" tagId=$tag->getId()}">Edit Tag</a>
  <a class="button" href="{url action="delete" tagId=$tag->getId()}">Delete Tag</a>
  
  <br/><br/>
  <h3>Cards with this tag:</h3>
  <table>
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
        <td>{$c->getAverageResult()}</td>
      </tr>
    {/foreach}
    </tbody>
  </table>
{/block}