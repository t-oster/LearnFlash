{extends file="../main.tpl"}

{block name="head"}
  <link rel="stylesheet" href="css/cards.css" />
{/block}

{block name="content"}
<form action="{url action="update"}" method="POST">
  <input type="hidden" name="cardId" value="{$card->getId()}"/>
  <label for="title">Title</label>
  <input type="text" id="title" name="title" value="{$card->getTitle()}"/>
  <label for="frontHtml">Front</label>
  <textarea class="tinymce" id="frontHtml" name="frontHtml">{$card->getFrontHtml()}</textarea>
  <label for="backHtml">Back</label>
  <textarea class="tinymce" id="backHtml" name="backHtml">{$card->getBackHtml()}</textarea>
  {include file="../tags/tagInputField.tpl" tags=$tags value=$stringTags}
  <input type="submit" value="Update"/>
  or <a href="{url}">Cancel</a>
</form>
<script type="text/javascript" src="lib/js/tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
  $(document).ready(function()
  {
    $('textarea.tinymce').tinymce(
    {
      // Location of TinyMCE script
      script_url : 'lib/js/tinymce/jscripts/tiny_mce/tiny_mce.js',

      // General options
      theme : "advanced",
      plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

      // Theme options
      theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
      theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
      theme_advanced_toolbar_location : "top",
      theme_advanced_toolbar_align : "left",
      theme_advanced_statusbar_location : "bottom",
      theme_advanced_resizing : true
    });
  });
</script>
{/block}