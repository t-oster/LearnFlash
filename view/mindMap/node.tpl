<div {if $node->getId() != null}id="node{$node->getId()}"{/if} class="mindMapNode {if $node->isMindMapCard()}mindMapCard{else}mindMap{/if}" style="top: {$node->getY()}px; left: {$node->getX()}px;">
  <a class="deleteLink"></a>
  {if ($node->isMindMapCard())}
    Card: {$node->getCard()->getTitle()}
  {else}
    Map: {$node->getName()}
  {/if}
</div>