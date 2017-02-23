<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <link rel="stylesheet" href="web/style.css">
    </head>
    <body>
        <?php if (!empty($error)): ?>
        <p>Error : <?php echo $error ?></p>
        <?php endif; ?>
        <form action="?action=login" method="POST">
            <div class="form-style-5">
                <legend><span class="number">1</span>Se connecter</legend>
                Login : <input type="text" name="username"><br>
                Password : <input type="password" name="password"><br>
                <input type="submit">
            </div>
        </form>
    </body>
</html>
