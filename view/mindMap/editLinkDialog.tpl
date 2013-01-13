<div id="editLinkDialog">
  <input type="hidden" id="eldLinkId"/>
  <label for="eldText">Text:</label>
  <input type="text" id="eldText"/>
</div>
<script type="text/javascript">
  $("#editLinkDialog").dialog({
    autoOpen: false,
    buttons: {
      Cancel: function(){ $(this).dialog("close");},
      Ok: updateLinkFromForm
    }
  });
</script>