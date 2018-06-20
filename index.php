<?php

require 'init.php';

$app = new App();

$columns = $app->add('Columns');

$left = $columns->addColumn();
$right = $columns->addColumn();

$right->add(['Message', 'Welcome to my Party!', 'info'])->text
	->addParagraph('Our party is using "Bring your own drink policy", so be sure '.
				   'to grab a beer or lemonade');
$left->add('Form')->setModel(new Guest($app->db));