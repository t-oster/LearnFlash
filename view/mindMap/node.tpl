<div {if $node->getId() != null}id="node{$node->getId()}"{/if} class="mindMapNode {if $node->isMindMapCard()}mindMapCard{else}mindMap{/if}" style="top: {$node->getY()}px; left: {$node->getX()}px;">
  <a class="deleteLink"></a>
  <a class="linkLink" href="javascript:linkButtonClicked('node{$node->getId()}');">Link</a>
  {if ($node->isMindMapCard())}
    Card: {$node->getCard()->getTitle()}
  {else}
    <a href="{url action="show" mindMapId=$node->getId()}">Map: {$node->getName()}</a>
  {/if}
</div>