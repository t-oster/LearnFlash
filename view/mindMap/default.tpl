{extends file="../main.tpl"}
{block name="content"}
<h2>Mindmap</h2>
<h3>Here you see an overview of all your mindmap.</h3>
      {foreach $mindmaps as $mm}
        <p><a href="{url action="show" mindMapId=$mm->getId()}">{$mm->getName()}</a><p>
      {/foreach}
      
      <a href="javascript:showAddMindMapDialog();" class="button">Add a new MindMap</a>
      
      <form style="display: none;" id="addMindMapForm" action="{url action="addMindMap"}" method="POST" title="Add new MindMap">
        <label for="mindMapName">Name</label>
        <input type="text" id="mindMapName" name="mindMapName"/>
        <div id="controls">
          <input type="submit" value="addMindMap"/>
          </div>
      </form>
      
      
      <script type="text/javascript">
        $(document).ready(function(){
          $("#controls").hide();
        });
        
        function showAddMindMapDialog(){
          $("#addMindMapForm").dialog({
            buttons: {
              Add: function(){ $("#controls input").click(); }
            }
          });
          $("#addMindMapForm").dialog("option","resizable",false);
          $('#addMindMapForm').live('keyup', function(e){
            if (e.keyCode == 13) {
              $(':button:contains("Add")').click();
            }
         });
        }
      </script>
{/block}