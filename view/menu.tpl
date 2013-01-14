
<div id="menu">
  <div class=center>
    <a {if $controller=="home"}class="menuActive"{/if} href="{url controller="Home"}">Home</a>
    <a {if $controller=="cards"}class="menuActive"{/if}href="{url controller="Cards"}">Cards</a>
    <a {if $controller=="tags"}class="menuActive"{/if}href="{url controller="Tags"}">Tags</a>
    <a {if $controller=="learn"}class="menuActive"{/if}href="{url controller="Learn"}">Learn</a>
    <a {if $controller=="mindMap"}class="menuActive"{/if}href="{url controller="MindMap"}">Mindmap</a>
    <div id="loggedinas">
    {if isset($user)}
      You are logged in as <b>{$user->getName()}</b> <a href="{url controller="Login" action="logout"}">Logout</a>
    {/if}
    </div>
  </div>
</div>