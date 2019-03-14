<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="finalCSS.css">
        <title>Finalize your Order</title>
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
                <input type="hidden" name="action" value="confirmOrder">
                <input type="hidden" name="pbTax" value="<?php echo htmlspecialchars($totalCartPrice); ?>">
                <input type="hidden" name="theTax" value="<?php echo htmlspecialchars($tax); ?>">
                <input type="hidden" name="totalPrice" value="<?php echo htmlspecialchars($totalPrice); ?>">
                <div id="entry">
                    <label>Price before Tax: </label>
                    <input type="text" name="priceBeforeTax" readonly value="<?php echo htmlspecialchars("$" . number_format($totalCartPrice, 2)); ?>"><br><br>

                    <label>Tax: </label>
                    <input type="text" name="tax" readonly value="<?php echo htmlspecialchars("$" . number_format($tax, 2)); ?>"><br><br>

                    <label>Total Price: </label>
                    <input type="text" name="totalCost" readonly value="<?php echo htmlspecialchars("$" . number_format($totalPrice, 2)); ?>"><br><br>

                    <label>Credit/Debit Card: </label>
                    <input type="text" name="cardNumber" value="<?php echo htmlspecialchars($cardNumber); ?>" placeholder="1111222233334444"><br>

                    <span class="errors"><?php
                        if ($cardNumberError != '') {
                            echo htmlspecialchars($cardNumberError);
                        }
                        ?></span><br>

                    <label>CVV: </label>
                    <input type="text" name="cvv" value="<?php echo htmlspecialchars($CVV); ?>" placeholder="123"><br>

                    <span class="errors"><?php
                        if ($cvvError != '') {
                            echo htmlspecialchars($cvvError);
                        }
                        ?></span><br>

                    <label>&nbsp;</label>
                    <input type="submit" value="Place Order" id="button"><br>
                    </form>
                </div>
        </div>
    </body>
</html>
