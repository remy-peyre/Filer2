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

    $date = give_me_date();
    $actions = $date . ' -- ' .$user['username'] . ' has just registered.' ."\n";
    watch_action_log('access.log',$actions);

    echo "Register with success";
    echo '<meta http-equiv="refresh" content="1;URL=?action=profil">';

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

    $date = give_me_date();
    $actions = $date . ' -- ' .$_SESSION['user_username'] . ' session start.' ."\n";
    watch_action_log('access.log',$actions);

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

            $date = give_me_date();
            $actions = $date . ' -- ' .$_SESSION['user_username'] . ' has upload an image.' ."\n";
            watch_action_log('access.log',$actions);

            echo "File upload with success";
            echo '<meta http-equiv="refresh" content="1;URL=?action=profil">';
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

// cherche fichier par son nom
function get_user_by_nom_fichier($nom_fichier)
{
    $id_users = $_SESSION['user_id'];
    $data = find_one_secure("SELECT * FROM files WHERE `nom_fichier` = :nom_fichier AND 
                `id_users` = :id_users",
            ['user_id' => $id_users,
            'nom_fichier' => $nom_fichier]);
    return $data;
}

//FIND FILES is exist
function one_only_img($nom_fichier)
{
    $id_users = $_SESSION['user_id'];
    $reqidimg = find_one_secure("SELECT * FROM files WHERE `nom_fichier` = :nom_fichier AND 
                `id_users` = :user_id",
        ['user_id' => $id_users,
         'nom_fichier' => $nom_fichier]);
    if ($reqidimg == true){
        echo "File upload already in database";
        echo '<meta http-equiv="refresh" content="1;URL=?action=profil">';
        return true;
    }
}

//DELETE
function delete_one_upload()
{
    if (isset($_POST['supprimer'])) {

        $nom_fichier = $_POST['sup_fichier'];
        $id_users = $_SESSION['user_id'];
        $delete_file = 'uploads/'.$_SESSION['user_username'] . '/' . $nom_fichier;

        if (!delete_one_upload_file("DELETE FROM files WHERE nom_fichier = :nom_fichier AND 
            `id_users` = :user_id",
            ['user_id' => $id_users,
                'nom_fichier' => $nom_fichier])){

            unlink($delete_file);

            $date = give_me_date();
            $actions = $date . ' -- ' .$_SESSION['user_username'] . ' has delete an image.' ."\n";
            watch_action_log('access.log',$actions);

            echo "File delete with success";
            echo '<meta http-equiv="refresh" content="1;URL=?action=profil">';
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
        $new_url = 'uploads/'.$_SESSION['user_username'] . '/' . $rename;
        $old_url = 'uploads/'.$_SESSION['user_username'] . '/' . $name_hide;

        if (!rename_one_upload_file("UPDATE `files` SET `nom_fichier` = :nom_rename,  `url_fichier` = :new_url
            WHERE nom_fichier = :nom_old AND `id_users` = :user_id ",
            ['user_id' => $id_users,
                'nom_rename' => $rename,
                'nom_old' => $name_hide,
                'new_url' => $new_url])){

            rename($old_url, $new_url);

            $date = give_me_date();
            $actions = $date . ' -- ' .$_SESSION['user_username'] . ' has rename an image.' ."\n";
            watch_action_log('access.log',$actions);

            echo "File rename with success";
            echo '<meta http-equiv="refresh" content="1;URL=?action=profil">';
            return true;
        }
    }
}

//REPLACE
function replace_name_img()
{
    if (isset($_POST['remplacer'])) {
        $replace = $_FILES["new_files"]['name'];
        $tmp_name =$_FILES["new_files"]['tmp_name'];
        $select_file_to_replace = $_POST['replace_files'];
        $id_users = $_SESSION['user_id'];
        $new_url = 'uploads/'.$_SESSION['user_username'] . '/' . $replace;
        $old_url = 'uploads/'.$_SESSION['user_username'] . '/' . $select_file_to_replace;

        if (!replace_one_upload_file("UPDATE `files` SET `nom_fichier` = :replace, `url_fichier` = :new_url
            WHERE `nom_fichier` = :select_file_to_replace AND `id_users` = :id_users",
            ['id_users' => $id_users,
                'select_file_to_replace' => $select_file_to_replace,
                'replace' => $replace,
                'new_url' => $new_url])){
            move_uploaded_file($tmp_name,$new_url);
            unlink($old_url);

            $date = give_me_date();
            $actions = $date . ' -- ' .$_SESSION['user_username'] . ' has replace an image.' ."\n";
            watch_action_log('access.log',$actions);

            echo "File replace with success";
            echo '<meta http-equiv="refresh" content="1;URL=?action=profil">';
            return true;
        }
    }
}

//CREATE FOLDER
function create_folder($username)
{
    //mkdir ('uploads/' . $user['username']);
    if (isset($_POST['create_folder'])) {
        $name_folder = $_POST['name_folder'];
        $user['username'] = $data['username'];
        $id_users = $_SESSION['user_id'];
        $username = $_SESSION['user_username'];

        $name = get_user_by_username();

        mkdir('uploads/' . $username . '/' . $name_folder);

        $date = give_me_date();
        $actions = $date . ' -- ' .$_SESSION['user_username'] . ' create a folder.' ."\n";
        watch_action_log('access.log',$actions);

        echo "Folder create with success";
        echo '<meta http-equiv="refresh" content="1;URL=?action=profil">';
        return true;
    }
}
//Liste les fichiers et dossiers dans un dossier
function dirToArray($dir) {

    $result = array();

    $cdir = scandir($dir);
    foreach ($cdir as $key => $value)
    {
        if (!in_array($value,array(".","..")))
        {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
            {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            }
            else
            {
                $result[] = $value;
            }
        }
    }

    return $result;
}

//delete FOLDER
function delete_folder()
{
    if (isset($_POST['delete_folder'])) {
        $name_folder = $_POST['name_folder_delete'];
        $username = $_SESSION['user_username'];

        rmdir('uploads/' . $username . '/' . $name_folder);

        $date = give_me_date();
        $actions = $date . ' -- ' .$_SESSION['user_username'] . ' has delete a folder.' ."\n";
        watch_action_log('access.log',$actions);

        echo "Folder delete with success";
        echo '<meta http-equiv="refresh" content="1;URL=?action=profil">';
        return true;
    }
}

//RENAME FOLDER
function rename_folder()
{
    if (isset($_POST['rename_folder'])) {
        $name_folder = $_POST['name_folder_rename'];
        $name_hide_folder = $_POST['name_hide_folder'];
        $username = $_SESSION['user_username'];

        //echo 'uploads/' . $username . '/' . $name_hide_folder;
        //echo 'uploads/' . $username . '/' . $name_folder;

        rmdir('uploads/' . $username . '/' . $name_hide_folder);
        mkdir('uploads/' . $username . '/' . $name_folder);

        $date = give_me_date();
        $actions = $date . ' -- ' .$_SESSION['user_username'] . ' has rename a folder.' ."\n";
        watch_action_log('access.log',$actions);

        echo "Folder rename with success";
        echo '<meta http-equiv="refresh" content="1;URL=?action=profil">';
        return true;
    }
}