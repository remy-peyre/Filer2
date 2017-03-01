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

    // create directory by user
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

//UPLOAD
function upload_img_profil()
{
    if (isset($_POST['upload'])){
        $files['nom_fichier'] = $_FILES["file"]['name'];
        $files['url_fichier'] =  'uploads/'.$_SESSION['user_username'] . '/' . $files["nom_fichier"];
        $files['id_users'] = $_SESSION['user_id'];

        if(!one_only_img($files['nom_fichier'])) {
            db_insert('files', $files);
            move_uploaded_file($_FILES["file"]["tmp_name"], $files['url_fichier']);
            return true;
        }
    }
}
//SHOW
function show_upload_img()
{
    $id_users = $_SESSION['user_id'];
    $data = find_all_secure("SELECT * FROM files WHERE id_users = :id_users ",
        ['id_users' => $id_users]);
    return $data;
}

//FIND FILES is exist
function get_user_by_nom_fichier($nom_fichier)
{
    $id_users = $_SESSION['user_id'];
    $data = find_one_secure("SELECT * FROM files WHERE `nom_fichier` = :nom_fichier AND 
                `id_users` = :id_users",
            ['user_id' => $id_users,
            'nom_fichier' => $nom_fichier]);
    return $data;
}
// cherche fichier par son nom
function one_only_img($nom_fichier)
{
    $id_users = $_SESSION['user_id'];
    $reqidimg = find_one_secure("SELECT * FROM files WHERE `nom_fichier` = :nom_fichier AND 
                `id_users` = :user_id",
        ['user_id' => $id_users,
         'nom_fichier' => $nom_fichier]);
    if ($reqidimg == true){
        return true;
    }
}

//DELETE
function delete_one_upload()
{
    if (isset($_POST['supprimer'])) {
        $nom_fichier = $_POST['sup_fichier'];
        $id_users = $_SESSION['user_id'];
        if (delete_one_upload_file("DELETE FROM files WHERE nom_fichier = :nom_fichier AND 
            `id_users` = :user_id",
            ['user_id' => $id_users,
                'nom_fichier' => $nom_fichier])){
            unlink($nom_fichier);
            return true;
        }
    }
}

//RENAME
function update_name_img()
{
    if (isset($_POST['renommer'])) {
        $rename = $_POST['rename'];
        $name_hide = $_POST['name_hide'];
        $id_users = $_SESSION['user_id'];
        if (rename_one_upload_file("UPDATE `files` SET `nom_fichier` = :nom_rename 
            WHERE nom_fichier = :nom_old AND `id_users` = :user_id ",
            ['user_id' => $id_users,
                'nom_rename' => $rename,
                'nom_old' => $name_hide])){
            return true;
        }
    }
}

//REPLACE
function replace_name_img()
{
    if (isset($_POST['remplacer'])) {
        $replace = $_FILES["new_files"]['name'];
        $select_file_to_replace = $_POST['replace_files'];
        $id_users = $_SESSION['user_id'];
        $new_url = 'uploads/'.$_SESSION['user_username'] . '/' . $replace;
        echo $replace;
        echo '<br>';
        echo $select_file_to_replace;
        echo '<br>';
        echo $new_url;
        if (replace_one_upload_file("UPDATE `files` SET `nom_fichier` = :new_files/*, `url_fichier` = :new_url_files*/
            WHERE `nom_fichier` = :old_files AND `id_user` = :user_id",
            ['user_id' => $id_users,
                'old_files' => $select_file_to_replace,
                'new_files' => $replace/*,
                'new_url_files' => $new_url*/])){
            //move_uploaded_file($_FILES["file"]["tmp_name"], $files['url_fichier']);
            return true;
        }
    }
}

/*
$req_name = "UPDATE files SET `file_name` = :new_file_name  WHERE `id` = :id";
$req_url = "UPDATE `files` SET `file_url` = :new_file_url  WHERE `id` = :id";
*/