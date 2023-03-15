baseurl = "http://cop4332.xyz";
login = baseurl + "/API/Login.php";
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
                        console.log("error");
                        return;
                    }
        
                    // successful
                    console.log("successful");
                    
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
        const signupUsername = document.getElementById(signupUsername);
        const signUpPassword = document.getElementById(signUpPassword);
        const confirmPassword = document.getElementById(confirmPassword);
        console.log(signupUsername);
        console.log(signUpPassword);
        console.log(confirmPassword);

    });
});
//dark mode



