//These are filled by the Template
var mindMapLinks = {};
var saveChangesUrl = "";
var newNodeUrl = "";
var newLinkTextUrl = "";

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

var lastNewLinkId = 0;
function linkButtonClicked(nodeId)
{
  
  var selectedIds = [];
  $(".selectedNode").each(function(){selectedIds.push($(this).attr("id"))});
  if (selectedIds.length == 0)
  {//just mark the clicked node as selected
    $("#"+nodeId).addClass("selectedNode");
  }
  else
  {
    lastNewLinkId -= 1;
    var linkId = "link"+lastNewLinkId;
    mindMapLinks[linkId] = {
      id: lastNewLinkId,
      leftId: selectedIds[0],
      rightId: nodeId,
      text: "newLink",
      state: "new",
      leftArrow: false,
      rightArrow: false
    };
    updateLinkPosition(linkId);
    $.get(
      newLinkTextUrl, 
      {
        x: (mindMapLinks[linkId].x1 + mindMapLinks[linkId].x2) / 2,
        y: (mindMapLinks[linkId].y1 + mindMapLinks[linkId].y2) / 2,
        linkId: mindMapLinks[linkId].id,
        text: mindMapLinks[linkId].text
      },
      function (html)
      {
        $("#mindMap").append(html);
        $(".selectedNode").removeClass("selectedNode");
        drawLinks();
      },
      "html"
    );
  }
}

function deleteLink(linkIndex)
{
  var text = $("#"+linkIndex);
  if (text)
  {
    text.remove();
  }
  if (mindMapLinks[linkIndex].state == "new")
  {
    delete mindMapLinks[linkIndex];
  }
  else
  {
    mindMapLinks[linkIndex].state = "deleted";
  }
  drawLinks();
  success("Link deleted");
}

function addMindMap(name)
{
  lastNewId -= 1;
  $.get(newNodeUrl, {name: name, nodeId: lastNewId}, function(html){
    element = $(html);
    initializeNodeEvents(element);
    $("#mindMap").append(element);
    nodeInfos[element.attr("id")] = {id: lastNewId, state: "new", name: name};
    success("Map added");
  }, "html");
}

function deleteNode(nodeObject)
{
  var id = nodeObject.attr("id");
  //delete all links
  var idNr = id.substring(4);
  for (var i in mindMapLinks)
  {
    if (mindMapLinks[i].leftId == idNr || mindMapLinks[i].rightId == idNr)
    {
      deleteLink(i);
    }
  }
  if (nodeInfos[id] && nodeInfos[id].state == "new")
  {//if was a new node, just remove it
    delete nodeInfos[id];
  }
  else
  {
    nodeInfos[id] = {state: "deleted"};
  }
  nodeObject.fadeOut(500, function(){nodeObject.remove();});
}

//used to update only links connected to the currently dragged node
var connectedLinks = [];

function draggingStarted(node)
{
  connectedLinks = [];
  var id = $(node).attr("id");
  for (var i in mindMapLinks)
  {
    if (mindMapLinks[i].leftId == id || mindMapLinks[i].rightId == id)
    {
      connectedLinks.push(i);
    }
  }
}

function dragging()
{
  for (var i = 0; i < connectedLinks.length; i++)
  {
    updateLinkPosition(connectedLinks[i]);
  }
  drawLinks();
}

function nodeDragged(node)
{
  if (!nodeInfos[$(node).attr("id")])
  {
    nodeInfos[$(node).attr("id")] = {state: "updated"};
  }
}

function updateLinkPosition(linkIndex)
{
  var left = $("#"+mindMapLinks[linkIndex].leftId);   
  var right = $("#"+mindMapLinks[linkIndex].rightId);
  mindMapLinks[linkIndex].x1 = left.position().left + left.width() / 2;
  mindMapLinks[linkIndex].y1 = left.position().top + left.height() / 2;
  mindMapLinks[linkIndex].x2 = right.position().left + right.width() / 2;
  mindMapLinks[linkIndex].y2 = right.position().top + right.height() / 2;
  var text = $("#link"+mindMapLinks[linkIndex].id);
  if (text)
  {
    text.css("left", (mindMapLinks[linkIndex].x1+mindMapLinks[linkIndex].x2) / 2);
    text.css("top", (mindMapLinks[linkIndex].y1+mindMapLinks[linkIndex].y2) / 2);
  }
}

function drawLinks()
{
  var canvas = document.getElementById('linkLayer');
  if (canvas.width != $("#mindMap").width() || canvas.height != $("#mindMap").height())
  {
    canvas.width = $("#mindMap").width();
    canvas.height = $("#mindMap").height();
  }
  var ctx = canvas.getContext('2d');
  ctx.clearRect(0,0,canvas.width,canvas.height)
  for (var i in mindMapLinks)
  {
    var l = mindMapLinks[i];
    if (l && l.state != "deleted")
    {
      drawLine(ctx, l.x1, l.y1, l.x2, l.y2);
    }
  }
}

/**
 * Creates a new MindMapCard for the given card id.
 * More precise: the CardHtml is fetched from the server
 * and an Entry in nodeInfos is generated.
 * The actual save should happen in the saveChanges method
 */
var lastNewId = 0;
function addCard(cardId)
{
  lastNewId -= 1;
  $.get(newNodeUrl, {cardId: cardId, nodeId: lastNewId}, function(html){
    element = $(html);
    initializeNodeEvents(element);
    $("#mindMap").append(element);
    nodeInfos[element.attr("id")] = {id: lastNewId, state: "new", cardId: cardId};
    success("Card added");
  }, "html");
}

function saveChanges()
{
  $("#save").attr("disabled","disabled");
  //changes in format {type: map|card|link, state: new|updated|deleted, (x, y, collapsed, text |name)}
  var changes = [];
  //collect infos on DELETED links
  for (var i in mindMapLinks)
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
  //collect infos on NEW/UPDATED links
  for (var j in mindMapLinks)
  {
    var li = mindMapLinks[j];
    if (li.state != "deleted")
    {
      li.type = "link";
      changes.push(li);
    }
  }
  //update database
  $.post(saveChangesUrl,
    { changesAsJson: JSON.stringify(changes) },
    function(errors){
        if (errors.length == 0)
        {
          success("Saved Successfully");
          mindMapLinks = [];
          nodeInfos = {};
          window.location.reload(true);
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

function initializeNodeEvents(nodeElement)
{
  nodeElement.draggable({
    containment: "parent",
    start: function(event) {draggingStarted(event.target)},
    drag: dragging,
    stop: function(event) {nodeDragged(event.target)}
  });
  nodeElement.find(".deleteLink").click(function(){deleteNode($(this).parents(".mindMapNode"));});
}

function askConfirmationIfUnsaved()
{
  var dirty = false;
  for (var i = 0; i < mindMapLinks.length; i++)
  {
    var l = mindMapLinks[i];
    if (l != undefined && l.state != "clean")
    {
      dirty = true;
      break;
    }
  }
  if (dirty == false)
  {
    for (k in nodeInfos)
    {
      if (nodeInfos[k] != undefined)
      {
        dirty = true;
        break;
      }
    }
  }
  if (dirty)
  {
    return "you have unsaved changes";
  }
}

$(document).ready(function(){
  $(".mindMapNode").each(function(){initializeNodeEvents($(this));});
  $("#save").click(saveChanges);
  for (var i in mindMapLinks)
  {
    updateLinkPosition(i);
  }
  drawLinks();
  //$(window).bind('beforeunload', askConfirmationIfUnsaved);
});
