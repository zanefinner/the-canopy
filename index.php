<?php
session_start();
$request = preg_replace("|/*(.+?)/*$|", "\\1", $_SERVER['PATH_INFO']);
$uri = explode('/', $request);

require_once "lib/Database.php";
require_once "controller/Home.php";
require_once "controller/Users.php";
require_once "controller/Posts.php";
require_once "model/Accounts.php";
require_once "model/Posts.php";

$db = new Database();
$accountsModel = new Model\Accounts($db);
$postsModel = new Model\Posts($db);

$Controllers = [
    'home' => new Controller\Home($accountsModel),
    'user' => new Controller\Users($accountsModel, $postsModel),
    'posts' => new Controller\Posts($postsModel)
];

switch ($uri[0]) {
    case '':
        $title = "Welcome";
        $Controllers['home']->present();
        break;
    case 'login':
        $title = "Log In";
        $Controllers['user']->login();
        break;
    case 'signup':
        $title = "Create an Account";
        $Controllers['user']->signup();
        break;
    case 'logout':
        $Controllers['user']->logout();
        break;
    case 'feed':
        $title = "Feed";
        $Controllers['posts']->getPostsForUserFeed($_SESSION['id']);
        break;
    case 'search':
        $Controllers['user']->search($_GET);
        break;
    case 'user-posts':
        $Controllers['posts']->getUserPosts($uri[1]);
        break;
    case 'post-something':
        $Controllers['posts']->create($_POST);
        break;
    case 'follow':
        $Controllers['user']->follow($uri[1]);
        break;
    case 'unfollow': // Add case for unfollow
        $Controllers['user']->unfollow($uri[1]);
        break;
    default:
        $Controllers['home']->error("Location no longer exists");
}

