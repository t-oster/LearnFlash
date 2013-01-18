<script type="text/javascript">
  {if $tag == null}
    $("#tags .tag").addClass("grey");
  {/if}
  $("#rdAll").click(function(){
    $("#tags input").attr("disabled", "disabled");
    $("#tags .tag").addClass("grey");
  });
  $("#rdTags").click(function(){
    $("#tags input").removeAttr("disabled");
    $("#tags .tag").removeClass("grey");
  });
  function updateInfo()
  {
    $("#countAll").html("");
    $("#countUnlearned").html("");
    $.getJSON("{url controller='learn' action="countSelection"}", $("#form").serialize(), function(result){
      if(result.all==0)
      {
        $("#go").attr("disabled", "disabled");    
      }
      else 
      {
        $("#go").removeAttr("disabled");
      }
      $("#countAll").html(result.all);
      $("#countUnlearned").html(result.unlearned);
    });
  }
  $(".updateInfo").click(updateInfo);
  updateInfo();
</script>
