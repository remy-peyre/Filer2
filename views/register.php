<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home page</title>
        <link rel="stylesheet" href="assets/style.css"
    <body>
        <?php if (!empty($error)): ?>
        <p>Error : <?php echo $error ?></p>
        <?php endif; ?>
        <form action="?action=register" method="POST">
            <div class="form-style-5">
                <legend><span class="number">1</span>Register</legend>
                Firstname : <input type="text" name="firstname"><br>
                Lastname : <input type="text" name="lastname"><br>
                Username :<span class="obligation">*</span><span class="condition_register">(au moins 6 caractères)</span><input type="text" name="username"><br>
                Email : <input type="text" name="email"><br>
                Password : <span class="obligation">*</span><input type="password" name="password"><br>
                <input type="submit">
                <span>Or</span><a href='?action=login'>LOG IN</a>
            </div>
        </form>
    </body>
</html>
