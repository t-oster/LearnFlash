{extends file="../main.tpl"}
{block name="mainContent"}
<h2>Mindmap</h2>
  Displaying MindMap with name="{$mindmap->getName()}"
  <button id="save">Save</button>
  <div id="mindMap" style="position: relative">
  {foreach $mindmap->getChildren() as $c}    
    {include file="./node.tpl" node=$c}
  {/foreach}
  </div>
  <script type="text/javascript">
    $(".mindMapNode").draggable();
    $("#save").click(function(){
      $("#save").hide();
      var ids = [];
      var xs = [];
      var ys = [];
      var collapseds = [];
      //collect infos
      $(".mindMapNode").each(function(){
        //remove the "node" prefix from the id
        ids.push(this.id.substring(4));
        //remove the "px" suffix from the x and y
        xs.push($(this).css("left").slice(0, -2));
        ys.push($(this).css("top").slice(0, -2));
        //TODO
        collapseds.push(false);
      });
      //update database
      $.post("{url action="updateNodes"}",
        {
          ids: ids,
          xs: xs,
          ys: ys,
          collapseds: collapseds
        },
        function(result){
          alert("Saved Successfully");
          $("#save").show();
        },
        "json"
      );
    });
  </script>
{/block}

{block name="sidebar"}
  {include file="./cardList.tpl"}
{/block}
