{extends file="../main.tpl"}
{block name="head"}
  <link rel="stylesheet" href="lib/js/colorpicker.css"/>
  <script type="text/javascript" src="lib/js/colorpicker.js"></script>
{/block}

{block name="content"}
<h2>Edit Tag: {$tag->getName()}</h2>

  {include file="./../tags/tag.tpl" tag=$tag}
  <br />
  <br />
  <br />
  <br />

<form action="{url action="update"}" method="POST">
<table>
  <tr>
    <td>
      <input type="hidden" name="tagId" value="{$tag->getId()}"/>
      <label for="name">Name:</label>
    </td>
    <td>
      <input type="text" name="name" value="{$tag->getName()}"/>
    </td>
  </tr>
  <tr>
    <td>
      <label for="color">Color:</label>
    </td>
    <td>
      <input type="text" name="color" id="colorpickerField1" value="{$tag->getColor()}"/>
    </td>
  </tr>
  <tr>
    <td></td>
    <td>
      <input class="button" type="submit" name="Save" value="Save"/>
      <a class="button" href="{url action="show" tagId=$tag->getId()}">Cancel</a>
    </td>
  </tr>
 </table>
  </form>
<script type="text/javascript">
  
  $('#colorpickerField1').ColorPicker({
	onSubmit: function(hsb, hex, rgb, el) {
		$(el).val("#"+hex);
    $('.tag').css("background-color", "#"+hex);
		$(el).ColorPickerHide();
	},
	onBeforeShow: function () {
		$(this).ColorPickerSetColor(this.value);
	}
})
.bind('keyup', function(){
	$(this).ColorPickerSetColor(this.value);
});
  
  
  </script>
{/block}
