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
        <main>
            <div class="flex_home">
                <div class="colum_container">
                    <h4 class="center_title_home">All uploads</h4>
                    <div class="show_home">
                        <?php
                        foreach($result_home as $file){
                            $file_ext = strrchr($file['url_fichier'], '.');
                            echo "<div class='size_show_home'>";
                            if ($file_ext == '.txt') {
                                echo "<img class='img_pdf_txt' src='assets/txt.png' alt=" . $file['nom_fichier'] . ">";

                            }elseif ($file_ext == '.pdf'){
                                echo "<img class='img_pdf_txt' src='assets/pdf.png' alt=" . $file['nom_fichier'] . ">";
                            }else{
                                echo "<img class='img_upload' src=" . $file['url_fichier'] .
                                    " alt=" . $file['nom_fichier'] . ">";
                            }
                            /*echo "<img class='img_upload' src=" . $file['url_fichier'] .
                                " alt=" . $file['nom_fichier'] . ">";*/
                            echo '<br>';
                            echo '<p class="name_img">' . $file ['nom_fichier'] . '</p>';
                            echo '<br>';
                            echo '<span class="name_img size_posted">Posted by user n°' . $file['id_users'] . '</span>';
                            echo '<br>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
                <div class="column_profil">
                    <h2 class="title_profil">Profil</h2>
                    <img class="img_profil" src="assets/user.png">
                    <div>
                        <p class="categorie">Username :</p>
                        <p><?php echo $username ?></p>
                        <p class="categorie">Firstname :</p>
                        <p><?php echo $firstname ?></p>
                        <p class="categorie">Lastname :</p>
                        <p><?php echo $lastname ?></p>
                        <p class="categorie">Email :</p>
                        <p><?php echo $email ?></p>
                    </div>
                    <a class="text_deco" href='?action=profil'><p class="button_to_profil">Votre espace</p></a>
                </div>
            </div>
        </main>
    </body>
</html>
