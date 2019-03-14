<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <body>
        <div id="shoppingcart">
            <a href="index.php?action=shoppingcart"><img src="pics/shoppingcart.png"></a>
        </div>
        <div id="container">
            <header>
                <meta charset="UTF-8">
                <link rel="stylesheet" type="text/css" href="finalCSS.css">
                <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
                <script src="slideshow.js"></script>
                <title>Welcome to The Ol' Shoppe</title>
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
            <h1 id="header">Welcome!</h1>
            <p id="mainpageText">Here at the Ol' Shoppe, you'll be able to find all sorts of new and exciting goodies. Take a look around, shop a little, gaze at all of our amazing products!</p>
            <br><br><br><br>
            <p id="slideshowTitle"><?php echo htmlspecialchars($topFiveProducts[0]['Name'] . ' - $' . $topFiveProducts[0]['Price']); ?></p>
            <img id="slideshowImage" src="pics/<?php echo htmlspecialchars($topFiveProducts[0]['Image']); ?>">
            <div id="slideshow">
                <div id="left_button" class="button_panel"><img src="pics/left.jpg" alt=""></div>
                <div id="display_panel"> 
                    <ul id="image_list">
                        <?php foreach ($topFiveProducts as $product) : ?>
                            <li><a href='pics/<?php echo htmlspecialchars($product['Image']); ?>'><img src='pics/<?php echo htmlspecialchars($product['Image']); ?>' 
                                                                                                       alt="<?php echo htmlspecialchars($product['Name'] . '$' . $product['Price']); ?>"></a></li>
                            <?php endforeach; ?>
                    </ul>
                </div>
                <div id="right_button" class="button_panel"><img src="pics/right.jpg" alt=""></div>
            </div>

        </div>
    </body>
</html>
