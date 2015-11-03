<?php

class GeneratorController extends Controller
{
	public function beforeFilter()
	{
		parent::beforeFilter();
		
		$this->Auth->allow(array('index'));
	}

	public function index() {}
}

?>