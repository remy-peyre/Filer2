<?php

require_once('model/db.php');

function get_user_by_id($id)
{
    $id = (int)$id;
    $data = find_one("SELECT * FROM users WHERE id = ".$id);
    return $data;
}

function get_user_by_username($username)
{
    $data = find_one_secure("SELECT * FROM users WHERE username = :username ",
                            ['username' => $username]);
    return $data;
}

function user_check_register($data)
{
    if (empty($data['username']) OR empty($data['password']) OR
        empty($data['lastname']) OR empty($data['firstname'])
        OR empty($data['email'])){
        return false;
    }
    $data2 = get_user_by_username($data['username']);
    if ($data2 !== false){
        return false;
    }
    // TODO : Check valid username, password.
    if(strlen($data['username'])<6){
        return false;
    }
    return true;
}

function user_hash($pass)
{
    $hash = password_hash($pass, PASSWORD_BCRYPT, ['salt' => 'saltysaltysaltysalty!!']);
    return $hash;
}

function user_register($data)
{
    $user['firstname'] = $data['firstname'];
    $user['lastname'] = $data['lastname'];
    $user['username'] = $data['username'];
    $user['password'] = user_hash($data['password']);
    $user['email'] = $data['email'];
    mkdir ('uploads/' . $user['username']);
    db_insert('users', $user);
}

function user_check_login($data)
{
    if (empty($data['username']) OR empty($data['password']))
        return false;
    $user = get_user_by_username($data['username']);
    if ($user === false)
        return false;
    $hash = user_hash($data['password']);
    if ($hash !== $user['password'])
    {
        return false;
    }
    return true;
}

function user_login($username)
{
    $data = get_user_by_username($username);
    if ($data === false)
        return false;
    $_SESSION['user_id'] = $data['id'];
    $_SESSION['user_username'] = $data['username'];
    return true;
}

function upload_img_profil()
{
    /*if (($_FILES["file"]["type"] == "image/jpg")
        || ($_FILES["file"]["type"] == "image/jpeg")){

        if (file_exists("img/" . $_FILES["file"]["name"])) {
            //echo "Le fichier existe deja";
            //echo '<meta http-equiv="refresh" content="1;URL=profil.php">';
        }
        else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"],
                "img/" . $_FILES["file"]["name"]))
            {*/

        if (isset($_POST['upload'])){
                $files['nom_fichier'] = $_FILES["file"]['name'];
                $files['url_fichier'] =  'uploads/'.$_SESSION['user_username'] . '/' . $files["nom_fichier"];
                $files['id_users'] = $_SESSION['user_id'];
                db_insert('files', $files);

                move_uploaded_file($_FILES["file"]["tmp_name"], $files['url_fichier']);

            return true;
        }
            /*
        }
    }
    else {
        echo 'Erreur fichier non conforme';
        echo '<meta http-equiv="refresh" content="1;URL=profil.php">';
    }*/
}

function show_upload_img()
{
    $id_users = $_SESSION['user_id'];
    $data = find_all_secure("SELECT * FROM files WHERE id_users = :id_users ",
        ['id_users' => $id_users]);
    return $data;
}

/*function one_only_img()
{
    $id_users = $_SESSION['user_id'];
    $reqidimg = find_one_secure("SELECT * FROM files WHERE `id_users` = :user_id",
        ['user_id' => $user_id]);
    return $reqidimg;
}*/