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
            $error = "Invalid data";
        }    
    }
    require('views/register.php');
}

function profil_action()
{
    $message = '';
    if (upload_img_profil()){
        $message = "je suis dans le if";

        /*if (one_only_img()){
            $message = "ce fichier existe deja"
        }*/
    }
    delete_one_upload();

    update_name_img();

    replace_name_img();

    create_folder();

    $result = show_upload_img();


    require('views/profil.php');
}
