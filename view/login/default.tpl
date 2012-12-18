{extends file="../main.tpl"}
{block name="content"}
  <form id="registerForm" action="{url action="login" redirect=$redirect}" method="POST">
      <label for="lf_login">Username</label>
      <input type="text" id="lf_login" name="login"/>
      <label for="lf_password">Password</label>
      <input type="password" id="lf_password" name="password"/>
      <input type="submit" value="login"/>
      <a href="{url controller="register"}">Register</a>
    </form>
{/block}