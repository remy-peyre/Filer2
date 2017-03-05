<?php

require_once('model/user.php');

function login_action()
{
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if (user_check_login($_POST))
        {
            user_login($_POST['username']);
            header('Location: ?action=home');
            exit(0);
        }
        else {
            $error = "Invalid username or password";
            $date = give_me_date();
            $actions = $date . ' -- Someone did not fill all the fields in LOGIN' ."\n";
            watch_action_log('security.log',$actions);
        }
    }
    require('views/login.php');
}
function logout_action()
{
    session_destroy();
    header('Location: ?action=login');
    exit(0);
}
function register_action()
{
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        if (user_check_register($_POST))
        {
            user_register($_POST);
            header('Location: ?action=home');
            exit(0);
        }
        else {
            $error = "You must complete each field to register";

            $date = give_me_date();
            $actions = $date . ' -- Someone did not fill all the fields in REGISTER' ."\n";
            watch_action_log('security.log',$actions);
        }    
    }
    require('views/register.php');
}

function profil_action()
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


    }
    else {
        header('Location: ?action=login');
        exit(0);

    }

    upload_img_profil();

    delete_one_upload();

    update_name_img();

    replace_name_img();

    create_folder();

    $result = show_upload_img();


    require('views/profil.php');
}
