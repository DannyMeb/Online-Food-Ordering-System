// **************************************************
// *      Author: Daniel Mebrahtom                  *
// *       ID No: M80007953                         *
// *     College: CIT, Network Security             *
// *    Special Thanks to Dr.Mohammad Kuhail        *
//***************************************************


//Initializaion finctions called up on load page
function initial(){
    admin_menu();
    read_theme();
   
}

//Function to hide product from menu, and only called from the Admin side.
function hide_task(item){
    var item_id=$(item).attr('data-item-id'); //reading the product ID
    var marked=$(item).is(':checked');//Check if the checkbox is checked or not
    
    if(marked){var status="Not Available";}//When checked, Hide the product
    else{var status="Available";}
    
     $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "hide_item","item_id":item_id,"status":status}, 
        success: function (data) {
            if(data["success"]){ //if the request succeeds
                admin_menu();//recall the function so that the changes will reflect right away
            }}
    });
}


//Read the current user's theme
//Called from both sides
function read_theme(){
    $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "get_theme"}, 
        success: function (data) {
            if(data["theme"]==="dark"){ //read the theme from the cookie
                $("body").css("background-color", "black"); //make the background color black
                $("table").addClass("table-dark");//we should make it a dark table                
            }
            else{
                $("body").css("background-color", "white"); //make the background color white
                $("table").removeClass("table-dark");//we should make it a dark table                
            }
        }
    });    
}

//Function for showing the available products in the database. 
//Called from the customer side only
//I use "usertype" to diffrentiate customer menu from admin menu 
function get_menu() {
    $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "get_all_menu", usertype: "customer"},//
        success: function (data) {
            make_items_html(data);
            },
        error: function(xhr, status, error) {//Incase anything goes wrong, display the error
              window.alert(status);
   }    
    });
    //window.alert("price");
    return false; //return false so that it doesn't submit the form and refresh it
}

//Function for showing the all the products (Available and Not available) in the database. 
//Called from the Admin side only
//I use "usertype" to diffrentiate customer menu from admin menu 
function admin_menu() {
    $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "get_all_menu", usertype: "staff"},
        success: function (data) {
            make_items_html(data);
            },
        error: function(xhr, status, error) {
              window.alert(status);
   }    
    });
    return false; //return false so that it doesn't submit the form and refresh it
}



//Function to fetch menu based on thier category
//Called from both sides
function get_category(item) {
     var category=$(item).attr('id');
    $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "get_category", category:category},
        success: function (data) {
            make_items_html(data);
            },
        error: function(xhr, status, error) {//Incase anything goes wrong, display the error
              window.alert(status);
   }    
    });
    return false; //return false so that it doesn't submit the form and refresh it
}

//Function to search product in the database by name
//Called from customer side
function get_item() {
     var item_name = $("#search").val();//Get product name
    $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "search", item:item_name},
        success: function (data) {
            make_search_html(data);
            }
    });
    return false; //return false so that it doesn't submit the form and refresh it
}

//Fucntion to seach for products 
//Called from the admin side
//A bit powerfull than that of called from the customer side
function admin_search() {
     var item_name = $("#search").val();
    $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "search", item:item_name},
        success: function (data) {
            make_items_html(data);
            }       
    });
    return false; //return false so that it doesn't submit the form and refresh it
}

//Function for placing an order into the databse
function order(item){
     var item_name=$(item).attr('item_name');//getting product name
     $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "order", item_name:item_name},
        success: function (data) {
                  window.alert("Thank you! Your Order has been recieved");//Confirmation order placed 
            },
        error: function(xhr, status, error) {//Incase anything goes wrong, display the error
              window.alert(status);
   }    
    });
    return false; //return false so that it doesn't submit the form and refresh it
}

//Function to search an order from DB
function order_search() {
     var order_id = $("#search").val();//Get order number name
     //alert(item_name);
    $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "order_search", order_id:order_id},
        success: function (data) {
            make_items_html(data);
            }
    });
    return false; //return false so that it doesn't submit the form and refresh it
}


