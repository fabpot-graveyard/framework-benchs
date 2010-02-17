<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class SiteController extends CController
{
	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex()
	{
		$params=array(
			'name'=>Yii::app()->request->name,
		);

		$this->render('index',$params);
	}
}