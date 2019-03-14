<?php
function insert_registration($fName, $lName, $alias, $email) {
    $db = Database::getDB();
    $query = 'insert into registration (FirstName, LastName, Alias, Email)
                    VALUES
                    (:fName, :lName, :alias, :email)';
    $statement = $db->prepare($query);
    $statement->bindValue(':fName', $fName);
    $statement->bindValue(':lName', $lName);
    $statement->bindValue(':alias', $alias);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $statement->closeCursor();
}

function insert_role($alias) {
    $db = Database::getDB();
    $query = 'insert into roles (Alias)
                    VALUES
                    (:alias)';
    $statement = $db->prepare($query);
    $statement->bindValue(':alias', $alias);
    $statement->execute();
    $statement->closeCursor();
}

function check_role($alias) {
    $db = Database::getDB();
    $query = 'SELECT Role from roles
                  WHERE Alias = :alias';
    $statement = $db->prepare($query);
    $statement->bindValue(':alias', $alias);
    $statement->execute();
    $role = $statement->fetch();
    $statement->closeCursor();
    return $role[Role];
}

function check_email($email) {
    $db = Database::getDB();
    $query = 'SELECT Email from registration
                  WHERE email = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $usedEmail = $statement->fetchAll();
    $statement->closeCursor();
    return $usedEmail;
}

function check_alias($alias) {
    $db = Database::getDB();
    $query = 'SELECT Alias from registration
                  WHERE Alias = :alias';
    $statement = $db->prepare($query);
    $statement->bindValue(':alias', $alias);
    $statement->execute();
    $usedAlias = $statement->fetchAll();
    $statement->closeCursor();
    return $usedAlias;
}

function insert_person($newPerson) {
    $db = Database::getDB();
    $fName = $newPerson->getFName();
    $lName = $newPerson->getLName();
    $alias = $newPerson->getAlias();
    $email = $newPerson->getEmail();
    $password = $newPerson->getPassword();
    $query = 'insert into registration (FirstName, LastName, Alias, Email, Password)
                    VALUES
                    (:fName, :lName, :alias, :email, :password)';
    $statement = $db->prepare($query);
    $statement->bindValue(':fName', $fName);
    $statement->bindValue(':lName', $lName);
    $statement->bindValue(':alias', $alias);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $statement->closeCursor();
}

function check_login_alias($alias) {
    $db = Database::getDB();
    $itExists = '';
    if ($alias != NULL) {
        $query = 'SELECT Alias from registration
                  WHERE Alias = :alias';
        $statement = $db->prepare($query);
        $statement->bindValue(':alias', $alias);
        $statement->execute();
        $loginAlias = $statement->fetch();
        if ($alias === $loginAlias['Alias']) {
            $itExists = TRUE;
        } else if ($alias != $loginAlias['Alias']) {
            $itExists = FALSE;
        }
        $statement->closeCursor();
    }
    return $itExists;
}

function get_login($alias) {
    $db = Database::getDB();
    $query = 'Select Password from registration WHERE Alias = :alias';
    $statement = $db->prepare($query);
    $statement->bindValue(':alias', $alias);
    $statement->execute();
    $loginInfo = $statement->fetch();
    $statement->closeCursor();
    return $loginInfo[0];
}

function get_all_users() {
    $db = Database::getDB();
    $query = 'Select * from registration';
    $statement = $db->prepare($query);
    $statement->execute();
    $users = $statement->fetchAll();
    $allUsers = [];
    foreach ($users as $key => $value) {
        $allUsers[$value['Alias']] = new Person($value['FirstName'], $value['LastName'], $value['Alias'], $value['Email'], $value['Password']);
    }
    $statement->closeCursor();
    return $allUsers;
}

function get_all_products($page, $results) {
    $db = Database::getDB();
    $query = 'Select * from products LIMIT ' . $page . ',' . $results;
    $statement = $db->prepare($query);
    $statement->execute();
    $products = $statement->fetchAll();
    $allProducts = [];
    foreach ($products as $key => $value) {
        $allProducts[$value['ProductID']] = new Product($value['ProductID'], $value['Image'], $value['Name'], $value['Description'], $value['Price']);
    }
    $statement->closeCursor();
    return $allProducts;
}

function get_all_products_count() {
    $db = Database::getDB();
    $query = 'Select Count(*) as Count from products';
    $statement = $db->prepare($query);
    $statement->execute();
    $products = $statement->fetchAll();
    $statement->closeCursor();
    return $products;
}

function get_users_name($alias) {
    $db = Database::getDB();
    $query = 'Select FirstName, LastName from registration WHERE Alias = :alias';
    $statement = $db->prepare($query);
    $statement->bindValue(':alias', $alias);
    $statement->execute();
    $name = $statement->fetch();
    $statement->closeCursor();
    return $name[0] . ' ' . $name[1];
}

