<div id="node{$nodeId}" class="mindMapNode {if $node->isMindMapCard()}mindMapCard{else}mindMap{/if}" style="top: {$node->getY()}px; left: {$node->getX()}px;">
  <a class="deleteLink"></a>
  <a class="linkLink" href="javascript:linkButtonClicked('node{$nodeId}');">Link</a>
  {if ($node->isMindMapCard())}
    Card: {$node->getCard()->getTitle()}
  {else}
    <a href="{url action="show" mindMapId=$node->getId()}">Map: {$node->getName()}</a>
  {/if}
</div>