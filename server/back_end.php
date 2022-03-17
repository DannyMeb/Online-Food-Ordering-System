<?php
// **************************************************
// *      Author: Daniel Mebrahtom                  *
// *       ID No: M80007953                         *
// *     College: CIT, Network Security             *
// *    Special Thanks to Dr.Mohammad Kuhail        *
//***************************************************


require_once 'connection.php'; //include the connection file
session_start(); //start session to store username and userId
$user_id=$_SESSION["user_id"];


//simulate all possible request types
//1*************************************
//$_POST["request_type"]="get_all_menu";
//$_POST["usertype"]="customer";
//*************************************

//2*************************************
//$_POST["request_type"]="get_category";
//$_POST["category"]=1;
//************************************** 

//3*************************************
//$_POST["request_type"]="search";
//$_POST["item"]="Burger";
//**************************************

//4*************************************
//$_POST["request_type"]="login";
//$_POST["user_type"]="customer";
//$_POST["username"]="Daniel";
//$_POST["password"]="1235";
//*************************************

//5*************************************
//$_POST["request_type"]="signup";
//$_POST["username"]="Haben";
//$_POST["password"]="123";
//$_POST["phone"]="0545999716";
//$_POST["address"]="Diera, Abu Dhabi, UAE";
//*************************************
//
//6*************************************
//$_POST["request_type"]="order";
//$_POST["item_id"]=1;
//**************************************

//7*************************************
//$_POST["request_type"]="get_orders";
////$_SESSION["user_id"]=22;
//*************************************

//8****************************************
//$_POST["request_type"]="get_pending_orders";
//******************************************

//9*************************************
//$_POST["request_type"]="cancel_orders";
//$_POST["order_id"]=41;
//*************************************

//10*************************************
//$_POST["request_type"]="update_status";
//$_POST["order_ID"]=53;
//$_POST["updated_status"]=3;
//***************************************

//11*************************************
//$_POST["request_type"]="add_to_menu";
//$_POST["product_name"]="Veg Burger";
//$_POST["product_description"]="Made from fresh veg";
//$_POST["product_price"]=12;
//$_POST["product_category"]=2;
//****************************************

//12*************************************
//$_POST["request_type"]="hide_item";
//$_POST["item_id"]=5;
//$_POST["status"]="Not Available";
//*************************************

//13*************************************
//$_POST["request_type"]="order_search";
//$_POST["order_id"]=61;

//*************************************


$request_type = $_POST["request_type"]; //we are reading the request type from the client side
$result = array();
switch ($request_type) { //based on the request we will do something
    case "get_all_menu":
        $result = get_all_menu($connection, $_POST["usertype"] );
        break; 
    case "get_category":
        $result = get_category($connection, $_POST["category"]);
        break; 
     case "search":
        $result = search($connection, $_POST["item"]);
        break; 
    case "login":
        $result = login($connection, $_POST["username"], $_POST["password"],$_POST["user_type"] );
        break; 
    case "logout":
        $result = logout();
        break;
     case "signup":
        $result = signup($connection, $_POST["username"], $_POST["password"], $_POST["phone"], $_POST["address"]);
        break; 
     case "change_theme":
        $result = change_theme($_POST["theme"]);
     case "get_theme":
        $result = get_theme();
        break;
     case "order":
        $result = order($connection, $_POST["item_name"]);
        break; 
     case "get_orders":
        $result = get_orders($connection, $user_id);
        break;
     case "order_search":
        $result = order_search($connection, $_POST["order_id"]);
        break;
    case "cancel_orders":
        $result = cancel_orders($connection, $_POST["order_id"]);
        break;
     case "get_pending_orders":
        $result = get_pending_orders($connection);
        break;
     case "update_status":
        $result = update_status($connection, $_POST["updated_status"], $_POST["order_ID"]);
    case "hide_item":
        $result = hide_item($connection, $_POST["item_id"], $_POST["status"]);
        break;
     case "add_to_menu":
        $result = add_to_menu($connection,$_POST["product_name"], $_POST["product_description"],$_POST["product_price"],$_POST["product_category"]); 
}
print_r($result);

