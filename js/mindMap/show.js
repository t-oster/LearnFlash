//These are filled by the Template
var mindMapLinks = [];
var saveChangesUrl = "";

//a map indexed by the nodeId and mapping
//to infos containing state: "updated" or "new" or "deleted"
//used to keep track of changed/added nodes
var nodeInfos = {};

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
  if (nodeInfos[id] && nodeInfos[id].state == "new")
  {//if was a new node, just remove it
    delete nodeInfos[id];
  }
  else
  {
    nodeInfos[id] = {state: "deleted"};
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
  if (!nodeInfos[$(node).attr("id")])
  {
    nodeInfos[$(node).attr("id")] = {state: "updated"};
  }
  drawLinks();
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
  //changes in format {type: map|card|link, state: new|updated|deleted, (x, y, collapsed, text |name)}
  var changes = [];
  //collect infos on links
  for (var i = 0; i < mindMapLinks.length; i++)
  {
    var l = mindMapLinks[i];
    if (l.state == "deleted")
    {
      changes.push({
        state: l.state,
        type: "link",
        id: l.id
      });
    }
    else if (l.state == "updated" || l.state == "new")
    {
      l.type = "link";
      changes.push(l);
    }
  }
  //collect infos on cards and maps
  for (var eid in nodeInfos)
  {
    var element = $("#"+eid);
    var info = nodeInfos[eid];
    //remove the node-prefix to get the db-id
    var id = eid.substring(4);
    var type = element.hasClass("mindMapCard") ? "card" : "map";
    if (info.state == "deleted")
    {
      changes.push({
        state: info.state,
        type: type,
        id: id
      });
    }
    else
    {
      changes.push({
        type: type,
        state: info.state,
        id: id,//used only for state=changed
        x: element.position().left,
        y: element.position().top,
        collapsed: false, //TODO
        name: info.name,//used only for type=map
        cardId: info.cardId,//used only for type=card
      });
    }
  }
  //TODO collect infos on links
  //update database
  $.post(saveChangesUrl,
    { changesAsJson: JSON.stringify(changes) },
    function(errors){
        if (errors.length == 0)
        {
          success("Saved Successfully");
          nodeInfos = {};
          //TODO reset changes, set links to clean
        }
        else
        {
          for(var k = 0; k < errors.length; k++)
          {
            error(errors[k]);
          }
        }
        $("#save").removeAttr("disabled");
    },
    "json"
    );
}

$(document).ready(function(){
  $(".mindMapNode").draggable({
    containment: "parent",
    stop: function(event, ui) {nodeDragged(event.target)}
  });
  $(".mindMapNode .deleteLink").click(function(){deleteNode($(this).parents(".mindMapNode"));});
  $("#save").click(saveChanges);
  drawLinks();
});
