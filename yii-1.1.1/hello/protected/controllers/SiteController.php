<?php

class SiteController extends Controller
{

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
	  $this->layout = false;
		$this->render('index', array('name' => $_GET['name']));
	}

  public function actionProducts()
  {
    $this->render('products', array('products' => array(
      array('id' => 1, 'title' => 'foo<br />'),
      array('id' => 2, 'title' => 'foo1'),
      array('id' => 3, 'title' => 'foo2'),
      array('id' => 4, 'title' => 'foo3'),
      array('id' => 5, 'title' => 'foo4'),
      array('id' => 6, 'title' => 'foo5'),
      array('id' => 7, 'title' => 'foo6'),
      array('id' => 8, 'title' => 'foo7'),
      array('id' => 9, 'title' => 'foo8'),
      array('id' => 10, 'title' => 'foo9'),
      array('id' => 11, 'title' => 'foo10'),
      array('id' => 12, 'title' => 'foo11'),
      array('id' => 13, 'title' => 'foo12'),
      array('id' => 14, 'title' => 'foo13'),
      array('id' => 15, 'title' => 'foo14'),
    )));
  }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
}