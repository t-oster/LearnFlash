//These are filled by the Template
var mindMapLinks = {};
var saveChangesUrl = "";
var newNodeUrl = "";
var newLinkTextUrl = "";

//a map indexed by the nodeId and mapping
//to infos containing state: "updated" or "new" or "deleted"
//used to keep track of changed/added nodes
var nodeInfos = {};

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
    if (nodeId == selectedIds[0])
    {//don't allow self-links'
      $("#"+nodeId).removeClass("selectedNode");
      return;
    }
    //TODO: Check if link already exists...
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
    createLinkDiv(linkId);
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
        editLink(linkId);
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
  $("#"+linkIndex).remove();
  success("Link deleted");
}

function updateLinkFromForm()
{
  $("#editLinkDialog").dialog("close");
  var text = $("#eldText").val();
  var linkId = $("#eldLinkId").val();
  //update linkInfo
  mindMapLinks[linkId].text = text;
  mindMapLinks[linkId].leftArrow = ($("#eldLeftArrow").attr("checked") == "checked");
  mindMapLinks[linkId].rightArrow = ($("#eldRightArrow").attr("checked") == "checked");
  if (mindMapLinks[linkId].state == "clean")
  {
    mindMapLinks[linkId].state = "updated";
  }
  //update text in view
  $("#"+linkId).find(".text").html(text);
  updateLinkPosition(linkId);
}

function editLink(linkId)
{
  $("#eldLinkId").val(linkId);
  $("#eldText").val(mindMapLinks[linkId].text);
  if (mindMapLinks[linkId].leftArrow)
    $("#eldLeftArrow").attr("checked", "checked")
  else
    $("#eldLeftArrow").removeAttr("checked");
  if (mindMapLinks[linkId].rightArrow)
    $("#eldRightArrow").attr("checked", "checked")
  else
    $("#eldRightArrow").removeAttr("checked");
  $("#editLinkDialog").dialog("open");
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

function deleteNode(id)
{
  //delete all links
  for (var i in mindMapLinks)
  {
    if (mindMapLinks[i].leftId == id || mindMapLinks[i].rightId == id)
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
  var nodeObject = $("#"+id);
  nodeObject.fadeOut(500, function(){nodeObject.remove();});
}

//used to update only links connected to the currently dragged node
var connectedLinks = [];

function draggingStarted(node)
{
  var id = $(node).attr("id");
  for (var i in mindMapLinks)
  {
    if (mindMapLinks[i].leftId == id || mindMapLinks[i].rightId == id)
    {
      connectedLinks.push(i);
    }
  }
}

function draggingActive(node)
{
  for (var i = 0; i < connectedLinks.length; i++)
  {
    updateLinkPosition(connectedLinks[i]);
  }
}

function markAsDirty(node)
{
  //mark note as modified
  if (!nodeInfos[$(node).attr("id")])
  {
    nodeInfos[$(node).attr("id")] = {state: "updated"};
  }
}

function draggingStopped(node)
{
  markAsDirty(node);
  connectedLinks = [];
}

function updateLinkPosition(linkIndex)
{

  if (mindMapLinks[linkIndex].state == "deleted")
  {
    return;
  }
  

  var arrow = $('#'+linkIndex+'Arrow');
  //left node
  var left = $("#"+mindMapLinks[linkIndex].leftId);   
  //right node
  var right = $("#"+mindMapLinks[linkIndex].rightId);
  var x1 = left.position().left + (left.width()/2);
  var y1 = left.position().top + (left.height()/2);
  var x2 = right.position().left + (right.width()/2);
  var y2 = right.position().top + (right.height()/2);
  //dimensions of arrow
  var w = Math.sqrt((x1-x2)*(x1-x2));
  var h = Math.sqrt((y1-y2)*(y1-y2));
  var d1;
  var d2; 
  //coords of postition between two cards
  var centerX = (x1+x2)/2;
  var centerY = (y1+y2)/2;
  var distance = Math.sqrt((x1-x2)*(x1-x2) + (y1-y2)*(y1-y2));
  
  var text = $("#link"+mindMapLinks[linkIndex].id);
  if (text)
  {
    text.css("left", centerX-text.width()+"px");
    text.css("top", centerY-text.height()+"px");
  }
  d1 = Math.sqrt(left.height()*left.height()+left.width()*left.width())/2;
  d2 = Math.sqrt(right.height()*right.height()+right.width()*right.width())/2;

  arrow.css("width",distance-d1-d2);
  arrow.css("left",(-arrow.width()/2)+"px");
  arrow.css("top",(-arrow.height()/2)+"px");
  var translate = "translate("+(centerX)+"px, "+(centerY)+"px)";
  var angle = Math.acos(w/distance);
  if((x2>x1 && y2<y1) || (x2<x1 && y2>y1)){
    angle = "rotate(-"+angle+"rad)";

  }else{
    angle = "rotate("+angle+"rad)";
    //d1 = left.width()/2/w* distance;
    //d2 = right.width()/2/w* distance;
  }
  arrow.css("-moz-transform",translate+" "+angle);
  arrow.css("-webkit-transform",translate+" "+angle);
  arrow.css("-o-transform",translate+" "+angle);
  arrow.css("transform",translate+" "+angle);
}

function createLinkDiv(linkIndex)
{
  var link = mindMapLinks[linkIndex];
  var linkDiv = $("<div id='"+linkIndex+"Arrow' class='arrow_box'> </div>");
  $("#mindMap").append(linkDiv);
  updateLinkPosition(linkIndex);
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
  $.get(newNodeUrl, {cardId: cardId, nodeId: lastNewId, collapsed: true}, function(html){
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
        z: element.css("z-index"),
        width: element.css("width").slice(0, -2),//TODO test
        height: element.css("height").slice(0, -2),
        collapsed: element.hasClass("collapsed"),
        name: info.name,//used only for type=map
        cardId: info.cardId//used only for type=card
      });
    }
  }
  //collect infos on NEW/UPDATED links
  for (var j in mindMapLinks)
  {
    var li = mindMapLinks[j];
    if (li.state == "updated" || li.state == "new")
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
  var o = $("#mindMap");
  nodeElement.draggable({
    scroll: true,
    stack: "#mindMap .mindMapNode",
    start: function(event) {draggingStarted(event.target)},
    drag: function(event, ui) {
        if (nodeElement.position().top > o.height() - nodeElement.height()) {
            o.height(o.height() + 10);
        }
        if (nodeElement.position().left > o.width() - nodeElement.width()) {
            o.width(o.width() + 10);
        }
        draggingActive(nodeElement);
    },
    stop: function(event) {draggingStopped(event.target)}
  });
  nodeElement.resizable({
    stop: function(event) {markAsDirty(nodeElement);}
  });
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

function toggleNodeCollapsed(nodeId)
{
  var node = $("#"+nodeId);
  node.toggleClass("collapsed");
  node.css("width", "auto");
  node.css("height", "auto");
  if (!nodeInfos[nodeId])
  {
    nodeInfos[nodeId] = {
      id: nodeId.substring(4),
      state: "updated"
    }
  }
}

$(document).ready(function(){
  $(".mindMapNode").each(function(){initializeNodeEvents($(this));});
  for (var i in mindMapLinks)
  {
    createLinkDiv(i);
  }
  $(window).bind('beforeunload', askConfirmationIfUnsaved);
});