//Function that allows admin to search by order id
function order_search($connection, $order_id) {
   //I fetch the data from three tables using INNER JOIN
   $query="SELECT customer.Name AS customer, menulist.Name, menulist.description, menulist.price, orders.ID, status.Name AS status"
           . " FROM (((menulist INNER JOIN orders ON menulist.ID=orders.Item_ID) INNER JOIN customer ON customer.ID=orders.customer_ID)"
           . "INNER JOIN status ON status.ID=orders.status_ID) WHERE orders.ID='$order_id' ORDER BY ID DESC";
   $sql_result = mysqli_query($connection, $query); //we send the query to the database and receive in the result set
   $result= array();
    while ($row = mysqli_fetch_array($sql_result)) { //loop through the result set, and extrac it row by row
       
        $order_ID=$row["ID"];
        $item_name=$row["Name"];
        $price = $row["price"];
        $description = $row["description"]; 
        $status=$row["status"];
        $customer=$row["customer"];
    
        $menu_item = array("ID"=>$order_ID,"item_name"=>$item_name, "Customer"=>$customer, "price" => $price, "description" => $description, "status" => $status ); //we build data for each task
        $result[] = ($menu_item); //data is added to the result
    }
    return json_encode($result); //we send the data in JSON format
}


//Function to hide a product from the menu so that it wont refelect on the customer view
//But the admin can still view it
//Called from the Admin side only
function hide_item($connection, $item_id, $status) {
    $result = array("success" => false);
    $query = "UPDATE menulist SET status='$status' WHERE ID='$item_id';";
    $sql_result = mysqli_query($connection, $query); //we send the query to the database and receive in the result set
    if (!$sql_result) {
        return json_encode($result);
    }

    $result["success"] = true;
    return json_encode($result);
}

//Function to logout a user and kill the session stored for that user
function logout() {
// If it's desired to kill the session, also delete the session cookie.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
        );
    }
// Finally, destroy the session.
    session_destroy();
    return json_encode(array("success" => true));
}


//Function to change theme based on the user prederences
function change_theme($theme) {
    setcookie('theme', $theme, time() + 60 * 60 * 24 * 7, '/'); //we store a cookie about the theme that the user has chosen
    return json_encode(array("success" => true)); //we tell the user that the cookie was successfully stored
}

//Function to read theme up on page load
function get_theme() {
    $theme="light"; //the default theme is light in case the cookie was not stored yet.
    if (isset($_COOKIE['theme'])) { //if the cookie for theme exists
        $theme = $_COOKIE['theme']; //we read it
    }
    
    return json_encode(array("theme"=>$theme)); //we return the value to the user
}

//Function to fetch products from the DB
function get_all_menu($connection,$usertype) {
    
    $query = "SELECT * FROM menulist";

    $sql_result = mysqli_query($connection, $query); //we send the query to the database and receive in the result set
    $result=array();
    while ($row = mysqli_fetch_array($sql_result)) { //loop through the result set, and extrac it row by row
        $id=$row["ID"];
        $item_name = $row["Name"]; 
        $item_description = $row["description"];
        $price = $row["price"]; 
        $status=$row["status"]; 
        $cheked_text='';//To use it with "checkbox" in the admin side
        if($status=="Not Available"){$cheked_text='checked';}//checked if a product status is "Not Availabe"
        
        if($usertype=="staff"){//If the usertype is staff, then every product will be appended to the "menu_item", and dispayed in the admin side
            $menu_item = array("ID"=>$id,"item_checked" => $cheked_text, "item_name" => $item_name, "item_description" => $item_description, "price" => $price, "status"=>$status); //we build data for each task
            $result[] = ($menu_item);
        }
        
        if($usertype=="customer" and $status=="Available"){//If the usertype is customer,then show those products only with "Available" status
                $menu_item = array("ID"=>$id, "item_checked" => $cheked_text,"item_name" => $item_name, "item_description" => $item_description, "price" => $price,  "status"=>$status); //we build data for each task
                $result[] = ($menu_item);
                }
      
         
    }
    return json_encode($result); //we send the data in JSON format
}

