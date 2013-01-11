<div id="node{$node->getId()}" class="mindMapNode" style="top: {$node->getY()}px; left: {$node->getX()}px;">
  <a class="deleteLink"></a>
  {if ($node->isMindMapCard())}
    Card: {$node->getCard()->getTitle()}
  {else}
    Map: {$node->getName()}
  {/if}
</div>