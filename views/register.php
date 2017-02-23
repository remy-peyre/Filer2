<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home page</title>
        <link rel="stylesheet" href="web/style.css">
    </head>
    <body>
        <?php if (!empty($error)): ?>
        <p>Error : <?php echo $error ?></p>
        <?php endif; ?>
        <form action="?action=register" method="POST">
            <div class="form-style-5">
                <legend><span class="number">1</span>Register</legend>
                Firstname : <input type="text" name="firstname"><br>
                Lastname : <input type="text" name="lastname"><br>
                Login : <input type="text" name="username"><br>
                Email : <input type="text" name="email"><br>
                Password : <input type="password" name="password"><br>
                <input type="submit">
            </div>
        </form>
    </body>
</html>
