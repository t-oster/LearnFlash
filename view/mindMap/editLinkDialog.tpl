<div id="editLinkDialog">
  <input type="hidden" id="eldLinkId"/>
  <label for="eldText">Text:</label>
  <input type="text" id="eldText"/>
  <label for="eldLeftArrow">LeftArrow:</label>
  <input type="checkbox" id="eldLeftArrow"/>
  <label for="eldRightArrow">RightArrow:</label>
  <input type="checkbox" id="eldRightArrow"/>
</div>
<script type="text/javascript">
  $("#editLinkDialog").dialog({
    autoOpen: false,
    buttons: {
      Ok: updateLinkFromForm
    }
  });
</script>