var mindMapLinks = [];
var updateNodesUrl = "";

function drawLine(ctx, x1, y1, x2, y2)
{
  ctx.lineWidth = 1;
  ctx.beginPath();
  ctx.moveTo(x1, y1);
  ctx.lineTo(x2, y2);
  ctx.stroke();
}

function drawLinks()
{
  var canvas = document.getElementById('linkLayer');
  var ctx = canvas.getContext('2d');
  ctx.clearRect(0,0,canvas.width,canvas.height)
  for (var i = 0; i < mindMapLinks.length; i++)
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
    containment: "parent",
    drag: drawLinks
  });
  $("#save").click(saveChanges);
  drawLinks();
});
