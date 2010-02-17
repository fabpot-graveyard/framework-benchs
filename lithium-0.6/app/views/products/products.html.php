<ul>
  <?php foreach ($products as $product): ?>
    <li>
      <?php echo $this->view()->render(array('element' => 'product'), compact('product')) ?>
    </li>
  <?php endforeach; ?>
</ul>

<ul>
  <li><?php echo $this->html->link('Menu 1', array('controller'  => 'products', 'action' => 'route_1', 'slug' => 1), array('escape' => false)) ?></li>
  <li><?php echo $this->html->link('Menu 2', array('controller'  => 'products', 'action' => 'route_2', 'slug' => 2), array('escape' => false)) ?></li>
  <li><?php echo $this->html->link('Menu 3', array('controller'  => 'products', 'action' => 'route_3', 'slug' => 3), array('escape' => false)) ?></li>
  <li><?php echo $this->html->link('Menu 4', array('controller'  => 'products', 'action' => 'route_4', 'slug' => 4), array('escape' => false)) ?></li>
  <li><?php echo $this->html->link('Menu 5', array('controller'  => 'products', 'action' => 'route_5', 'slug' => 5), array('escape' => false)) ?></li>
  <li><?php echo $this->html->link('Menu 6', array('controller'  => 'products', 'action' => 'route_6', 'slug' => 6), array('escape' => false)) ?></li>
  <li><?php echo $this->html->link('Menu 7', array('controller'  => 'products', 'action' => 'route_7', 'slug' => 7), array('escape' => false)) ?></li>
  <li><?php echo $this->html->link('Menu 8', array('controller'  => 'products', 'action' => 'route_8', 'slug' => 8), array('escape' => false)) ?></li>
  <li><?php echo $this->html->link('Menu 9', array('controller'  => 'products', 'action' => 'route_9', 'slug' => 9), array('escape' => false)) ?></li>
  <li><?php echo $this->html->link('Menu 10', array('controller' => 'products', 'action' => 'route_10', 'slug' => 10), array('escape' => false)) ?></li>
  <li><?php echo $this->html->link('Menu 11', array('controller' => 'products', 'action' => 'route_11', 'slug' => 11), array('escape' => false)) ?></li>
  <li><?php echo $this->html->link('Menu 12', array('controller' => 'products', 'action' => 'route_12', 'slug' => 12), array('escape' => false)) ?></li>
  <li><?php echo $this->html->link('Menu 13', array('controller' => 'products', 'action' => 'route_13', 'slug' => 13), array('escape' => false)) ?></li>
  <li><?php echo $this->html->link('Menu 14', array('controller' => 'products', 'action' => 'route_14', 'slug' => 14), array('escape' => false)) ?></li>
  <li><?php echo $this->html->link('Menu 15', array('controller' => 'products', 'action' => 'route_15', 'slug' => 15), array('escape' => false)) ?></li>
</ul>
