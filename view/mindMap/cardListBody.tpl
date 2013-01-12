{foreach $cards as $c}
  <li>{$c->getTitle()} <a href="javascript:addCard({$c->getId()})" class="addLink">add</a></li>
{/foreach}