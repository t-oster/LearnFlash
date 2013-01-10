var links = [];
var updateNodesUrl = "";

function drawLinks()
{
//TODO: Draw links in canvas
}

function saveChanges()
{
  $("#save").attr("disabled","disabled");
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
    containment: "parent"
  });
  $("#save").click(saveChanges);  
});
