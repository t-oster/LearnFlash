<label for="tag">Tag:</label>
<select id="tag" name="tag">
   <option value="-1">All</option>
  {foreach $tags as $tag}
    <option value="{$tag->getId()}">{$tag->getName()}</option>
  {/foreach}
</select>
<ul id="clbody">
  {include file="./cardListBody.tpl"}
</ul>
<script type="text/javascript">
  $("#tag").change(function(){
    $("#clbody").empty();
    $.get(
      "{url action="cardListBody"}", 
      { tagId: $("#tag").val()}, 
      function(data){
        $("#clbody").html(data);
      },
      "html"
    );
  });
</script>