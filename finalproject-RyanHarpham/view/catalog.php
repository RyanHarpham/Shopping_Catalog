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
                <title>Shopping Catalog</title>
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
            <div class="center">
                <?php
                if ($message != '') {
                    echo htmlspecialchars($message);
                }
                ?>
            </div>
            <table id="accountsTable">
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th></th>
                </tr>
                <?php foreach ($allProducts as $product) : ?>
                    <?php foreach ($inventory as $invent) : ?>
                        <?php if ($product->getProductID() === $invent['ProductID'] && $invent['TotalQuantity'] != 0) : ?>
                            <tr>
                                <td><img src='pics/<?php echo htmlspecialchars($product->getImage()); ?>'</td>
                                <td><?php echo htmlspecialchars($product->getProductName()); ?></td>
                                <td><?php echo htmlspecialchars($product->getProductDescription()); ?></td>
                                <td><?php echo htmlspecialchars($product->getPriceFormatted()); ?></td>
                                <td><form action="." method="post">
                                        <input type="hidden" name="action"
                                               value="add_to_cart">
                                        <input type="hidden" name="productID"
                                               value="<?php echo htmlspecialchars($product->getProductID()); ?>">
                                        <input type="hidden" name="inventQuantity"
                                               value="<?php echo htmlspecialchars($invent['TotalQuantity']); ?>">
                                        <input type="number" name="quantity" min="1" max="25" required value="1">
                                        <input type="submit" value="Add to Cart">
                                    </form>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </table>
            <div class="pagination">
                <?php
                for ($page = 1; $page <= $number_of_pages; $page++) {
                    echo '<a href="index.php?action=catalog&catalog_page=' . $page . '">' . $page . '</a> ';
                }
                ?>
            </div>
        </div>
    </body>
</html>