function get_users_info($alias) {
    $db = Database::getDB();
    $query = 'Select * from registration WHERE Alias = :alias';
    $statement = $db->prepare($query);
    $statement->bindValue(':alias', $alias);
    $statement->execute();
    $info = $statement->fetch();
    $statement->closeCursor();
    return $info;
}

function delete_user($alias) {
    $db = Database::getDB();
    $query = 'delete from registration
        where Alias = :alias';
    $statement = $db->prepare($query);
    $statement->bindValue(':alias', $alias);
    $statement->execute();
    $statement->closeCursor();
}

function delete_user_from_orders($alias) {
    $db = Database::getDB();
    $query = 'delete from orders
        where Alias = :alias';
    $statement = $db->prepare($query);
    $statement->bindValue(':alias', $alias);
    $statement->execute();
    $statement->closeCursor();
}

function delete_role($alias) {
    $db = Database::getDB();
    $query = 'delete from roles
        where Alias = :alias';
    $statement = $db->prepare($query);
    $statement->bindValue(':alias', $alias);
    $statement->execute();
    $statement->closeCursor();
}

function update_role($alias, $role) {
    $db = Database::getDB();
    $query = 'update roles
        set Role = :role
        where Alias = :alias';
    $statement = $db->prepare($query);
    $statement->bindValue(':role', $role);
    $statement->bindValue(':alias', $alias);
    $statement->execute();
    $statement->closeCursor();
}

function update_user_info($alias, $fname, $lname, $email, $password) {
    $db = Database::getDB();
    $query = 'update registration set FirstName = :fname, LastName = :lname, Email = :email, Password = :password where Alias = :alias';
    $statement = $db->prepare($query);
    $statement->bindValue(':alias', $alias);
    $statement->bindValue(':fname', $fname);
    $statement->bindValue(':lname', $lname);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $statement->closeCursor();
}

function insert_product($name, $description, $price) {
    $db = Database::getDB();
    $query = 'insert into products (Name, Description, Price)
                    VALUES
                    (:name, :description, :price)';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':price', $price);
    $statement->execute();
    $statement->closeCursor();
}

function get_product_info($productID) {
    $db = Database::getDB();
    $query = 'Select * from products WHERE ProductID = :productID';
    $statement = $db->prepare($query);
    $statement->bindValue(':productID', $productID);
    $statement->execute();
    $info = $statement->fetch();
    $statement->closeCursor();
    return $info;
}

function update_product_picture($productID, $image) {
    $db = Database::getDB();
    $query = 'update products
        set Image = :image,
        where ProductID = :productID';
    $statement = $db->prepare($query);
    $statement->bindValue(':image', $image);
    $statement->execute();
    $statement->closeCursor();
}

function update_product_info($productID, $name, $description, $price) {
    $db = Database::getDB();
    $query = 'update products set Name = :name, Description = :description, Price = :price where ProductID = :productID';
    $statement = $db->prepare($query);
    $statement->bindValue(':productID', $productID);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':price', $price);
    $statement->execute();
    $statement->closeCursor();
}

function delete_product($productID) {
    $db = Database::getDB();
    $query = 'delete from products
        where ProductID = :productID';
    $statement = $db->prepare($query);
    $statement->bindValue(':productID', $productID);
    $statement->execute();
    $statement->closeCursor();
}

function select_top_5_products() {
    $db = Database::getDB();
    $query = 'SELECT * from products order by Price desc LIMIT 5';
    $statement = $db->prepare($query);
    $statement->execute();
    $topFive = $statement->fetchAll();
    $statement->closeCursor();
    return $topFive;
}

function insert_order($orderID, $productID, $quantity, $timePlaced, $alias, $price) {
    $db = Database::getDB();
    $query = 'insert into orders (OrderID, ProductID, Quantity, TimePlaced, Alias, Price)
                    VALUES
                    (:orderID, :productID, :quantity, :time, :alias, :price)';
    $statement = $db->prepare($query);
    $statement->bindValue(':orderID', $orderID);
    $statement->bindValue(':productID', $productID);
    $statement->bindValue(':quantity', $quantity);
    $statement->bindValue(':time', $timePlaced);
    $statement->bindValue(':alias', $alias);
    $statement->bindValue(':price', $price);
    $statement->execute();
    $statement->closeCursor();
}

function select_order_id() {
    $db = Database::getDB();
    $query = 'SELECT * from orderid';
    $statement = $db->prepare($query);
    $statement->execute();
    $orderID = $statement->fetch();
    $statement->closeCursor();
    return $orderID['OrderID'];
}

function update_order_id($orderID) {
    $db = Database::getDB();
    $query = 'update orderid
        set OrderID = :orderid';
    $statement = $db->prepare($query);
    $statement->bindValue(':orderid', $orderID);
    $statement->execute();
    $statement->closeCursor();
}

