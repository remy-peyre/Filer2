<!DOCTYPE html>
<html lang="fr">
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
                <p class="p_action">Actions :</p>
                <div class="actions">
                    <form method="POST" action="?action=profil" enctype="multipart/form-data">
                        <p>UPLOAD :</p>
                        <p>Choice a File<br>
                            Click on Open and after Upload<br>
                            Files .jpg / .jpeg / .png / .pdf / .txt / .mp3 / .mp4
                            <br>
                            <input type="file" name="file">
                            <input type="submit" name="upload" value="Upload">
                        </p>
                    </form>
                    <!--REPLACE-->
                    <form class="form_replace" method="POST" action="?action=profil" enctype="multipart/form-data">
                        <p>REPLACE :<br>
                            Choice a File ,Click on Open <br>
                            Put the name of an existing file<br>
                            <input type="file" name="new_files">
                            <br>
                            <input type="text" name="replace_files" placeholder="nom du fichier">
                            <input type="submit" value="replace" name="remplacer">
                        </p>
                    </form>
                    <!--CREATE FOLDER-->
                    <div class="form_replace">
                        <form method="POST" action="?action=profil" enctype="multipart/form-data">
                            <p>CREATE A FOLDER :
                                <br>
                                Enter the name of the folder: <input type="text" name="name_folder" placeholder="Images">
                                <input type="submit" value="create" name="create_folder">
                            </p>
                        </form>
                        <form method="POST" action="?action=profil" enctype="multipart/form-data">
                            <p class="size_folder">DELETE A FOLDER :
                                <br>
                                Put the name of an existing folder: <input type="text" name="name_folder_delete" placeholder="Images">
                                <input type="submit" value="delete" name="delete_folder">
                            </p>
                        </form>
                    </div>
                </div>
                <?php
                foreach ($result_folder as $key => $value){
                    if (is_array($value)){
                        echo "<div class='size_upload'>";
                            echo "<img class='img_upload' src='assets/folder.png'>";
                            echo '<br>';
                            echo '<span class="name_img">' . $key . '</span>';
                            /*DELETE FOLDER*/
                            echo '<form method="POST" action="?action=profil" enctype="multipart/form-data">';
                                echo '<br>';
                                echo '<input style="display: none;" value=' . $key . ' type="text" name="name_folder_delete" placeholder="Images">';
                                echo '<input type="submit" value="delete" name="delete_folder">';
                            echo '</form>';
                            /*RENAME FOLDER*/
                            echo '<form method="POST" action="?action=profil" enctype="multipart/form-data">';
                                echo '<input style="display: none;" type="text" name="name_hide_folder" value="'. $key.'">';
                                echo '<input type="text" name="name_folder_rename" placeholder="Images">';
                                echo '<input type="submit" value="Rename" name="rename_folder">';
                                echo '</p>';
                            echo '</form>';
                        echo '</div>';
                    }
                }
                ?>
                <?php
                foreach($result as $file){
                    $file_ext = strrchr($file['url_fichier'], '.');
                    echo "<div class='size_upload'>";
                        if ($file_ext == '.txt') {
                            echo "<img class='img_pdf_txt' src='assets/txt.png' alt=" . $file['nom_fichier'] . ">";
                            echo '<form method="POST" action="?action=profil">';
                            echo '<textarea name="modif_txt"></textarea>';
                            echo '<input type="submit" name="modif_a_txt" value="Edit" />';
                            echo'</form>';
                        }elseif ($file_ext == '.pdf'){
                            echo "<img class='img_pdf_txt' src='assets/pdf.png' alt=" . $file['nom_fichier'] . ">";
                        }/*elseif ($file_ext == '.xlxs'){ //excel
                            echo "<embed class='img_pdf_txt' src='assets/xlsx.png' alt=" . $file['nom_fichier'] . ">";
                            echo '</embed>';
                        }*/elseif ($file_ext == '.mp3'){ //audio
                            echo "<audio class='img_pdf_txt' src='assets/pdf.png' alt=" . $file['nom_fichier'] . ">";
                            echo "</audio>";
                        }elseif ($file_ext == '.mp4'){ //video
                            echo "<video class='img_pdf_txt' src=" . $file['url_fichier'] ." alt=" . $file['nom_fichier'] . " controls autobuffer>";
                            echo "</video>";
                        }else{
                            echo "<img class='img_upload' src=" . $file['url_fichier'] .
                                " alt=" . $file['nom_fichier'] . ">";
                        }
                        /*echo "<img class='img_upload' src=" . $file['url_fichier'] .
                        " alt=" . $file['nom_fichier'] . ">";*/
                        echo '<br>';
                        echo '<span class="name_img">' . $file ['nom_fichier'] . '</span>';
                        echo '<br>';
                        /*DELETE*/
                        echo '<form method="POST" action="?action=profil">';
                            echo '<input style="display: none;" type="text" name="sup_fichier" value="'. $file['nom_fichier'].'">';
                            echo '<br>';
                            echo '<input type="submit" name="supprimer" value="Delete">';
                        echo '</form>';
                        /*UPDATE*/
                        echo '<form method="POST" action="?action=profil">';
                            echo '<input style="display: none;" type="text" name="name_hide" value="'. $file['nom_fichier'].'">';
                            echo '<input type="text" name="rename" value="" placeholder="'. $file['nom_fichier']. '">';
                            echo '<input type="submit" name="renommer" value="Rename">';
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
