{extends file="../main.tpl"}
{block name="content"}
<form id="registerForm" action="{url action="register"}" method="POST"  title="Register">
  <label for="lf_login">Username</label>
  <input type="text" id="lf_login" name="login"/>
  <label for="lf_password">Password</label>
  <input type="password" id="lf_password" name="password"/>
  <label for="lf_name">Name</label>
  <input type="text" id="lf_name" name="name"/>
  <label for="lf_email">E-Mail</label>
  <input type="email" id="lf_email" name="email"/>
  <div id="controls">
    <input type="submit" value="register"/>
    or <a href="{url controller="login"}">Login</a>
  </div>
</form>
<script type="text/javascript">
  $(document).ready(function(){
  $("#controls").hide();
  $("#registerForm").dialog({
  buttons: {
    Login: function(){ window.location = $("#controls a").attr("href"); $(this).dialog("close"); },
    Register: function(){ $("#controls input").click(); }
    }
  });
  $("#registerForm").dialog("option","resizable",false);
  $('#registerForm').live('keyup', function(e){
    if (e.keyCode == 13) {
      $(':button:contains("Login")').click();
    }
  });
});
</script>
{/block}