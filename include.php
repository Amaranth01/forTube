<?php

require __DIR__ . '/Config.php';
require __DIR__ . '/Model/DB.php';

require __DIR__ . '/Controller/AbstractController.php';
require __DIR__ . '/Controller/ErrorController.php';

require __DIR__. '/Model/Entity/Category.php';
require __DIR__. '/Model/Entity/Comment.php';
require __DIR__. '/Model/Entity/Role.php';
require __DIR__. '/Model/Entity/User.php';
require __DIR__. '/Model/Entity/Video.php';

require __DIR__. '/Model/Manager/CategoryManager.php';
require __DIR__. '/Model/Manager/CommentManager.php';
require __DIR__. '/Model/Manager/RoleManager.php';
require __DIR__. '/Model/Manager/UserManager.php';
require __DIR__. '/Model/Manager/VideoManager.php';

require __DIR__ . '/Routing.php';

session_start();