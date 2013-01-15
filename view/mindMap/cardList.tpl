<h3>cards</h3>
<label for="tag">Tag:</label>
<select id="tag" name="tag">
  {foreach $tags as $tag}
    <option value="{$tag->getId()}">{$tag->getName()}</option>
  {/foreach}
  <option value="-1">All</option>
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