<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="finalCSS.css">
        <title>Login</title>
    </head>
    <body>
        <div id="container">
            <header>
            </header>
            <navbar>
                <ul>
                    <li><a href="index.php?action=homepage">Home</a></li>
                    <li><a href="index.php?action=register">Create an Account</a></li>
                    <li><a href="index.php?action=catalog">Catalog</a></li>
                    <li> <?php if (!isset($_SESSION['loggedIn'])) {
   ?> <a href="index.php?action=login"><?php
                                echo htmlspecialchars($LoggedInStatus);
                            }
                            ?></a> <?php
                        if ($_SESSION['loggedIn'] === false) {
                            ?> <a href="index.php?action=login"> <?php
                                    echo htmlspecialchars($LoggedInStatus);
                                }
                                ?></a>
                        <?php if ($_SESSION['loggedIn'] === true) {
                            ?> <a href="index.php?action=logout"><?php
                                    echo htmlspecialchars($LoggedInStatus);
                                }
                                ?></a> 

                    </li>
                </ul>
            </navbar>
            <form action="index.php" method="post">
                <div id="entry">
                    <input type="hidden" name="action" value="login">

                    <span class="errors"><?php if ($message != '') {
                                echo htmlspecialchars($message);
                            } ?></span><br>

                    <label>Alias: </label>
                    <input type="text" name="alias" value="<?php echo htmlspecialchars($alias); ?>"><br><br>

                    <label>Password: </label>
                    <input type="text" name="password" value="<?php echo htmlspecialchars($password) ?>"><br><br>

                    <label>&nbsp;</label>
                    <input type="submit" value="Login"><br>
                </div>
            </form>
        </div>
    </body>
</html>