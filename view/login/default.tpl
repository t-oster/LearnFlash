{extends file="../main.tpl"}
{block name="content"}
<form id="loginForm" action="{url action="login" redirect=$redirect}" method="POST">
  <label for="lf_login">Username</label>
  <input type="text" id="lf_login" name="login"/>
  <label for="lf_password">Password</label>
  <input type="password" id="lf_password" name="password"/>
  <div id="controls">
  <input type="submit" value="login"/>
  or <a href="{url controller="register"}">Register</a>
  </div>
</form>
<script type="text/javascript">
  $(document).ready(function(){
    $("#controls").hide();
    $("#loginForm").dialog({
      buttons: {
        Login: function(){ $("#controls input").click(); },
        Register: function(){ window.location = $("#controls a").attr("href"); $(this).dialog("close"); }
      }
    });
  });
</script>
{/block}