{extends file="../main.tpl"}
{block name="content"}
You have an unfinished learning block of {count($smarty.session.toLearn)} cards.
<p><a class="button" href="{url action="next"}">Continue</a>
 
<a class="button" href="{url action="default" ignoreSession="true"}">Ignore</a></p>
{/block}