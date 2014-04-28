<?php

class DefaultController extends CApplicationController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}