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
                <title>Manage Accounts</title>
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
            <table id="accountsTable">
                <tr>
                    <th>Alias</th>
                    <th>Email</th>
                    <th>Name</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php foreach ($allUsers as $user) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user->getAlias()); ?></td>
                        <td><?php echo htmlspecialchars($user->getEmail()); ?></td>
                        <td><?php echo htmlspecialchars($user->getFName() . ' ' . $user->getLName()); ?></td>
                        <td><form action="." method="post">
                                <input type="hidden" name="action"
                                       value="update_user">
                                <input type="hidden" name="alias"
                                       value="<?php echo htmlspecialchars($user->getAlias()); ?>">
                                <input type="submit" value="Edit User">
                            </form>
                        </td>
                        <td>
                            <form action="." method="post">
                                <input type="hidden" name="action"
                                       value="delete_user">
                                <input type="hidden" name="alias"
                                       value="<?php echo htmlspecialchars($user->getAlias()); ?>">
                                <input type="submit" value="Delete User">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </body>
</html>
