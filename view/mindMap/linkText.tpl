<div id="link{$linkId}" class="linkText" style="top: {$y}px; left: {$x}px;">
  <a href="javascript:deleteLink('link{$linkId}');" class="deleteLink"></a>
  <a href="javascript:editLink('link{$linkId}');" class="editLink"></a>
  <span class="text">{$link->getText()}</span>
</div>