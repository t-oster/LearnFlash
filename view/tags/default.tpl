{extends file="../main.tpl"}
{block name="head"}
  <link rel="stylesheet" href="lib/js/jqcloud.css" />
  <script src="lib/js/jqcloud-1.0.2.min.js"></script>
{/block}
{block name="content"}
<div id="wordcloud" style="width: 800px; height: 600px; position: relative;"></div>
<script type="text/javascript">
  $(document).ready(function() {
     $("#wordcloud").jQCloud([
      {foreach $tags as $t}
        {
          text: "{$t->getName()}",
          weight: "{count($t->getCards())}",
          link: "{url controller="Tags" action="show" tagId=$t->getId()}"
        },
      {/foreach}
    ]);
  });
</script>
{/block}