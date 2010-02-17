<ul>
  <?php foreach ($this->products as $product): ?>
    <li>
      <?php echo $this->partial('_product', array('product' => $product)) ?>
    </li>
  <?php endforeach; ?>
</ul>

<ul>
  <li><?php echo $this->action('route_1/1', 'Menu 1') ?></li>
  <li><?php echo $this->action('route_2/2', 'Menu 2') ?></li>
  <li><?php echo $this->action('route_3/3', 'Menu 3') ?></li>
  <li><?php echo $this->action('route_4/4', 'Menu 4') ?></li>
  <li><?php echo $this->action('route_5/5', 'Menu 5') ?></li>
  <li><?php echo $this->action('route_6/6', 'Menu 6') ?></li>
  <li><?php echo $this->action('route_7/7', 'Menu 7') ?></li>
  <li><?php echo $this->action('route_8/8', 'Menu 8') ?></li>
  <li><?php echo $this->action('route_9/9', 'Menu 9') ?></li>
  <li><?php echo $this->action('route_10/10', 'Menu 10') ?></li>
  <li><?php echo $this->action('route_11/11', 'Menu 11') ?></li>
  <li><?php echo $this->action('route_12/12', 'Menu 12') ?></li>
  <li><?php echo $this->action('route_13/13', 'Menu 13') ?></li>
  <li><?php echo $this->action('route_14/14', 'Menu 14') ?></li>
  <li><?php echo $this->action('route_15/15', 'Menu 15') ?></li>
</ul>
