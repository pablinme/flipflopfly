<?php

Router::add('/', DIR_CTRL.'/home.php');
Router::add('#^login#', DIR_CTRL.'/login.php', Router::ROUTE_PCRE);
Router::add('#^logout#', DIR_CTRL.'/logout.php', Router::ROUTE_PCRE);
Router::add('#^register#', DIR_CTRL.'/register.php', Router::ROUTE_PCRE);
Router::add('#^recover#', DIR_CTRL.'/recover.php', Router::ROUTE_PCRE);
Router::add('#^category#', DIR_CTRL.'/category.php', Router::ROUTE_PCRE);
Router::add('#^topic#', DIR_CTRL.'/topic.php', Router::ROUTE_PCRE);
Router::add('#^comment#', DIR_CTRL.'/comment.php', Router::ROUTE_PCRE);
Router::add('#^ajax#', DIR_CTRL.'/ajax.php', Router::ROUTE_PCRE);
Router::add('#^user#', DIR_CTRL.'/user.php', Router::ROUTE_PCRE);
Router::add('#^about#', DIR_CTRL.'/about.php', Router::ROUTE_PCRE);

?>