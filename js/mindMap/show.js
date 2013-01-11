var links = [];
var updateNodesUrl = "";

function drawLinks()
{
  var ctx = document.getElementById('linkLayer').getContext('2d');
  ctx.fillStyle = "rgba(0, 0, 200, 0.5)";
  for (var i = 0; i < links.length; i++)
  {
    var x1 = $("#node"+links[i].leftId).attr("left");
    var y1 = $("#node"+links[i].leftId).attr("top");
    var x2 = $("#node"+links[i].rightId).attr("left");
    var y2 = $("#node"+links[i].rightId).attr("top");
    ctx.moveTo(x1, y1);
    ctx.lineTo(x2, y2);
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
  drawLinks();
});
