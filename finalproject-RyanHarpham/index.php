<?php

// Ryan Harpham
// 1/8/2019
// Final Project - Shopping Catalog
// 
// include things that you require here
require_once 'model/Database.php';
require_once 'model/databaseFUN.php';
require_once 'model/Person.php';
require_once 'model/Product.php';
require_once 'model/Order.php';

// Set the default action
$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'homepage';
    }
}

// Start the Session
session_start();

// Setting up Logged in status
if (!isset($_SESSION['loggedIn'])) {
    $_SESSION['loggedIn'] = false;
    $LoggedInStatus = 'Login';
} else if ($_SESSION['loggedIn'] === TRUE) {
    $LoggedInStatus = 'Logout';
} else if ($_SESSION['loggedIn'] === FALSE) {
    $LoggedInStatus = 'Login';
}

if (!isset($_SESSION['loggedInRole'])) {
    $_SESSION['loggedInRole'] = "Regular";
}

switch ($action) {
    case "homepage":
        $topFiveProducts = select_top_5_products();
        include('view/homepage.php');
        exit();
        break;
    case 'register':
        $message = filter_input(INPUT_GET, 'message');

        if (!isset($fname)) {
            $fname = '';
        }
        if (!isset($lname)) {
            $lname = '';
        }
        if (!isset($alias)) {
            $alias = '';
        }
        if (!isset($email)) {
            $email = '';
        }
        if (!isset($password)) {
            $password = '';
        }
        if (!isset($firstNameError)) {
            $firstNameError = '';
        }
        if (!isset($lastNameError)) {
            $lastNameError = '';
        }
        if (!isset($validAliasError)) {
            $validAliasError = '';
        }
        if (!isset($validEmailError)) {
            $validEmailError = '';
        }
        if (!isset($validPasswordError)) {
            $validPasswordError = [];
        }

        include('view/register.php');
        exit();
        break;
    case 'catalog':
        $count = get_all_products_count();
        $number_of_results = $count[0]['Count'];
        $results_per_page = 5;

        $number_of_pages = ceil($number_of_results / $results_per_page);

        if (!isset($_GET['catalog_page'])) {
            $page = 1;
        } else {
            $page = $_GET['catalog_page'];
        }

        $this_page_first_result = ($page - 1) * $results_per_page;

        $inventory = select_inventory();
        $allProducts = get_all_products($this_page_first_result, $results_per_page);
        $message = filter_input(INPUT_GET, 'message');
        if (!isset($message)) {
            $message = '';
        }
        include ('view/catalog.php');
        exit();
        break;
    case 'confirm':
        $fname = filter_input(INPUT_POST, 'fname');
        $lname = filter_input(INPUT_POST, 'lname');
        $alias = filter_input(INPUT_POST, 'alias');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');
        $firstNameError = '';
        $lastNameError = '';
        $validEmailError = '';
        $validAliasError = '';
        $validPasswordError = [];
        $usedEmail = check_email($email);
        $usedAlias = check_alias($alias);
        $validFName = preg_match('^[a-zA-Z][a-zA-Z0-9]{3,29}$^', $fname);
        $validLName = preg_match('^[a-zA-Z][a-zA-Z0-9]{3,29}$^', $lname);
        $validAlias = preg_match('^[a-zA-Z][a-zA-Z0-9]{3,29}$^', $alias);
        $noUpperCasePassword = preg_match('/[A-Z]/', $password);
        $noLowerCasePassword = preg_match('/[a-z]/', $password);
        $noDigitPassword = preg_match('/\d{1}/', $password);
        $passwordLength = strlen($password);

        if ($validFName === 0) {
            $firstNameError = 'First name must begin with a letter and be at least 4 characters long';
        }
        if (empty($fname)) {
            $firstNameError = 'Please enter something for your first name.';
        }
        if ($validLName === 0) {
            $lastNameError = 'Last name must begin with a letter and be at least 4 characters long.';
        }
        if (empty($lname)) {
            $lastNameError = 'Please enter something for your last name.';
        }
        if ($validAlias === 0) {
            $validAliasError = 'Alias must begin with a letter and be at least 4 characters long.';
        }
        if (empty($alias)) {
            $validAliasError = 'Please enter a username';
        }
        if ($email === FALSE) {
            $validEmailError = 'Please enter a valid email address.';
        }
        if (empty($email)) {
            $validEmailError = 'Please enter a valid email address.';
        }
        if (!empty($usedEmail)) {
            $validEmailError = 'That email is already in use, please enter another one.';
        }
        if (!empty($usedAlias)) {
            $validAliasError = 'That alias is already in use, please enter another one.';
        }
        if ($noUpperCasePassword === 0) {
            $validPasswordError[0] = 'Password needs to include an uppercase letter.';
        }
        if ($noLowerCasePassword === 0) {
            $validPasswordError[1] = 'Password needs to include an lowercase letter.';
        }
        if ($noDigitPassword === 0) {
            $validPasswordError[2] = 'Password needs to include a digit.';
        }
        if ($passwordLength < 10) {
            $validPasswordError[3] = 'Password needs to be at least ten characters long.';
        }
// if an error message exists, go to the index page
        if ($firstNameError != '' || $lastNameError != '' || $validEmailError != '' || $validAliasError != '' || $validPasswordError !== []) {
            include('view/register.php');
            exit();
        } else {
            $options = ['cost' => 11];
            $hash = password_hash($password, PASSWORD_BCRYPT, $options);
            $newPerson = new Person($fname, $lname, $alias, $email, $hash);
            insert_person($newPerson);
            insert_role($alias);
            include('view/confirm.php');
            exit();
            break;
        }
    case 'login':
        $message = filter_input(INPUT_GET, 'message');
        $alias = filter_input(INPUT_POST, 'alias');
        $password = filter_input(INPUT_POST, 'password');
        $aliasExists = check_login_alias($alias);
        if ($alias === NULL && $password === NULL) {
            $message = '';
        } else if ($aliasExists === FALSE) {
            $message = 'Your username or password is incorrect.';
        } else if ($aliasExists === '') {
            $message = 'You must enter your username and password.';
        } else if ($aliasExists === TRUE) {
            $currentUser = get_login($alias);
            if (password_verify($password, $currentUser)) {
                $role = check_role($alias);
                $_SESSION['loggedIn'] = TRUE;
                $_SESSION['loggedInAlias'] = $alias;
                $_SESSION['loggedInRole'] = $role;
                header('Location: index.php?action=homepage');
                exit();
            } else {
                $_SESSION['loggedIn'] = FALSE;
                $message = 'Your username or password is incorrect.';
                include('view/login.php');
                exit();
            }
        }
        include('view/login.php');
        exit();
        break;
    case 'logout':
        session_destroy();
        $_SESSION[] = array();
        $_SESSION['loggedIn'] = false;
        $_SESSION['loggedInRole'] = 'Regular';
        unset($_SESSION["cart"]);
        header('Location: index.php?action=login');
        exit();
        break;
    case 'adminHub':
        include ('view/adminhub.php');
        exit();
        break;
    case 'manage_accounts':
        $allUsers = get_all_users();
        include ('view/manageaccounts.php');
        exit();
        break;
    case 'manage_products':
        $count = get_all_products_count();
        $number_of_results = $count[0]['Count'];
        $results_per_page = 5;

        $number_of_pages = ceil($number_of_results / $results_per_page);

        if (!isset($_GET['product_page'])) {
            $page = 1;
        } else {
            $page = $_GET['product_page'];
        }

        $this_page_first_result = ($page - 1) * $results_per_page;

        $allProducts = get_all_products($this_page_first_result, $results_per_page);
        include ('view/manageproducts.php');
        exit();
        break;
    case 'delete_user':
        $alias = filter_input(INPUT_POST, 'alias');
        $name = get_users_name($alias);
        include 'view/delete_user.php';
        exit();
        break;
    case 'deleteUserConfirm':
        $deleteConfirmation = filter_input(INPUT_POST, 'deleteConfirmation');
        if ($deleteConfirmation == 'yes') {
            $alias = filter_input(INPUT_POST, 'alias');
            if ($alias !== null) {
                delete_user_from_orders($alias);
                delete_role($alias);
                delete_user($alias);
            }
            header('Location: index.php?action=manage_accounts');
        } else {
            header('Location: index.php?action=manage_accounts');
        }
        exit();
        break;

    case 'update_user':
        $alias = filter_input(INPUT_POST, 'alias');
        $userInfo = get_users_info($alias);
        $oldEmail = $userInfo['Email'];

        $message = filter_input(INPUT_GET, 'message');

        if (!isset($fname)) {
            $fname = $userInfo['FirstName'];
        }
        if (!isset($lname)) {
            $lname = $userInfo['LastName'];
        }
        if (!isset($email)) {
            $email = $userInfo['Email'];
        }
        if (!isset($newPassword)) {
            $newPassword = '';
        }
        if (!isset($confirmPassword)) {
            $confirmPassword = '';
        }
        if (!isset($firstNameError)) {
            $firstNameError = '';
        }
        if (!isset($lastNameError)) {
            $lastNameError = '';
        }
        if (!isset($validEmailError)) {
            $validEmailError = '';
        }
        if (!isset($validPasswordError)) {
            $validPasswordError = [];
        }

        include ('view/update_user_info.php');
        exit();
        break;
    case 'updateUserConfirm':
        $fname = filter_input(INPUT_POST, 'fname');
        $lname = filter_input(INPUT_POST, 'lname');
        $alias = filter_input(INPUT_POST, 'alias');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $oldEmail = filter_input(INPUT_POST, 'old_email');
        $newPassword = filter_input(INPUT_POST, 'newPassword');
        $confirmPassword = filter_input(INPUT_POST, 'confirmPassword');
        $role = ucwords($_POST['roles']);
        $firstNameError = '';
        $lastNameError = '';
        $validEmailError = '';
        $validPasswordError = [];
        $usedEmail = '';
        if ($oldEmail != $email) {
            $usedEmail = check_email($email);
        }
        $validFName = preg_match('^[a-zA-Z][a-zA-Z0-9]{3,29}$^', $fname);
        $validLName = preg_match('^[a-zA-Z][a-zA-Z0-9]{3,29}$^', $lname);
        $noUpperCasePassword = preg_match('/[A-Z]/', $newPassword);
        $noLowerCasePassword = preg_match('/[a-z]/', $newPassword);
        $noDigitPassword = preg_match('/\d{1}/', $newPassword);
        $passwordLength = strlen($newPassword);

        if ($validFName === 0) {
            $firstNameError = 'First name must begin with a letter and be at least 4 characters long';
        }
        if (empty($fname)) {
            $firstNameError = 'Please enter something for your first name.';
        }
        if ($validLName === 0) {
            $lastNameError = 'Last name must begin with a letter and be at least 4 characters long.';
        }
        if (empty($lname)) {
            $lastNameError = 'Please enter something for your last name.';
        }
        if ($email === FALSE) {
            $validEmailError = 'Please enter a valid email address.';
        }
        if (empty($email)) {
            $validEmailError = 'Please enter a valid email address.';
        }
        if (!empty($usedEmail)) {
            $validEmailError = 'That email is already in use, please enter another one.';
        }
        if ($noUpperCasePassword === 0) {
            $validPasswordError[0] = 'Password needs to include an uppercase letter.';
        }
        if ($noLowerCasePassword === 0) {
            $validPasswordError[1] = 'Password needs to include an lowercase letter.';
        }
        if ($noDigitPassword === 0) {
            $validPasswordError[2] = 'Password needs to include a digit.';
        }
        if ($passwordLength < 10) {
            $validPasswordError[3] = 'Password needs to be at least ten characters long.';
        }
        if ($newPassword !== $confirmPassword) {
            $validPasswordError[4] = 'Passwords need to match.';
        }
        if ($role != 'Admin') {
            $role == 'Regular';
        }

        if ($firstNameError != '' || $lastNameError != '' || $validEmailError != '' || $validPasswordError !== []) {
            include('view/update_user_info.php');
            exit();
        } else {
            $options = ['cost' => 11];
            $hash = password_hash($newPassword, PASSWORD_BCRYPT, $options);
            update_user_info($alias, $fname, $lname, $email, $hash);
            update_role($alias, $role);
            header('Location: index.php?action=manage_accounts');
        }
        exit();
        break;
    case 'update_product':
        $productID = filter_input(INPUT_POST, 'productID');
        $productInfo = get_product_info($productID);

        $message = filter_input(INPUT_GET, 'message');

        if (!isset($name)) {
            $name = $productInfo['Name'];
        }
        if (!isset($description)) {
            $description = $productInfo['Description'];
        }
        if (!isset($price)) {
            $price = $productInfo['Price'];
        }
        if (!isset($imgError)) {
            $imgError = '';
        }
        if (!isset($nameError)) {
            $nameError = '';
        }
        if (!isset($descriptionError)) {
            $descriptionError = '';
        }
        if (!isset($priceError)) {
            $priceError = '';
        }

        include ('view/update_product_info.php');
        exit();
        break;

    case 'updateProductConfirm':
        $productID = filter_input(INPUT_POST, 'productID');
        $name = filter_input(INPUT_POST, 'name');
        $description = filter_input(INPUT_POST, 'description');
        $price = filter_input(INPUT_POST, 'price');
        $nameError = '';
        $descriptionError = '';
        $priceError = '';
        $validPrice = is_numeric($price);

        if (empty($name)) {
            $nameError = 'Please enter something for the product name.';
        }
        if (empty($description)) {
            $descriptionError = 'Please enter something for the product description.';
        }
        if ($validPrice === FALSE) {
            $priceError = 'Please enter a valid price.';
        }
        if (empty($price)) {
            $priceError = 'Please enter something for the product price.';
        }

        if ($nameError != '' || $descriptionError != '' || $priceError != '') {
            include('view/update_product_info.php');
            exit();
        } else {
            update_product_info($productID, $name, $description, $price);
            header('Location: index.php?action=manage_products');
        }
        exit();
        break;
    case 'addProduct':
        $message = filter_input(INPUT_GET, 'message');

        if (!isset($name)) {
            $name = '';
        }
        if (!isset($description)) {
            $description = '';
        }
        if (!isset($price)) {
            $price = '';
        }
        if (!isset($nameError)) {
            $nameError = '';
        }
        if (!isset($descriptionError)) {
            $descriptionError = '';
        }
        if (!isset($priceError)) {
            $priceError = '';
        }

        include ('view/add_product.php');
        exit();
        break;
    case 'addProductConfirm':
        $name = filter_input(INPUT_POST, 'name');
        $description = filter_input(INPUT_POST, 'description');
        $price = filter_input(INPUT_POST, 'price');
        $nameError = '';
        $descriptionError = '';
        $priceError = '';
        $validPrice = is_numeric($price);

        if (empty($name)) {
            $nameError = 'Please enter something for the product name.';
        }
        if (empty($description)) {
            $descriptionError = 'Please enter something for the product description.';
        }
        if ($validPrice === FALSE) {
            $priceError = 'Please enter a valid price.';
        }
        if (empty($price)) {
            $priceError = 'Please enter something for the product price.';
        }

        if ($nameError != '' || $descriptionError != '' || $priceError != '') {
            include('view/add_product.php');
            exit();
        } else {
            insert_product($name, $description, $price);
            $id = select_last_inserted_product();
            insert_inventory($id);
            header('Location: index.php?action=manage_products');
        }
        exit();
        break;
    case 'delete_product':
        $productID = filter_input(INPUT_POST, 'productID');
        $info = get_product_info($productID);
        $name = $info['Name'];
        include 'view/delete_product.php';
        exit();
        break;

    case 'deleteProductConfirm':
        $deleteConfirmation = filter_input(INPUT_POST, 'deleteConfirmation');
        if ($deleteConfirmation == 'yes') {
            $productID = filter_input(INPUT_POST, 'productID');
            if ($productID !== null) {
                delete_product_inventory($productID);
                delete_product_order($productID);
                delete_product($productID);
            }
            header('Location: index.php?action=manage_products');
        } else {
            header('Location: index.php?action=manage_products');
        }
        exit();
        break;
    case 'add_to_cart':
        $quantity = filter_input(INPUT_POST, 'quantity');
        $inventQuantity = filter_input(INPUT_POST, 'inventQuantity');
        $productID = filter_input(INPUT_POST, 'productID');
        $productInfo = get_product_info($productID);

        if (!empty($quantity)) {
            if ($quantity <= $inventQuantity) {
                $quantity = $quantity <= 0 ? 1 : $quantity;

                $itemArray = array($productInfo["ProductID"] => array('name' => $productInfo["Name"],
                        'id' => $productInfo["ProductID"], 'quantity' => $quantity, 'price' => $productInfo["Price"],
                        'image' => $productInfo["Image"]));
                $message = '';



                if (!empty($_SESSION["cart"])) {
                    if (in_array($productInfo["ProductID"], array_keys($_SESSION["cart"]))) {
                        foreach ($_SESSION["cart"] as $k => $v) {
                            if ($productInfo["ProductID"] == $k) {
                                if (empty($_SESSION["cart"][$k]["quantity"])) {
                                    $_SESSION["cart"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart"][$k]["quantity"] += $quantity;
                                header('Location: index.php?action=catalog&message=' . $productInfo['Name'] . " was added to the cart.");
                            }
                        }
                    } else {
                        $_SESSION["cart"] += $itemArray;
                        header('Location: index.php?action=catalog&message=' . $productInfo['Name'] . " was added to the cart.");
                    }
                } else {
                    $_SESSION["cart"] = $itemArray;
                    header('Location: index.php?action=catalog&message=' . $productInfo['Name'] . " was added to the cart.");
                }
            } else {
                header('Location: index.php?action=catalog&message=' . $productInfo['Name'] . " was NOT added to the cart. Quantity bought exceeded inventory quantity.");
            }
        }
        exit();
        break;
    case 'shoppingcart':
        if (isset($_SESSION["cart"])) {
            $total_quantity = 0;
            $total_price = 0;
        }
        include('view/shoppingcart.php');
        exit();
        break;
    case 'remove_item_from_cart':
        $productID = filter_input(INPUT_GET, 'productID');
        if (!empty($_SESSION["cart"])) {
            foreach ($_SESSION["cart"] as $k => $v) {
                if ($productID == $k)
                    unset($_SESSION["cart"][$k]);
                if (empty($_SESSION["cart"]))
                    unset($_SESSION["cart"]);
            }
        }
        header('Location: index.php?action=shoppingcart');
        exit();
        break;
    case "emptycart":
        unset($_SESSION["cart"]);
        header('Location: index.php?action=shoppingcart');
        break;
    case 'upload':
        if (isset($_FILES['image'])) {
            $imgError = '';
            $productID = filter_input(INPUT_POST, 'productID');
            $productInfo = get_product_info($productID);
            $ourPicFileNames = $productInfo['Name'] . $productID;
            $errors = array();
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];
            $temp = $_FILES['image']['name'];
            $temp = explode('.', $temp);
            $temp = end($temp);
            $file_ext = strtolower($temp);
            $extensions = array("jpeg", "jpg", "png", "gif");
            if (in_array($file_ext, $extensions) === false) {
                $imgError = "file extension not in whitelist: " . join(',', $extensions);
            }
            if ($file_size === 0) {
                $imgError = "Product image must be of smaller size (less than 4 MB)";
            }
            if (empty($imgError) == true) {
                move_uploaded_file($file_tmp, "pics/" . $ourPicFileNames . '.' . $file_ext);
                $ourPicFileNames .= '.' . $file_ext;
                update_product_picture($productID, $ourPicFileNames);
                header('Location: index.php?action=manageproducts');
            } else {
                if (!isset($imgError)) {
                    $imgError = 'There was a problem uploading your image.';
                }
                header('Location: index.php?action=update_product_info.php&imgError=' . $imgError);
            }
        }
        break;
    case 'finalizeOrder':
        if ($_SESSION['loggedIn'] === true) {
            $totalCartPrice = filter_input(INPUT_POST, 'totalPrice');
            $tax = $totalCartPrice * 0.075;
            $totalPrice = $totalCartPrice + $tax;

            if (!isset($cardNumber)) {
                $cardNumber = '';
            }
            if (!isset($CVV)) {
                $CVV = '';
            }

            if (!isset($cardNumberError)) {
                $cardNumberError = '';
            }
            if (!isset($cvvError)) {
                $cvvError = '';
            }

            include 'view/finalizeOrder.php';
        } else {
            header('Location: index.php?action=login&message=You need to be logged in to view that page.');
        }
        exit();
        break;
    case 'confirmOrder':
        $order = new Order(1, 1);
        $theOrderID = select_order_id();
        $cardNumber = filter_input(INPUT_POST, 'cardNumber');
        $totalCartPrice = filter_input(INPUT_POST, 'pbTax');
        $tax = filter_input(INPUT_POST, 'theTax');
        $totalPrice = filter_input(INPUT_POST, 'totalPrice');
        $CVV = filter_input(INPUT_POST, 'cvv');
        $cvvError = '';
        $cardNumberError = '';
        $validCard = is_numeric($cardNumber);
        $validCVV = is_numeric($CVV);

        if ($validCard == false) {
            $cardNumberError = 'You need to enter a valid card number.';
        }
        if ($cardNumber < 1000000000000000 || $cardNumber > 9999999999999999) {
            $cardNumberError = 'You need to enter a valid card number.';
        }
        if ($validCVV == false) {
            $cvvError = 'You need to enter a valid CVV.';
        }
        if ($CVV < 100 || $CVV > 999) {
            $cvvError = 'You need to enter a valid CVV.';
        }

        if ($cardNumberError != '' || $cvvError != '') {
            include('view/finalizeOrder.php');
            exit();
        } else {
            $inventory = select_inventory();
            //insert order into database
            foreach ($_SESSION["cart"] as $k => $v) {
                foreach ($inventory as $invent) {
                    if ($invent['ProductID'] === $_SESSION['cart'][$k]['id']) {
                        $inventQuantity = intval($invent['TotalQuantity']);
                        $newQuantity = $inventQuantity - $_SESSION['cart'][$k]['quantity'];

                        insert_order($theOrderID, $_SESSION['cart'][$k]['id'], $_SESSION['cart'][$k]['quantity'], $order->getTimePlaced(), $_SESSION['loggedInAlias'], $totalPrice);
                        update_inventory($newQuantity, $_SESSION['cart'][$k]['id']);
                    }
                }
            }

            header('Location: index.php?action=orderPlaced');
        }
        exit();
        break;
    case 'orderPlaced':
        $theOrderID = select_order_id();
        $theOrderID++;
        update_order_id($theOrderID);
        unset($_SESSION['cart']);
        include('view/orderPlaced.php');
        exit();
        break;
    case 'view_orders':
        $count = select_all_orders_count();
        $number_of_results = $count[0]['Count'];

        $results_per_page = 5;
        $number_of_pages = ceil($number_of_results / $results_per_page);

        if (!isset($_GET['order_page'])) {
            $page = 1;
        } else {
            $page = $_GET['order_page'];
        }

        $this_page_first_result = ($page - 1) * $results_per_page;

        $allOrders = select_all_orders_test($this_page_first_result, $results_per_page);
        include('view/view_orders.php');
        exit();
        break;
    case 'view_inventory':
        $count = select_inventory_count();
        $number_of_results = $count[0]['Count'];
        $results_per_page = 5;

        $number_of_pages = ceil($number_of_results / $results_per_page);

        if (!isset($_GET['invent_page'])) {
            $page = 1;
        } else {
            $page = $_GET['invent_page'];
        }

        $this_page_first_result = ($page - 1) * $results_per_page;

        $allInventory = select_inventory_with_images($this_page_first_result, $results_per_page);
        include('view/view_inventory.php');
        exit();
        break;
    case 'update_invent_quantity':
        $productID = filter_input(INPUT_POST, 'productID');
        $quantity = filter_input(INPUT_POST, 'quantity');
        if ($quantity >= 0) {
            update_inventory($quantity, $productID);
        }
        header('Location: index.php?action=view_inventory');
        exit();
        break;
    case 'users_orders':
        $count = select_users_orders_count($_SESSION['loggedInAlias']);
        $number_of_results = $count[0]['Count'];

        $results_per_page = 5;
        $number_of_pages = ceil($number_of_results / $results_per_page);

        if (!isset($_GET['my_order_page'])) {
            $page = 1;
        } else {
            $page = $_GET['my_order_page'];
        }

        $this_page_first_result = ($page - 1) * $results_per_page;

        $allOrders = select_all_orders_from_a_user($this_page_first_result, $results_per_page, $_SESSION['loggedInAlias']);
        include('view/users_orders.php');
        exit();
        break;
    default:
        $topFiveProducts = select_top_5_products();
        include('view/homepage.php');
        exit();
        break;
}
?>