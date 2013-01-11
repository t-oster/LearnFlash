<div id="node{$node->getId()}" class="mindMapNode {if $node->isMindMapCard()}mindMapCard{else}mindMap{/if}" style="top: {$node->getY()}px; left: {$node->getX()}px;">
  <a class="deleteLink"></a>
  {if ($node->isMindMapCard())}
    Card: {$node->getCard()->getTitle()}
  {else}
    Map: {$node->getName()}
  {/if}
</div>