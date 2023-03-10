login = "http://cop4332.xyz/COP4331-Small-Project-18-/API/Login.php";


document.addEventListener("DOMContentLoaded", () => { //displays the login or the signup form
    const loginForm = document.querySelector("#login");
    const createAccountForm = document.querySelector("#createAccount");
    document.querySelector("#linkLogin").addEventListener("click", e => { //removes the hidden form from the login link to the signup page
        e.preventDefault(); //stops the page from just refreshing
        loginForm.classList.remove("form--hidden");
        createAccountForm.classList.add("form--hidden");
    });

    loginForm.addEventListener("submit", async e => { 
        let tmp = {
             User_name : document.getElementById("username").value,
             Password : document.getElementById("password").value
        };
        e.preventDefault();
            let request = new XMLHttpRequest();
            request.open("POST", login, true);
        
            console.log(tmp);
        
            try {
                request.onload = function () {
                    console.log(
                        "[Received Data (" + login + ")]: " + request.responseText
                    );
                    
                    let response = JSON.parse(request.responseText);
                    console.log(response);
        
                    if (response.error) {
                        console.log("[Request Error (" + login + ")]: " + response.error);
                        return;
                    }
        
                    // successful
                    console.log(
                        "[Request Success (" + login + ")]:  " + response.success
                    );
                };
        
                console.log(
                    "[Sending Request (" + login + ")]: " + JSON.stringify(tmp)
                );
        
                if (tmp instanceof FormData) request.send(inData);
                else request.send(JSON.stringify(inData));
            } catch (err) {
                console.log("test");
            }
        
        // api stuff
    });

});
//dark mode