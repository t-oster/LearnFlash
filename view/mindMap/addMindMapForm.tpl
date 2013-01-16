<a href="javascript:showAddMindMapDialog();" class="button">{$text}</a>

<form style="display: none;" id="addMindMapForm" action="{url action="addMindMap"}" method="POST" title="Add new MindMap">
      <label for="mindMapName">Name</label>
  <input type="text" id="mindMapName" name="name"/>
</form>

<script type="text/javascript">
  function showAddMindMapDialog(){
    $("#addMindMapForm").dialog({
      buttons: {
        Add: function(){ addMindMap($("#mindMapName").val()); $(this).dialog("close");}
      },
      resizable: false
    });
    $('#addMindMapForm').live('keyup', function(e){
      if (e.keyCode == 13) {
        addMindMap($("#mindMapName").val());
      }
    });
  }
</script>