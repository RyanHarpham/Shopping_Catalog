<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="finalCSS.css">
        <title>Update User</title>
    </head>
    <body>
        <div id="shoppingcart">
            <a href="index.php?action=shoppingcart"><img src="pics/shoppingcart.png"></a>
        </div>
        <div id="container">
            <header>
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
            <form action="index.php" method="post">
                <input type="hidden" name="action" value="updateUserConfirm">
                <input type="hidden" name="alias" value="<?php echo htmlspecialchars($alias); ?>">
                <input type="hidden" name="old_email" value="<?php echo htmlspecialchars($oldEmail); ?>">
                <div id="entry">
                    <label>First Name: </label>
                    <input type="text" name="fname" value="<?php echo htmlspecialchars($fname); ?>"><br>

                    <span class="errors">
                        <?php
                        if ($firstNameError != '') {
                            echo htmlspecialchars($firstNameError);
                        }
                        ?></span><br>

                    <label>Last Name: </label>
                    <input type="text" name="lname" value="<?php echo htmlspecialchars($lname); ?>"><br>

                    <span class="errors"><?php
                        if ($lastNameError != '') {
                            echo htmlspecialchars($lastNameError);
                        }
                        ?></span><br>

                    <label>Email: </label>
                    <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>"><br>
                    <span class="errors"><?php
                        if ($validEmailError != '') {
                            echo htmlspecialchars($validEmailError);
                        }
                        ?></span><br>

                    <label>Role: </label>    
                    <select name="roles">
                        <option value="admin">Admin</option>
                        <option value="regular">Regular</option>
                    </select><br><br>

                    <label>New Password: </label>
                    <input type="text" name="newPassword" value="<?php echo htmlspecialchars($newPassword); ?>"><br><br>

                    <label>Confirm Password: </label>
                    <input type="text" name="confirmPassword" value="<?php echo htmlspecialchars($confirmPassword); ?>"><br>
                    <?php foreach ($validPasswordError as $pError) : ?>
                        <span class="errors"><?php
                            if ($pError != '') {
                                echo htmlspecialchars($pError);
                            }
                            ?></span><br>
                    <?php endforeach; ?>
                </div>
                <label>&nbsp;</label>
                <input type="submit" value="Update User Info" id="button"><br>
            </form>
        </div>
    </body>
</html>
