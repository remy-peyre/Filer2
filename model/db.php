<?php

$dbh = null;

function connect_to_db()
{
    global $db_config;
    $dsn = 'mysql:dbname='.$db_config['name'].';host='.$db_config['host'];
    $user = $db_config['user'];
    $password = $db_config['pass'];
    
    try {
        $dbh = new PDO($dsn, $user, $password);
    } catch (PDOException $e) {
        echo 'Connexion échouée : ' . $e->getMessage();
    }
    
    return $dbh;
}

function get_dbh()
{
    global $dbh;
    if ($dbh === null)
        $dbh = connect_to_db();
    return $dbh;
}

function db_insert($table, $data = [])
{
    $dbh = get_dbh();
    $query = 'INSERT INTO `' . $table . '` VALUES ("",';
    $first = true;
    foreach ($data AS $k => $value)
    {
        if (!$first)
            $query .= ', ';
        else
            $first = false;
        $query .= ':'.$k;
    }
    $query .= ')';
    $sth = $dbh->prepare($query);
    $sth->execute($data);
    return true;
}

function find_one($query)
{
    $dbh = get_dbh();
    $data = $dbh->query($query, PDO::FETCH_ASSOC);
    $result = $data->fetch();
    return $result;
}

function find_one_secure($query, $data = [])
{
    $dbh = get_dbh();
    $sth = $dbh->prepare($query);
    $sth->execute($data);
    $result = $sth->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function find_all($query)
{
    $dbh = get_dbh();
    $data = $dbh->query($query, PDO::FETCH_ASSOC);
    $result = $data->fetchAll();
    return $result;
}

function find_all_secure($query, $data = [])
{
    $dbh = get_dbh();
    $sth = $dbh->prepare($query);
    $sth->execute($data);
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

/*ACTIONS*/

function delete_one_upload_file($query, $data = [])
{
    $dbh = get_dbh();
    $sth = $dbh->prepare($query);
    $sth->execute($data);
    return ($sth->fetch(PDO::FETCH_ASSOC));
}

function rename_one_upload_file($query, $data = [])
{
    $dbh = get_dbh();
    $sth = $dbh->prepare($query);
    $sth->execute($data);
    return ($sth->fetch(PDO::FETCH_ASSOC));
}

function replace_one_upload_file($query, $data = [])
{
    $dbh = get_dbh();
    $sth = $dbh->prepare($query);
    $sth->execute($data);
    return ($sth->fetch(PDO::FETCH_ASSOC));
}

function give_me_date(){
    $date = date("d-m-Y");
    $heure = date("H:i");
    return $date . " " . $heure;
}

function watch_action_log($file, $text){
    $file_log = fopen('logs/' . $file, 'a');
    fwrite($file_log, $text);
    fclose($file_log);
}
/*
function show_all_img_upload()
{
    /*$files['nom_fichier'] = $_FILES["file"]['name'];
    //$files['url_fichier'] =  'uploads/'.$_SESSION['user_username'] . '/' . $files["nom_fichier"];

    //$id_users = $_SESSION['user_id'];
    $data = find_all_secure("SELECT * FROM files WHERE `nom_fichier` = :nom_fichier ",
        ['id_users' => $files['nom_fichier']]);
    return $data;*/
    /*$id_users = $_SESSION['user_id'];
    $data = find_all_secure("SELECT * FROM files WHERE id_users = :id_users ",
        ['id_users' => $id_users]);
    return $data;
}
*/
function show_all_img_upload()
{
    //$id_users = $_SESSION['user_id'];
    $data = find_all_secure("SELECT * FROM files /*WHERE id_users = :id_users*/ "
    /*['id_users' => $id_users]*/);
    return $data;
}
