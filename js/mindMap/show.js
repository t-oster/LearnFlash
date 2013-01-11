//These are filled by the Template
var mindMapLinks = [];
var updateNodesUrl = "";
var updateLinksUrl = "";

//a map indexed by the nodeId and mapping
//to either "changed" or "new" or "deleted"
//used to keep track of changed/added nodes
var nodeStates = {};

function drawLine(ctx, x1, y1, x2, y2)
{
  ctx.lineWidth = 1;
  ctx.beginPath();
  ctx.moveTo(x1, y1);
  ctx.lineTo(x2, y2);
  ctx.stroke();
}

function deleteNode(nodeObject)
{
  var id = nodeObject.attr("id");
  if (nodeStates[id] == "new")
  {//if was a new node, just remove it
    delete nodeStates[id];
  }
  else
  {
    nodeStates[id] = "deleted";
    nodeObject.fadeOut(500, function(){nodeObject.remove();});
  }
  var idNr = id.substring(4);
  for (var i = 0; i < mindMapLinks.length; i++)
  {
    if (mindMapLinks[i].leftId == idNr || mindMapLinks[i].rightId == idNr)
    {
      if (mindMapLinks[i].state == "new")
      {
        delete mindMapLinks[i];
      }
      else
      {
        mindMapLinks[i].state = "deleted";
      }
    }
  }
  drawLinks();
}

function nodeDragged(node)
{
  if (!nodeStates[$(node).attr("id")])
  {
    nodeStates[$(node).attr("id")] = "changed";
  }
}

function drawLinks()
{
  var canvas = document.getElementById('linkLayer');
  var ctx = canvas.getContext('2d');
  ctx.clearRect(0,0,canvas.width,canvas.height)
  for (var i = 0; i < mindMapLinks.length; i++)
  {
    if (mindMapLinks[i] && mindMapLinks[i].state != "deleted")
    {
      var left = $("#node"+mindMapLinks[i].leftId);   
      var right = $("#node"+mindMapLinks[i].rightId);
      var x1 = left.position().left + left.width() / 2;
      var y1 = left.position().top + left.height() / 2;
      var x2 = right.position().left + right.width() / 2;
      var y2 = right.position().top + right.height() / 2;
      drawLine(ctx, x1, y1, x2, y2);
    }
  }
}

function saveChanges()
{
  $("#save").attr("disabled","disabled");
  var ids = [];
  var xs = [];
  var ys = [];
  var collapseds = [];
  //collect infos
  foreach ()
  nodeStates.foreach(function(id, state){
    if (state == "changed")
    {
      //remove the "node" prefix from the id
      ids.push(id.substring(4));
      //remove the "px" suffix from the x and y
      xs.push($("#"+id).position().left);
      ys.push($("#"+id).position().top);
      //TODO update collapsed state
      collapseds.push(false);
    }
    else if (state == "new")
    {
      //TODO create method to create new nodes
    }
    else if (state == "deleted")
    {
      //TODO
    }
  });
  //update database
  $.post(updateNodesUrl,
  {
    ids: ids,
    xs: xs,
    ys: ys,
    collapseds: collapseds
  },
  function(result){
    success("Saved Successfully");
    $("#save").removeAttr("disabled");
  },
  "json"
  );
}

$(document).ready(function(){
  $(".mindMapNode").draggable({
    containment: "parent",
    drag: drawLinks,
    stop: function(event, ui) {nodeDragged(event.target)}
  });
  $(".mindMapNode .deleteLink").click(function(){deleteNode($(this).parents(".mindMapNode"));});
  $("#save").click(saveChanges);
  drawLinks();
});