//Function to fetch products based on their categories
function get_category($connection, $category) {

    $query = "SELECT * FROM menulist WHERE category='$category'";

    $sql_result = mysqli_query($connection, $query); //we send the query to the database and receive in the result set

    if (!$sql_result){ //if there is an issue, e.g. the query is wrong, or the database/server is down
    die("Database access failed: " . mysqli_error($connection)); }//we exist the page, and show an error message

    $result = array();
    while ($row = mysqli_fetch_array($sql_result)) { //loop through the result set, and extrac it row by row
        $id=$row["ID"];
        $item_name = $row["Name"]; 
        $item_description = $row["description"]; 
        $price = $row["price"]; 
        $category = $row["category"]; 
        $status=$row["status"]; 
        
        if($status=="Available"){
        $menu_item = array("ID"=>$id,"item_name" => $item_name, "item_description" => $item_description, "price" => $price, "category" => $category, "status"=>$status); //we build data for each task
        $result[] = ($menu_item); //data is added to the result
    }
    }
    return json_encode($result); //we send the data in JSON format
}

//Function to fetch product by name
function search($connection, $item) {
    $result = array(); 
    if (isset($item) && $item!= "") {
            $query = "SELECT * FROM menulist WHERE Name LIKE '%$item%'";

            $sql_result = mysqli_query($connection, $query); //we send the query to the database and receive in the result set

            if (!$sql_result){ //if there is an issue, e.g. the query is wrong, or the database/server is down
            die("Database access failed: " . mysqli_error($connection)); }//we exist the page, and show an error message

           
            while ($row = mysqli_fetch_array($sql_result)) { //loop through the result set, and extrac it row by row
                $id=$row["ID"];
                $item_name = $row["Name"]; 
                $item_description = $row["description"]; 
                $price = $row["price"]; 
                $status=$row["status"]; 
                $menu_item = array("ID"=>$id,"item_name" => $item_name, "item_description" => $item_description, "price" => $price, "status" => $status); //we build data for each task
                $result[] = ($menu_item); //data is added to the result
            }
            return json_encode($result); //we send the data in JSON format
        }
        else{
            return json_encode($result);
        }
}

//Function to allow users to login
//And create session for users accordinglu
function login($connection,$username, $password,$usertype){
     $query = "SELECT * FROM customer WHERE Name='$username' AND password='$password'"; 
    if($usertype=='staff'){ $query = "SELECT * FROM administrator WHERE Name='$username' AND password='$password'";}
     $sql_result = mysqli_query($connection, $query); //we send the query to the database and receive in the result set
     if(!$sql_result || mysqli_num_rows($sql_result)!=1){ //of there is a problem with the sql result or the number of records is not 1
         return json_encode(array("success"=>false)); //we return failure
     }
     $row = mysqli_fetch_array($sql_result);
     $user_id=$row["ID"];
     $_SESSION["username"]=$username; //we store the username in the session
     $_SESSION["user_id"]=$user_id; //we store the username in the session
     return json_encode(array("success"=>true));  //we return success
}

//Function to allow new customer to register into the system
function signup($connection, $username, $password, $phone, $address){
    $result=array("success"=>false);
    $query = "INSERT INTO customer(Name,Phone,Address,password) VALUES ('$username','$phone','$address','$password')";
    $sql_result = mysqli_query($connection, $query); //we send the query to the database and receive in the result set
    if($sql_result){
        $result=array("success"=>true);
        return json_encode($result);
    }
    return json_encode($result);
}

//Function to place an order into the DB using product ID and current users Id(From the session)
function order($connection, $item_id){
    $user_id=$_SESSION["user_id"];
    $query = "INSERT INTO orders(orderedDate, Item_ID, status_ID, customer_ID) VALUES (curdate(),'$item_id',1,'$user_id')";
    $sql_result = mysqli_query($connection, $query); //we send the query to the database and receive in the result set
    if(!$sql_result){
        return json_encode(array("success"=>false));
    }
    return json_encode(array("success"=>true));
}

