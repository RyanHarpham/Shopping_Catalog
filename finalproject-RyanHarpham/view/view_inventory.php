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
                <title>Inventory</title>
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
            <br>
            <table id="accountsTable">
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Quantity in Stock</th>
                    <th></th>
                </tr>
                <?php foreach ($allInventory as $invent) : ?>
                    <tr>
                        <td><img src='pics/<?php echo htmlspecialchars($invent['Image']); ?>'</td>
                        <td><?php echo htmlspecialchars($invent['Name']); ?></td>
                        <td><?php echo htmlspecialchars($invent['TotalQuantity']); ?></td>
                        <td><form action="." method="post">
                                <input type="hidden" name="action"
                                       value="update_invent_quantity">
                                <input type="hidden" name="productID"
                                       value="<?php echo htmlspecialchars($invent['ProductID']); ?>">
                                <input type="number" name="quantity" min="0" max="100" required value="<?php echo htmlspecialchars($invent['TotalQuantity']); ?>">
                                <input type="submit" value="Update Quantity">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <div class="pagination">
                <?php
                for ($page = 1; $page <= $number_of_pages; $page++) {
                    echo '<a href="index.php?action=view_inventory&invent_page=' . $page . '">' . $page . '</a> ';
                }
                ?>
            </div>
        </div>
    </body>
</html>
