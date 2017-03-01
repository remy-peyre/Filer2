<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Uptofiles</title>
        <link rel="stylesheet" href="assets/style.css">
    </head>
    <body>
        <nav>
            <ul>
                <li><a href='?action=home'>Homepage</a></li>
                <li><a href='?action=profil'>My files</a></li>
                <li><a href='?action=logout'><img class="img_nav" src="assets/logout.png">Log out</a></li>
            </ul>
        </nav>
        <div class="flex_profil">
            <div class="contenu_profil">
                <p class="p_action">Actions</p>
                <div class="actions">
                    <form method="POST" action="?action=profil" enctype="multipart/form-data">
                        <p>UPLOAD :</p>
                        <p>Uniquement fichier .jpg / .jpeg / .png / .pdf / .txt
                            <br>
                            <input type="file" name="file">
                            <input type="submit" name="upload" value="uploader">
                        </p>
                    </form>
                    <!--REPLACE-->
                    <form class="form_replace" method="POST" action="?action=profil" enctype="multipart/form-data">
                        <p>REPLACE :
                            <br>
                            <input type="file" name="new_files">
                            <br>
                            <input type="text" name="replace_files" placeholder="nom du fichier">
                            <input type="submit" value="remplacer" name="remplacer">
                        </p>
                    </form>
                </div>
                <?php
                foreach($result as $file){
                    echo "<div class='size_upload'>";
                        echo "<img class='img_upload' src=" . $file['url_fichier'] .
                        " alt=" . $file['nom_fichier'] . ">";
                        echo '<br>';
                        echo '<span class="name_img">' . $file ['nom_fichier'] . '</span>';
                        echo '<br>';
                        /*DELETE*/
                        echo '<form method="POST" action="?action=profil">';
                            echo '<input style="display: none;" type="text" name="sup_fichier" value="'. $file['nom_fichier'].'">';
                            echo '<br>';
                            echo '<input type="submit" name="supprimer" value="supprimer">';
                        echo '</form>';
                        /*UPDATE*/
                        echo '<form method="POST" action="?action=profil">';
                            echo '<input style="display: none;" type="text" name="name_hide" value="'. $file['nom_fichier'].'">';
                            echo '<input type="text" name="rename" value="" placeholder="'. $file['nom_fichier']. '">';
                            echo '<input type="submit" name="renommer" value="renommer">';
                        echo '</form>';
                        /*DOWNLOAD*/
                        echo '<a href="' . $file['url_fichier'] . '" download="' . $file['nom_fichier'] . '">';
                            echo '<br>';
                            echo '<img class="logo_download" src="assets/download.png" alt="download"/>';
                        echo '</a>';


                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </body>
</html>
