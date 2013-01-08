
<div id="menu">
  <div class=center>
    <a href="{url controller="Home"}">home</a>
    <a href="{url controller="Cards"}">cards</a>
    <a href="{url controller="Tags"}">tags</a>
    <a href="{url controller="Learn"}">learn</a>
    <div id="loggedinas">
    {if isset($smarty.session.login)}
      You are logged in as {$smarty.session.login} <a href="{url controller="Login" action="logout"}">Logout</a>
    {/if}
    </div>
  </div>
</div>