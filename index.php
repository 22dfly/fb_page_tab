<?php
require 'vendor/autoload.php';
require 'config.php';

use Facebook\FacebookSession;

FacebookSession::setDefaultApplication(
    FACEBOOK_APP_ID,
    FACEBOOK_APP_SECRET
);
$helper = new FacebookPageTabHelper();
$user_liked_page = $helper->isLiked();
$user_id = $helper->getUserId();
$user_id_admin = $helper->isAdmin();
$page_id = $helper->getPageId();
$session = $helper->getSession();  // null if not logged in.

var_dump($user_liked_page, $user_id, $user_id_admin, $page_id, $session);