//Function to Set theme light
function set_theme_light() {
    $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "change_theme", "theme": "light"}, //we are sending to the server the type of request, the theme value which is light
        success: function (data) {

        }
    });
    $("body").css("background-color", "white"); //make the background color white
    $("table").removeClass("table-dark");//we should make it a dark table
}

//Function to Set theme Dark
function set_theme_dark() {
    $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "change_theme", "theme": "dark"}, //we are sending to the server the type of request, the theme value which is dark
        success: function (data) {

        }
    });
    $("body").css("background-color", "black"); //make the background color black
    $("food-menu").css("background-color", "black"); //make the background color black
    $("table").addClass("table-dark");//we should make it a dark table
}

//Function to read orders made by a specfic user
//Called by the customer side
//Make the use of sesions in the server side
function get_orders(){
    $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "get_orders"},
        success: function (data) {
             make_items_html(data);
            },
        error: function(xhr, status, error) {//Incase anything goes wrong, display the error
   }    
    });
    
    return false; //return false so that it doesn't submit the form and refresh it
}

//Fucntion to fetch pending orders 
//Called from the admin side
function get_pending_orders(){
    $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "get_pending_orders"},
        success: function (data) {
             make_items_html(data);
            },
        error: function(xhr, status, error) {//Incase anything goes wrong, display the error
              window.alert(status);
   }    
    });
    return false; //return false so that it doesn't submit the form and refresh it
}

//Fucntion to cancel orders 
//Called from the customer side only
function cancel_orders(item){
    var order_id=$(item).attr('order_ID');//get order ID
    var order_name=$(item).attr('order_name'); //for confirmation
    alert("You are trying to delete:"+order_name);
    $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "cancel_orders", order_id: order_id},
        success: function (data) {
            if(data["success"]){
            window.location.reload();
            }}
    });
    
    return false; //return false so that it doesn't submit the form and refresh it
}

//Fucntion to update orders status 
//Called from the Admin side only
function update_status(order){
     var order_ID=$(order).attr('order_ID');//get order Id
     var status= document.getElementById("status").value;//get new status to be updated
      alert("You are trying to Change Order Status"); //Notifying the update
    $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "update_status", updated_status: status, order_ID:order_ID},
        success: function (data) {
            if(data["success"]){
             alert("Hey Admin, Status updated successfully!");
            }}
    });
    
    return false; //return false so that it doesn't submit the form and refresh it
}


//Fucntion to add new products into the menulist 
//Called from the Admin side only
function add_to_menu(){
    $("#task-success").hide(); //feedback for add product must be hidden
    var product_name=$("#new_product_name").val(); //we are reading the product name
    var product_description=$("#new_product_name_description").val();//we are reading the new product description
    var product_price=$("#new_product_price").val();//we are reading the new product price
    var product_category=$("#product_category").val();//we are reading the new product category
    
    $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "add_to_menu", "product_name":product_name, "product_description":product_description,"product_price":product_price, "product_category":product_category}, 
        success: function (data) {
            if(data["success"]){ //if the request succeeds
                admin_menu();
                $("#task-success").show();//we show it here
            }}
    });     
    
}

//Function to logout from the system
//Called from both sides
function logout(){
      $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "logout"}, 
        success: function (data) {
            if(data["success"]){ //if the request succeeds
                 window.location.href ="index.html"; //redirects the page to index.html
            }}
    });     
       
    
}

//Function to make dynamic HTML for all functions except "get item"  using the tempateing engine
function make_items_html(data) {
    var html = create_html("task-template", data);
    $("#tasks").html(html); //show the data in the div with the ID: tasks
}

//Function to make dynamic HTML "get item" fucntion using the tempateing engine
function make_search_html(data) {
    var html = create_html("task-template", data);
    $("#test").html(html); //show the data in the div with the ID: test
}


