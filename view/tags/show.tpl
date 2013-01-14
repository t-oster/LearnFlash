{extends file="../main.tpl"}
{block name="content"}
  <h1>{$tag->getName()}</h1>
  <a class="editlink button" href="{url action="edit" tagId=$tag->getId()}">edit</a>
  <a class="deletelink button" href="{url action="delete" tagId=$tag->getId()}">delete</a>
  <h2>Color</h2>
  <div class="tag" style="background-color: {$tag->getColor()};">
  {$tag->getColor()}
  </div><br/><br/>
  <h2>Cards</h2>
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