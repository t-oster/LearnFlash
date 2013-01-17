{extends file="../main.tpl"}
{block name="head"}
<link rel="stylesheet" href="css/cards.css" />
<script type="text/javascript"
  src="https://c328740.ssl.cf1.rackcdn.com/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
</script>
{/block}
{block name="content"}
<h2>{$card->getTitle()}</h2><a class="editlink edit" href="{url action="edit" cardId=$card->getId()}">Edit</a>
<div id="frontSide">
  {$frontHtml}
</div>
<div id="backSide">
  {$backHtml}
</div>
<h2>Tags</h2>
{include file="../tags/taglist.tpl" tags=$card->getTags()}
{/block}