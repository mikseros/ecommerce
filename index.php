<!DOCTYPE html>
<html>
    <head>
        <title>Registrazione</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap">
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <form method="post" action="register.php">
            <h1>Formulaire d'enregistrement</h1>
            <input type="email" id="email" placeholder="Email*" name="email" required>
            <input type="password" id="password" placeholder="Password*" name="password" required>
            <button type="submit" name="register">Sign up</button>
        </form>
        <form method="post" action="/php/login.php">
            <h1>Formulaire de connexion</h1>
            <input type="email" id="email" placeholder="Email*" name="email" required>
            <input type="password" id="password" placeholder="Password*" name="password" required>
            <button type="submit" name="login">Sign in</button>
        </form>
    </body>
</html>
