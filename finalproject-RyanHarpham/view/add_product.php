<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="finalCSS.css">
        <title>Add Product</title>
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
                <input type="hidden" name="action" value="addProductConfirm">
                <div id="entry">
                    <label>Name: </label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>"><br>

                    <span class="errors">
                        <?php
                        if ($nameError != '') {
                            echo htmlspecialchars($nameError);
                        }
                        ?></span><br>

                    <label>Description: </label>
                    <input type="text" name="description" value="<?php echo htmlspecialchars($description); ?>"><br>

                    <span class="errors"><?php
                        if ($descriptionError != '') {
                            echo htmlspecialchars($descriptionError);
                        }
                        ?></span><br>

                    <label>Price: </label>
                    <input type="text" name="price" value="<?php echo htmlspecialchars($price); ?>"><br>
                    <span class="errors"><?php
                        if ($priceError != '') {
                            echo htmlspecialchars($priceError);
                        }
                        ?></span><br>
                </div>
                <label>&nbsp;</label>
                <input type="submit" value="Add Product" id="button"><br>
            </form>
        </div>
    </body>
</html>
