<ul>
  <?php foreach ($products as $product): ?>
    <li>
      <?php include_partial('product', array('product' => $product)) ?>
    </li>
  <?php endforeach; ?>
</ul>

<ul>
  <li><a href="<?php echo url_for('@route_1?slug=1') ?>">Menu 1</a></li>
  <li><a href="<?php echo url_for('@route_2?slug=2') ?>">Menu 2</a></li>
  <li><a href="<?php echo url_for('@route_3?slug=3') ?>">Menu 3</a></li>
  <li><a href="<?php echo url_for('@route_4?slug=4') ?>">Menu 4</a></li>
  <li><a href="<?php echo url_for('@route_5?slug=5') ?>">Menu 5</a></li>
  <li><a href="<?php echo url_for('@route_6?slug=6') ?>">Menu 6</a></li>
  <li><a href="<?php echo url_for('@route_7?slug=7') ?>">Menu 7</a></li>
  <li><a href="<?php echo url_for('@route_8?slug=8') ?>">Menu 8</a></li>
  <li><a href="<?php echo url_for('@route_9?slug=9') ?>">Menu 9</a></li>
  <li><a href="<?php echo url_for('@route_10?slug=10') ?>">Menu 10</a></li>
  <li><a href="<?php echo url_for('@route_11?slug=11') ?>">Menu 11</a></li>
  <li><a href="<?php echo url_for('@route_12?slug=12') ?>">Menu 12</a></li>
  <li><a href="<?php echo url_for('@route_13?slug=13') ?>">Menu 13</a></li>
  <li><a href="<?php echo url_for('@route_14?slug=14') ?>">Menu 14</a></li>
  <li><a href="<?php echo url_for('@route_15?slug=15') ?>">Menu 15</a></li>
</ul>