function select_all_orders() {
    $db = Database::getDB();
    $query = 'SELECT products.Image, products.Name, orders.Alias, orders.TimePlaced, orders.Quantity, orders.Price from orders join products on orders.ProductID = products.ProductID';
    $statement = $db->prepare($query);
    $statement->execute();
    $orders = $statement->fetchAll();
    $statement->closeCursor();
    return $orders;
}

function select_all_orders_count() {
    $db = Database::getDB();
    $query = 'SELECT Count(*) as Count, products.Image, products.Name, orders.Alias, orders.TimePlaced, orders.Quantity from orders join products on orders.ProductID = products.ProductID';
    $statement = $db->prepare($query);
    $statement->execute();
    $orders = $statement->fetchAll();
    $statement->closeCursor();
    return $orders;
}

function select_all_orders_test($page, $results) {
    $db = Database::getDB();
    $query = 'SELECT products.Image, products.Name, orders.Alias, orders.TimePlaced, orders.Quantity, orders.Price from orders join products on orders.ProductID = products.ProductID LIMIT '
            . $page . ',' . $results;
    $statement = $db->prepare($query);
    //$statement->bindValue(':page', $page);
    //$statement->bindValue(':results', $results);
    $statement->execute();
    $orders = $statement->fetchAll();
    $statement->closeCursor();
    return $orders;
}

function select_inventory() {
    $db = Database::getDB();
    $query = 'SELECT * from inventory';
    $statement = $db->prepare($query);
    $statement->execute();
    $invent = $statement->fetchAll();
    $statement->closeCursor();
    return $invent;
}

function delete_product_inventory($productID) {
    $db = Database::getDB();
    $query = 'delete from inventory
        where ProductID = :productID';
    $statement = $db->prepare($query);
    $statement->bindValue(':productID', $productID);
    $statement->execute();
    $statement->closeCursor();
}

function delete_product_order($productID) {
    $db = Database::getDB();
    $query = 'delete from orders
        where ProductID = :productID';
    $statement = $db->prepare($query);
    $statement->bindValue(':productID', $productID);
    $statement->execute();
    $statement->closeCursor();
}

function select_last_inserted_product() {
    $db = Database::getDB();
    $query = 'SELECT * from products order by ProductID desc LIMIT 1';
    $statement = $db->prepare($query);
    $statement->execute();
    $topFive = $statement->fetch();
    $statement->closeCursor();
    return $topFive[0];
}

function insert_inventory($productID) {
    $db = Database::getDB();
    $query = 'insert into inventory (ProductID) VALUES (:productID)';
    $statement = $db->prepare($query);
    $statement->bindValue(':productID', $productID);
    $statement->execute();
    $statement->closeCursor();
}

function update_inventory($quantity, $productID) {
    $db = Database::getDB();
    $query = 'update inventory
        set TotalQuantity = :quantity where ProductID = :productID';
    $statement = $db->prepare($query);
    $statement->bindValue(':quantity', $quantity);
    $statement->bindValue(':productID', $productID);
    $statement->execute();
    $statement->closeCursor();
}

function select_inventory_with_images($page, $results) {
    $db = Database::getDB();
    $query = 'SELECT products.Image, products.Name, inventory.TotalQuantity, inventory.ProductID from inventory join products on inventory.ProductID = products.ProductID LIMIT ' . $page . ',' . $results;
    $statement = $db->prepare($query);
    $statement->execute();
    $invent = $statement->fetchAll();
    $statement->closeCursor();
    return $invent;
}

function select_inventory_count() {
    $db = Database::getDB();
    $query = 'SELECT Count(*) as Count from inventory';
    $statement = $db->prepare($query);
    $statement->execute();
    $invent = $statement->fetchAll();
    $statement->closeCursor();
    return $invent;
}

function select_all_orders_from_a_user($page, $results, $alias) {
    $db = Database::getDB();
    $query = 'SELECT products.Image, products.Name, orders.Alias, orders.TimePlaced, orders.Quantity, orders.Price from orders join products on orders.ProductID = products.ProductID WHERE orders.Alias = :alias LIMIT '
            . $page . ',' . $results;
    $statement = $db->prepare($query);
    $statement->bindValue(':alias', $alias);
    //$statement->bindValue(':results', $results);
    $statement->execute();
    $orders = $statement->fetchAll();
    $statement->closeCursor();
    return $orders;
}

function select_users_orders_count($alias) {
    $db = Database::getDB();
    $query = 'SELECT Count(*) as Count, products.Image, products.Name, orders.Alias, orders.TimePlaced, orders.Quantity from orders join products on orders.ProductID = products.ProductID WHERE orders.Alias = :alias';
    $statement = $db->prepare($query);
    $statement->bindValue(':alias', $alias);
    $statement->execute();
    $orders = $statement->fetchAll();
    $statement->closeCursor();
    return $orders;
}

