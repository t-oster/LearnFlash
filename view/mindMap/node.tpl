<div id="node{$node->getId()}" class="mindMapNode" style="top: {$node->getX()}px; left: {$node->getY()}px;">
  {if ($node->isMindMapCard())}
    Card: {$node->getCard()->getTitle()}
  {else}
    Map: {$node->getName()}
  {/if}
</div>