// **************************************************
// *      Author: Daniel Mebrahtom                  *
// *       ID No: M80007953                         *
// *     College: CIT, Network Security             *
// *    Special Thanks to Dr.Mohammad Kuhail        *
//***************************************************

//Funciton that allows customers to login
function customer_login() {
    var name = $("#username").val();//reading the credentials
    var password = $("#password").val();
    
   
    $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "login",user_type: "customer", "username": name, "password":password}, //we are sending to the server the type of request, and the username to be authenticated
        success: function (data) {
            if(!data["success"]){//if the login fails
                $("#login-feedback").text("Sorry. Wrong username. Try again");//show feedback
                $("#username")[0].setCustomValidity("Sorry. Wrong username. Try again");//show feedback
                $("#login-form").addClass("was-validated");//make the form look validated and highlighted
            }
            else{ //if the login succeeds
                window.location.href ="customer_view.html"; //redirects the page to tasks.html
            }
        }
    });

}

//Funciton that allows Admin to login
function admin_login() {
    var name = $("#username").val();
    var password = $("#password").val();
   
    $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "login", user_type: "staff", "username": name, "password":password}, //we are sending to the server the type of request, and the username to be authenticated
        success: function (data) {
            if(!data["success"]){//if the login fails
               
                $("#login-feedback").text("Sorry. Wrong username. Try again");//show feedback
               
            }
            else{ //if the login succeeds
               
                window.location.href ="Staff_view.html"; //redirects the page to tasks.html
            }
        }
    });

}
