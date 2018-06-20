<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

require 'vendor/autoload.php';

class App extends \atk4\ui\App {
	function __construct($is_admin = false) {
		
		parent::__construct('Party App');
		
		//Depending on the use, select appropriate layout for our pages
		if ($is_admin) {
			$this->initLayout('Admin');
			$this->layout->menuLeft->addItem(['Dashboard', 'icon'=>'cog'], ['dashboard']);
			$this->layout->menuLeft->addItem(['Guest Admin', 'icon'=>'users'], ['admin']);
			$this->layout->menuLeft->addItem(['User registration', 'icon'=>'user'], ['index']);
		} else {
			$this->initLayout('Centered');
		}
		$this->dbConnect(isset($_ENV['CLEARDB_DATABASE_URL']) ? $_ENV['CLEARDB_DATABASE_URL']: 'mysql://atk4:2pMnl7&4@sciretech.com:3306/atk4');
	}
}

class Guest extends \atk4\data\Model {
	public $table = 'guest';
	function init()	{
		parent::init();
		$this->addFields([
			'name', ['required'=>true],
			'surname',
			['phone'=>true],
			'email'
		]);
		$this->addField('age', ['required'=>true]);
		$this->addField('gender', ['enum'=>['male', 'female']]);
		$this->addField('units_of_drink');
	}
}

class Dashboard extends \atk4\ui\View {
	public $defaultTemplate = __DIR__. '/dashboard.html';
	function setModel(\atk4\data\Model $m) {
		$model = parent::setModel($m);

		$this->template['guests'] = $model->action('count')->getOne();
		$this->template['drinks'] = $model->action('fx', ['sum', 'units_of_drink'])->getOne();
		$this->template['average_age'] = $model->action('fx', ['avg', 'age'])->getOne();
		return $model;

	}
}