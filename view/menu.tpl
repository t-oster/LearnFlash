
<div id="menu">
  <a href="{url controller="Home"}">home</a>
  <a href="{url controller="Cards"}">cards</a>
  <div id="loggedinas">
  {if isset($smarty.session.login)}
    You are logged in as {$smarty.session.login} <a href="{url controller="Login" action="logout"}">Logout</a>
  {/if}
  </div>
</div>