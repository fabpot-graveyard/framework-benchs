<ul>
  <?php foreach ($products as $product): ?>
    <li>
      <?php echo $this->element('_product', array('product' => $product)) ?>
    </li>
  <?php endforeach; ?>
</ul>

<ul>
  <li><a href="<?php echo Router::url(array('action' => 'route_1',  'controller' => 'products', 'slug' => 1)) ?>">Menu 1</a></li>
  <li><a href="<?php echo Router::url(array('action' => 'route_2',  'controller' => 'products', 'slug' => 2)) ?>">Menu 2</a></li>
  <li><a href="<?php echo Router::url(array('action' => 'route_3',  'controller' => 'products', 'slug' => 3)) ?>">Menu 3</a></li>
  <li><a href="<?php echo Router::url(array('action' => 'route_4',  'controller' => 'products', 'slug' => 4)) ?>">Menu 4</a></li>
  <li><a href="<?php echo Router::url(array('action' => 'route_5',  'controller' => 'products', 'slug' => 5)) ?>">Menu 5</a></li>
  <li><a href="<?php echo Router::url(array('action' => 'route_6',  'controller' => 'products', 'slug' => 6)) ?>">Menu 6</a></li>
  <li><a href="<?php echo Router::url(array('action' => 'route_7',  'controller' => 'products', 'slug' => 7)) ?>">Menu 7</a></li>
  <li><a href="<?php echo Router::url(array('action' => 'route_8',  'controller' => 'products', 'slug' => 8)) ?>">Menu 8</a></li>
  <li><a href="<?php echo Router::url(array('action' => 'route_9',  'controller' => 'products', 'slug' => 9)) ?>">Menu 9</a></li>
  <li><a href="<?php echo Router::url(array('action' => 'route_10', 'controller' => 'products', 'slug' => 10)) ?>">Menu 10</a></li>
  <li><a href="<?php echo Router::url(array('action' => 'route_11', 'controller' => 'products', 'slug' => 11)) ?>">Menu 11</a></li>
  <li><a href="<?php echo Router::url(array('action' => 'route_12', 'controller' => 'products', 'slug' => 12)) ?>">Menu 12</a></li>
  <li><a href="<?php echo Router::url(array('action' => 'route_13', 'controller' => 'products', 'slug' => 13)) ?>">Menu 13</a></li>
  <li><a href="<?php echo Router::url(array('action' => 'route_14', 'controller' => 'products', 'slug' => 14)) ?>">Menu 14</a></li>
  <li><a href="<?php echo Router::url(array('action' => 'route_15', 'controller' => 'products', 'slug' => 15)) ?>">Menu 15</a></li>
</ul>
