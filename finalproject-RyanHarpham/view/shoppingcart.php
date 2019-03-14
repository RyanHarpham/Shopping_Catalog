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
                <title>Your Cart</title>
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
            <?php
            if (isset($_SESSION["cart"])) {
                ?>
                <a id="emptycart" href="index.php?action=emptycart">Empty Cart</a>
                <table id="accountsTable" cellpadding="10" cellspacing="1">
                    <tbody>
                        <tr>
                            <th></th>
                            <th style="text-align:left;">Name</th>
                            <th style="text-align:right;" width="5%">Quantity</th>
                            <th style="text-align:right;" width="10%">Unit Price</th>
                            <th style="text-align:right;" width="10%">Price</th>
                            <th style="text-align:center;" width="5%">Remove</th>
                        </tr>	
                        <?php
                        foreach ($_SESSION["cart"] as $item) {
                            $item_price = $item["quantity"] * $item["price"];
                            ?>
                            <tr>
                                <td><img src="pics/<?php echo htmlspecialchars($item["image"]); ?>"/></td>
                                <td><?php echo $item["name"]; ?></td>
                                <!--<td style="text-align:right;"><?php echo htmlspecialchars($item["quantity"]); ?></td>-->
                                <td style="text-align:right;"><input type="number" id="quantity" min="1" max="25" required value="<?php echo htmlspecialchars($item["quantity"]); ?>"></td>
                                <td style="text-align:center;"><?php echo htmlspecialchars("$" . $item["price"]); ?></td><!--                                <td style="text-align:center;"><?php echo htmlspecialchars("$" . number_format($item_price, 2)); ?></td>-->
                                <td style="text-align:center;"><?php echo htmlspecialchars("$" . number_format($item_price, 2)); ?></td>
                                <td style="text-align:center;"><a href="index.php?action=remove_item_from_cart&productID=<?php echo htmlspecialchars($item["id"]); ?>"><img src="pics/trashcan.jpg" height="50" width="50" alt="Remove Item" /></a></td>
                            </tr>
                            <?php
                            $total_quantity += $item["quantity"];
                            $total_price += ($item["price"] * $item["quantity"]);
                        }
                        ?>

                        <tr id="totalcart">
                            <td colspan="2" align="right">Total:</td>
                            <td align="right"><?php echo htmlspecialchars($total_quantity); ?></td>
                            <td align="right" colspan="2"><strong><?php echo htmlspecialchars("$" . number_format($total_price, 2)); ?></strong></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table><br><br>
                <form action="." method="post">
                    <input type="hidden" name="action"
                           value="finalizeOrder">
                    <input type="hidden" name="totalPrice" value="<?php echo htmlspecialchars($total_price); ?>">
                    <input type="submit" value="Finalize Order" id="finalizecart">
                </form><br><br>
                <?php
            } else {
                ?>
                <div><a id="emptycart" href="index.php?action=catalog">Your Cart is Empty</a></div>
                <?php
            }
            ?>
        </div>
    </div>
</body>
</html>
