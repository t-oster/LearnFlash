{extends file="../main.tpl"}
{block name="head"}
  <link rel="stylesheet" href="lib/js/colorpicker.css"/>
  <script type="text/javascript" src="lib/js/colorpicker.js"></script>
{/block}

{block name="content"}
<h2>Edit Tag: {$tag->getName()}</h2>

  {include file="./../tags/tag.tpl" tag=$tag}

<form action="{url action="update"}" method="POST">
  <input type="hidden" name="tagId" value="{$tag->getId()}"/>
  <label for="name">Name:</label>
  <input type="text" name="name" value="{$tag->getName()}"/>
  <label for="color">Color:</label>
  <input type="text" name="color" id="colorpickerField1" value="{$tag->getColor()}"/>
  <a class="button cancel" href="{url action="show" tagId=$tag->getId()}">Cancel</a><button class="button save">Save</button>
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
