let testVar = "thisisatest";x

baseurl = "http://cop4332.xyz";
login = baseurl + "/API/Login.php";
signup = baseurl + "/API/Signup.php"

function setFormMessage(formElement, type, message) {
    const messageElement = formElement.querySelector(".form__message");

    messageElement.textContent = message;
    messageElement.classList.remove("form__message--success", "form__message--error");
    messageElement.classList.add(`form__message--${type}`);
}

function setInputError(inputElement, message) {
    inputElement.classList.add("form__input--error");
    inputElement.parentElement.querySelector(".form__input-error-message").textContent = message;
}

function clearInputError(inputElement) {
    inputElement.classList.remove("form__input--error");
    inputElement.parentElement.querySelector(".form__input-error-message").textContent = "";
}


document.addEventListener("DOMContentLoaded", () => { //displays the login or the signup form
    const loginForm = document.querySelector("#login");
    const createAccountForm = document.querySelector("#createAccount");

    document.querySelector("#linkCreateAccount").addEventListener("click", e => {
        e.preventDefault();
        loginForm.classList.add("form--hidden");
        createAccountForm.classList.remove("form--hidden");
    });

    document.querySelector("#linkLogin").addEventListener("click", e => {
        e.preventDefault();
        loginForm.classList.remove("form--hidden");
        createAccountForm.classList.add("form--hidden");
    });

    loginForm.addEventListener("submit", async e => { 
        let tmp = {
             User_Name : document.getElementById("username").value,
             Password : document.getElementById("password").value
        };
        e.preventDefault();
            let request = new XMLHttpRequest();
            if (!request.open("POST", login))
            {
                baseurl = "http://24.199.121.145";
                login = baseurl + "/API/Login.php";
                request.open("POST", login);
            }
            console.log(tmp);
        
            try {
                request.onload = function () {
                    console.log("Data has been recieved");
                    
                    let response = JSON.parse(request.responseText);
                    console.log(response);
        
                    if (response.error) {
                        //console.log("error");
                        setFormMessage(loginForm, "error", response.error);
                        return;
                    }
        
                    // successful
                    else {
                        const User_Name = response.User_Name;
                        console.log(User_Name);
                        const userId = response.User_Id;
                        localStorage.setItem("userId", userId);
                        console.log(userId);
                        window.location.href = "contactPage.html";






                    }

                };
        
                console.log("Sending a request");
        
                if (tmp instanceof FormData) request.send(tmp);
                else request.send(JSON.stringify(tmp));
            } catch (err) {
                console.log("test");
            }
        // api stuff

    });
    createAccountForm.addEventListener("submit", async e => { 
        e.preventDefault();
         signupUsername = document.getElementById("signupUsername").value;
         signUpPassword = document.getElementById("signupPassword").value;
         confirmPassword = document.getElementById("confirmPassword").value;
         if (signUpPassword != confirmPassword)
         {
                alert("passwords dont match");
         }
        if (signUpPassword === confirmPassword)
        
        {
            let tmp = {
                User_Name : document.getElementById("signupUsername").value,
                Password : document.getElementById("signupPassword").value
           };
            let request = new XMLHttpRequest();
            if (!request.open("POST", signup))
            {
                baseurl = "http://24.199.121.145";
                signup = baseurl + "/API/Signup.php";
                request.open("POST", signup);
            }
            console.log(tmp);
        
            try {
                request.onload = function () {
                    console.log("Data has been recieved");
                    
                    let response = JSON.parse(request.responseText);
                    console.log(response);
        
                    if (response.error) {
                        //console.log("not signed up");
                        setFormMessage(createAccountForm, "error", response.error);
                        return;
                    }
        
                    // successful
                    console.log("signed up");

                    
                };
        
                console.log("Sending a request");
        
                if (tmp instanceof FormData) request.send(tmp);
                else request.send(JSON.stringify(tmp));
            } catch (err) {
                console.log("there was an error");
            }
        }
    });
});
//dark mode



