{foreach $cards as $c}
  <li onclick="addNodeForCard({$c->getId()})">{$c->getTitle()}</li>
{/foreach}