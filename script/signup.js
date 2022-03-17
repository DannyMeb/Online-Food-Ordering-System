// **************************************************
// *      Author: Daniel Mebrahtom                  *
// *       ID No: M80007953                         *
// *     College: CIT, Network Security             *
// *    Special Thanks to Dr.Mohammad Kuhail        *
//***************************************************


//Function to allow new users to register
//Called from the customer side
function signup() {
    var name = $("#username").val();
    var password = $("#password").val();
    var phone = $("#phone").val();
    var address = $("#address").val();
   
    $.ajax({
        method: "POST",
        url: "server/back_end.php",
        dataType: "json",
        data: {request_type: "signup", "username": name, "password":password, "phone":phone, "address":address}, //we are sending to the server the type of request, and the username to be authenticated
        success: function (data) {
              if(!data["success"]){//if the register fails
                $("#login-feedback").text("Sorry. Wrong username. Try again");//show feedback
            }
            else{ //if the registration succeeds
                alert("Registarion sucesss! Login Now!");
                window.location.href ="index.html"; //redirects the page to tasks.html
            }
        }
    });

}
