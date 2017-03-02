<?php

require_once('model/user.php');

function home_action()
{
    if (!empty($_SESSION['user_id']))
    {
        $user = get_user_by_id($_SESSION['user_id']);
        //$user = get_user_by_id(1);

        //CAN SHOW INFO IN BDD
        $username = $user['username'];
        $firstname = $user['firstname'];
        $lastname = $user['lastname'];
        $email = $user['email'];

        $result_home = show_all_img_upload();

        require('views/home.php');
    }
    else {
        header('Location: ?action=login');
        exit(0);
    }
}
//Possible modif

function about_action()
{
    require('views/about.html');
}

function contact_action()
{
    require('views/contact.html');
}

//SHOW ALL IMG HOME
