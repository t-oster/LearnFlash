<!DOCTYPE HTML>
<html>
  <header>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="lib/js/jQuery-UI/jquery-ui-1.9.1.custom.min.css" />
    <link rel="stylesheet" href="css/main.css" />
    <!--[if ie]><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7, IE=8, IE=9, chrome=1"/><![endif]-->
    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="lib/js/jquery-1.8.2.min.js"></script>
    <script src="lib/js/jQuery-UI/jquery-ui-1.9.1.custom.min.js"></script>
  </header>
  <body>
    {block name="body"}
      {block name="menu"}
        <div id="menu">
          <a href="#">home</a>
        </div>
      {/block}
      {block name="content"}
        Please use this block to fill in content
      {/block}
      {block name="footer"}
        This page is brought to you by us. We're awesome!
      {/block}
    {/block}
  </body>
</html>