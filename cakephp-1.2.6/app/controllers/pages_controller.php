<?php
class PagesController extends AppController {

	var $name = 'Pages';
  var $layout = null;
  var $autoLayout = false;
  var $uses = null;
  var $helpers = null;
  var $components = null;

	function hello() {
    $this->set('name', $this->params['name']);
	}
}
