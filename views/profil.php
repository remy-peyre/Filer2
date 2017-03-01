<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Uptofiles</title>
        <link rel="stylesheet" href="web/style.css">
    </head>
    <body>
        <nav>
            <ul>
                <li><a href='?action=home'>Homepage</a></li>
                <li><a href='?action=profil'>My files</a></li>
                <li><a href='?action=logout'><img class="img_nav" src="web/logout.png">Log out</a></li>
            </ul>
        </nav>
        <div class="flex_profil">
            <div class="contenu_profil">
                <p class="p_action">Actions</p>
                <div class="actions">
                    <form method="POST" enctype="multipart/form-data" action="?action=profil">
                        <p>Uniquement fichier .jpg / .jpeg / .png / .pdf / .txt
                            <br>
                            <input type="file" name="file">
                            <input type="submit" name="upload" value="uploader">
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
                        /*echo '<a href="' . $file['url_fichier'] . '" download="' . $file['url_fichier'] . '">';
                            echo '<br>';
                            echo '<img class='logo_download' id="$rows['file_name']" src='web/download.png' alt='download'/>';
                        echo '</a>';*/

                        //echo '<a  href='" . $rows['file_url'] . "'   download='" . $rows['file_name'] . "'>';

                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </body>
</html>
