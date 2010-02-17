<?php

namespace app\controllers;

class HelloWorldController extends \lithium\action\Controller {

	public function index() {
		return $this->render(array('data' => array('name' => $this->request->name), 'layout' => false));
	}
}
