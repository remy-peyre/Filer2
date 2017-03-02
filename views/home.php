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
                    <p>All uploads</p>
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
