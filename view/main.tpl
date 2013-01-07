<!DOCTYPE HTML>
<html>
  <header>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="lib/js/jQuery-UI/jquery-ui-1.9.1.custom.min.css" />
    <link rel="stylesheet" href="lib/js/ambiance/jquery.ambiance.css" />
    <link rel="stylesheet" href="css/main.css" />
    <!--[if ie]><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7, IE=8, IE=9, chrome=1"/><![endif]-->
    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="lib/js/jquery-1.8.2.min.js"></script>
    <script src="lib/js/jQuery-UI/jquery-ui-1.9.1.custom.min.js"></script>
    <script src="lib/js/ambiance/jquery.ambiance.js"></script>
    <script src="js/main.js"></script>
    {block name="head"}
    {/block}
  </header>
  <body>
    {block name="body"}
      {block name="menu"}
        {include file="../menu.tpl"}
      {/block}
       <div class=center>
      {block name="content"}
        Please use this block to fill in content
      {/block}
       </div>
      {block name="footer"}
        {include file="../footer.tpl"}
      {/block}
    {/block}
   
  </body>
  <script type="text/javascript">
    $(document).ready(function()
    {
      {if isset($smarty.session.error)}
        {foreach $smarty.session.error as $e}
          error("{$e}");
        {/foreach}
        {clear_errors}
      {/if}
      {if isset($smarty.session.info)}
        {foreach $smarty.session.info as $i}
          info("{$i}");
        {/foreach}
        {clear_infos}
      {/if}
    });
  </script>
</html>