<ul>
  <?php foreach ($products as $product): ?>
    <li>
      <?php echo $this->renderPartial('_product', array('product' => $product)) ?>
    </li>
  <?php endforeach; ?>
</ul>

<ul>
  <li><a href="<?php echo $this->createUrl('site/route_1', array('slug' => 1)) ?>">Menu 1</a></li>
  <li><a href="<?php echo $this->createUrl('site/route_2', array('slug' => 2)) ?>">Menu 2</a></li>
  <li><a href="<?php echo $this->createUrl('site/route_3', array('slug' => 3)) ?>">Menu 3</a></li>
  <li><a href="<?php echo $this->createUrl('site/route_4', array('slug' => 4)) ?>">Menu 4</a></li>
  <li><a href="<?php echo $this->createUrl('site/route_5', array('slug' => 5)) ?>">Menu 5</a></li>
  <li><a href="<?php echo $this->createUrl('site/route_6', array('slug' => 6)) ?>">Menu 6</a></li>
  <li><a href="<?php echo $this->createUrl('site/route_7', array('slug' => 7)) ?>">Menu 7</a></li>
  <li><a href="<?php echo $this->createUrl('site/route_8', array('slug' => 8)) ?>">Menu 8</a></li>
  <li><a href="<?php echo $this->createUrl('site/route_9', array('slug' => 9)) ?>">Menu 9</a></li>
  <li><a href="<?php echo $this->createUrl('site/route_10', array('slug' => 10)) ?>">Menu 10</a></li>
  <li><a href="<?php echo $this->createUrl('site/route_11', array('slug' => 11)) ?>">Menu 11</a></li>
  <li><a href="<?php echo $this->createUrl('site/route_12', array('slug' => 12)) ?>">Menu 12</a></li>
  <li><a href="<?php echo $this->createUrl('site/route_13', array('slug' => 13)) ?>">Menu 13</a></li>
  <li><a href="<?php echo $this->createUrl('site/route_14', array('slug' => 14)) ?>">Menu 14</a></li>
  <li><a href="<?php echo $this->createUrl('site/route_15', array('slug' => 15)) ?>">Menu 15</a></li>
</ul>
