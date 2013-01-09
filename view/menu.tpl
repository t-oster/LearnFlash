
<div id="menu">
  <div class=center>
    <a href="{url controller="Home"}">Home</a>
    <a href="{url controller="Cards"}">Cards</a>
    <a href="{url controller="Tags"}">Tags</a>
    <a href="{url controller="Learn"}">Learn</a>
    <a href="{url controller="Mindmap"}">Mindmap</a>
    <div id="loggedinas">
    {if isset($smarty.session.login)}
      You are logged in as <b>{$smarty.session.login}</b> <a href="{url controller="Login" action="logout"}">Logout</a>
    {/if}
    </div>
  </div>
</div>