//Function to show the orders made by a current user
function get_orders($connection, $user_id) {
   //I fetch the data from three tables using INNER JOIN
   $query= "SELECT menulist.Name, menulist.description, menulist.price, orders.ID, status.Name AS status FROM ((menulist INNER JOIN orders ON menulist.ID=orders.Item_ID) INNER JOIN status ON status.ID=orders.status_ID) WHERE orders.customer_ID='$user_id' ORDER BY orders.ID DESC";
   $sql_result = mysqli_query($connection, $query); //we send the query to the database and receive in the result set
   $result= array();
    while ($row = mysqli_fetch_array($sql_result)) { //loop through the result set, and extrac it row by row
       
        $order_ID=$row["ID"];
        $item_name=$row["Name"];
        $price = $row["price"];
        $description = $row["description"]; 
        $status=$row["status"];
    
        $menu_item = array("ID"=>$order_ID,"item_name"=>$item_name, "price" => $price, "description" => $description, "status" => $status ); //we build data for each task
        $result[] = ($menu_item); //data is added to the result
    }
    return json_encode($result); //we send the data in JSON format
}

//Function to allow current user to cancel orders of the current user
function cancel_orders($connection, $order_id){
    $result=array("success"=>false);
    $delete_order_id=$order_id;
    $query = "DELETE FROM orders WHERE ID='$delete_order_id';";
    $sql_result = mysqli_query($connection, $query); //we send the query to the database and receive in the result set
    if(!$sql_result){
        return json_encode($result);
    }
    else{
    $result["success"]=true;
    return json_encode($result);}
}

//Function to allow admin to see current pending orders
//Ordered DESC by thier ID (Latest order first)
function get_pending_orders($connection) {
     $result=array();
    $query="SELECT customer.Name AS customer, menulist.Name, menulist.description, menulist.price, orders.ID, status.Name AS status "
            . "FROM (((menulist INNER JOIN orders ON menulist.ID=orders.Item_ID)"
            . " INNER JOIN customer ON customer.ID=orders.customer_ID) "
            . "INNER JOIN status ON status.ID=orders.status_ID)ORDER BY ID DESC";
    $sql_result = mysqli_query($connection, $query); //we send the query to the database and receive in the result set
   
    while ($row = mysqli_fetch_array($sql_result)) { //loop through the result set, and extrac it row by row
        $order_ID=$row["ID"];
        $item_name=$row["Name"];
        $price = $row["price"];
        $customer_name = $row["customer"]; 
        $status=$row["status"];
    
        
        $menu_item = array("ID"=>$order_ID,"item_name"=>$item_name, "price" => $price, "Customer" => $customer_name, "status" => $status ); //we build data for each task
        $result[] = ($menu_item); //data is added to the result
    }
    return json_encode($result); //we send the data in JSON format
}

//Function to update the status of an order so that it reflects on the customer side too
function  update_status($connection, $updated_status, $order_ID){
    $result=array("success"=>false);
    $new_status=$updated_status;
    $ID=$order_ID;
    $query = "UPDATE orders SET status_ID = '$new_status' WHERE ID = '$ID'";
    $sql_result = mysqli_query($connection, $query); //we send the query to the database and receive in the result set
    if(!$sql_result){
        return json_encode($result);
    }
    else{
    $result["success"]=true;
    return json_encode($result);}
}


//Function to add new product into the menulist
function add_to_menu($connection,$product_name, $product_description,$product_price,$product_category) {
    $result = array("success" => false);
    $query = "INSERT INTO menulist (Name, description, price, category, status) VALUES ('$product_name', '$product_description', '$product_price', '$product_category', 'Available')";
   
    $sql_result = mysqli_query($connection, $query); //we send the query to the database and receive in the result set
    if (!$sql_result) {
        return json_encode($result);
    }

    $result["success"] = true;
    return json_encode($result);
}



//*************************** THE END OF THE PROJECT*********************************