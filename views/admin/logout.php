<?php

use app\core\Application;

session_start();

session_unset();
session_destroy();

Application::$app->response->redirect('/login');
exit();

?>
