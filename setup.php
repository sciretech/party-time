<?php

require 'init.php';

$app = new App(true);

$app->add('CRUD')->setModel(new \atk4\login\Model\User($app->db));

