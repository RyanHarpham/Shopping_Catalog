<!DOCTYPE html>
<html>
    <body>
        <div id="shoppingcart">
            <a href="index.php?action=shoppingcart"><img src="pics/shoppingcart.png"></a>
        </div>
        <div id="container">
            <header>
                <meta charset="UTF-8">
                <link rel="stylesheet" type="text/css" href="finalCSS.css">
                <title>Delete User?</title>
            </header>
            <navbar>
                <ul>
                    <li><a href="index.php?action=homepage">Home</a></li>
                    <li><a href="index.php?action=register">Create an Account</a></li>
                    <li><a href="index.php?action=catalog">Catalog</a></li>
                    <li>
                        <?php if (!isset($_SESSION['loggedIn'])) { ?><?php
                            echo htmlspecialchars('');
                        }
                        ?><?php
                        if ($_SESSION['loggedIn'] === false) {
                            ?><?php
                            echo htmlspecialchars('');
                        }
                        ?>
                        <?php if ($_SESSION['loggedIn'] === true) {
                            ?><a href="index.php?action=users_orders"><?php
                                echo htmlspecialchars('My Orders');
                            }
                            ?></a>
                    </li>
                    <li>
                        <?php if (!isset($_SESSION['loggedInRole'])) { ?><?php
                            echo htmlspecialchars('');
                        }
                        ?><?php
                        if ($_SESSION['loggedInRole'] === "Regular") {
                            ?><?php
                            echo htmlspecialchars('');
                        }
                        ?>
                        <?php if ($_SESSION['loggedInRole'] === 'Admin') {
                            ?><a href="index.php?action=adminHub"><?php
                                echo htmlspecialchars('Admin Hub');
                            }
                            ?></a>
                    </li>
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
                    <li id='navAlias'>
                        <?php if (!isset($_SESSION['loggedIn'])) { ?><?php
                            echo htmlspecialchars('');
                        }
                        ?><?php
                        if ($_SESSION['loggedIn'] === false) {
                            ?><?php
                            echo htmlspecialchars('');
                        }
                        ?>
                        <?php if ($_SESSION['loggedIn'] === true) {
                            ?><?php
                            echo htmlspecialchars('Welcome ' . $_SESSION['loggedInAlias']);
                        }
                        ?>
                    </li>
                </ul>
            </navbar>
            <h1 class="center">Are you sure you want to delete <?php echo htmlspecialchars($name) ?>?</h1>
            <form action="index.php" method="post">
                <input type="hidden" name="action" value="deleteUserConfirm">
                <input type="hidden" name="alias" value="<?php echo htmlspecialchars($alias); ?>">
                <input type="hidden" name="deleteConfirmation" value="yes">
                <button class="adminbutton" style="vertical-align:middle"><span>Yes &#8594;</span></button><br>
            </form>
            <form action="index.php" method="post">
                <input type="hidden" name="action" value="deleteUserConfirm">      
                <input type="hidden" name="deleteConfirmation" value="no">
                <button class="adminbutton" style="vertical-align:middle"><span>No &#8594;</span></button><br>
            </form>
        </div>
    </body>
</html>