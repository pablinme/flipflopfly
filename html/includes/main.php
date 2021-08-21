<?php
/* This is the main include file. */
require_once "includes/helpers.php";

//system
require_once "includes/system/config.php";
require_once "includes/system/routing.php";
require_once "includes/system/connect.php";
require_once 'includes/system/sessions.php';
require_once "includes/system/post.php";
require_once "includes/system/topic.php";
require_once "includes/system/comment.php";
require_once "includes/system/rate.php";
require_once "includes/system/user.php";
require_once "includes/system/sidebar.php";
require_once "includes/system/timezone.php";
require_once "includes/system/breadcrumb.php";
//require_once "includes/system/requests.php";

//models
require_once "includes/models/topics.model.php";
require_once "includes/models/posts.model.php";
require_once "includes/models/comments.model.php";
require_once "includes/models/login.model.php";
require_once "includes/models/recover.model.php";
require_once "includes/models/register.model.php";
require_once "includes/models/rates.model.php";
require_once "includes/models/users.model.php";
require_once "includes/models/timezones.model.php";

//controllers
require_once "includes/controllers/ajax.controller.php";
require_once "includes/controllers/home.controller.php";
require_once "includes/controllers/posts.controller.php";
require_once "includes/controllers/topics.controller.php";
require_once "includes/controllers/comments.controller.php";
require_once "includes/controllers/login.controller.php";
require_once "includes/controllers/logout.controller.php";
require_once "includes/controllers/recover.controller.php";
require_once "includes/controllers/register.controller.php";
require_once "includes/controllers/users.controller.php";
require_once "includes/controllers/about.controller.php";

// This will allow the browser to cache the pages.
header('Cache-Control: max-age=3600, public');
header('Pragma: cache');
header("Last-Modified: ".gmdate("D, d M Y H:i:s",time())." GMT");
header("Expires: ".gmdate("D, d M Y H:i:s",time()+3600)." GMT");
?>
