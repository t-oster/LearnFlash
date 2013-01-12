<div {if $link->getId() != null}id="link{$link->getId()}"{/if} class="linkText" style="top: {$y}px; left: {$x}px;">
  <a href="javascript:deleteLinkById({$link->getId()});" class="deleteLink"></a>
  {$link->getText()}
</div>