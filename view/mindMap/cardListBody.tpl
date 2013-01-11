{foreach $cards as $c}
  <li>{$c->getTitle()} <a href="#" class="addLink" onclick="addNodeForCard({$c->getId()})">add</a></li>
{/foreach}