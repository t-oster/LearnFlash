{extends file="../main.tpl"}
{block name="content"}
<form id="loginForm">
  <label for="lf_login">Username</label>
  <input type="text" id="lf_login" name="login"/>
  <label for="lf_password">Password</label>
  <input type="password" id="lf_password" name="password"/>
</form>
<script type="text/javascript">
  $(document).ready(function(){
    $("#loginForm").dialog({
      buttons: {
      Register: function(){ window.location = "{url controller="Register"}"; $(this).dialog("close"); },
      Login: function(){ $.getJSON("{url action="loginAjax"}", $("#loginForm").serialize(), function(result){ 
        if (result == true)
        {
            $("#loginForm").parent().effect("shake", { direction: "down", times: 2 }, 600);
            {if $redirect != null}
            window.location = "{$redirect}";
            {else}
            window.location = "{url controller="Home"}";
            {/if}
        }
        else
        {
            $("#loginForm").parent().effect("shake", { times: 2 }, 600);
            $.ambiance({ message: result, 
            type: "error"} );
        }
      }) }
      }
    });
    $("#loginForm").dialog("option","resizable",false);
  });
</script>
{/block}