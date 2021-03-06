<div id="node{$nodeId}" class="mindMapNode{if $node->isMindMapCard()} mindMapCard{else} mindMap{/if}{if $node->isCollapsed()} collapsed{/if}" style="z-index: {$node->getZ()}; top: {$node->getY()}px; left: {$node->getX()}px; width: {$node->getWidth()}px; height: {$node->getHeight()}px;">
  <a class="deleteLink" href="javascript:deleteNode('node{$nodeId}');"></a>
  <a class="linkLink" href="javascript:linkButtonClicked('node{$nodeId}');"></a>
  {if ($node->isMindMapCard())}
  <a class="toggleLink" href="javascript:toggleNodeCollapsed('node{$nodeId}');"></a>
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
  <center>
    <h4>{$node->getName()}</h4>
    <a class="button" href="{url action="show" mindMapId=$node->getId()}">Open</a>
  </center>
  {/if}
</div>