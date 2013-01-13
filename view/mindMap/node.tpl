<div id="node{$nodeId}" class="mindMapNode{if $node->isMindMapCard()} mindMapCard{else} mindMap{/if}{if $node->isCollapsed()} collapsed{/if}" style="top: {$node->getY()}px; left: {$node->getX()}px;">
  <a class="deleteLink" href="javascript:deleteNode('node{$nodeId}');"></a>
  <a class="linkLink" href="javascript:linkButtonClicked('node{$nodeId}');">Link</a>
  <a class="toggleLink" href="javascript:toggleNodeCollapsed('node{$nodeId}');"></a>
  {if ($node->isMindMapCard())}
    {$node->getCard()->getTitle()}
    <div class="collapsedCard">
      <p>Q: {substr(strip_tags($node->getCard()->getFrontHtml()), 0, 20)}...</p>
      <p>A: {substr(strip_tags($node->getCard()->getBackHtml()), 0, 20)}...</p>
    </div>
    <div class="uncollapsedCard">
      <div class="frontSide">
        {$node->getCard()->getFrontHtml()}
      </div>
      <div class="backSide">
        {$node->getCard()->getBackHtml()}
      </div>
    </div>
  {else}
    <a href="{url action="show" mindMapId=$node->getId()}">Map: {$node->getName()}</a>
  {/if}
</div>