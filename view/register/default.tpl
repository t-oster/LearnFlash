{extends file="../main.tpl"}
{block name="content"}
  <form id="registerForm" action="{url action="register"}" method="POST">
      <label for="lf_login">Username</label>
      <input type="text" id="lf_login" name="login"/>
      <label for="lf_password">Password</label>
      <input type="password" id="lf_password" name="password"/>
      <label for="lf_name">Name</label>
      <input type="text" id="lf_name" name="name"/>
      <label for="lf_email">E-Mail</label>
      <input type="email" id="lf_email" name="email"/>
      <input type="submit" value="register"/>
    </form>
{/block}