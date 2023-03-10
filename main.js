login = "http://cop4332.xyz/COP4331-Small-Project-18-/API/Login.php";

const User_name = document.getElementById("username");
const Password = document.getElementById("password");
document.getElementById("password");

const options = {
    bottom: '64px', // default: '32px'
    right: 'unset', // default: '32px'
    left: '32px', // default: 'unset'
    time: '0.3', // default: '0.3s'
    mixColor: '#fff', // default: '#fff'
    backgroundColor: '#fff',  // default: '#fff'
    buttonColorDark: '#100f2c',  // default: '#100f2c'
    buttonColorLight: '#fff', // default: '#fff'
    saveInCookies: true, // default: true,
    label: '🌓', // default: ''
    autoMatchOsTheme: true // default: true
  }
  
  const darkmode = new Darkmode(options);
  darkmode.showWidget();
function setFormMessage(formElement, type, message) { 
    const messageElement = formElement.querySelector(".form__message"); //gets the message from the form
    messageElement.textContent = message;
    messageElement.classList.remove("form__message--success", "form__message--error"); //stops the msgs from poppin up right away
    messageElement.classList.add(`form__message--${type}`); 
}
function setInputError(inputElement, message) { 
    inputElement.classList.add("form__input--error");
    inputElement.parentElement.querySelector(".form__input-error-message").textContent = message; // go to the input, then go to the class, then select the message and assign to msg
}
function clearInputError(inputElement) { //does what name says
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
    document.querySelector("#linkLogin").addEventListener("click", e => { //removes the hidden form from the login link to the signup page
        e.preventDefault(); //stops the page from just refreshing
        loginForm.classList.remove("form--hidden");
        createAccountForm.classList.add("form--hidden");
    });

    loginForm.addEventListener("submit", async e => { 
        let tmp = {
             User_Name : document.getElementById("username").value,
             Password : document.getElementById("password").value
        };
        console.log(tmp);
        e.preventDefault();
        let response =fetch(login, {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify(tmp),
            
          }).then (res =>  {
            if(res.ok) { 
                // login successful, do something

                alert("Login successful!"); // display an alert
                window.location.href = "dashboard.html"; // redirect to the dashboard
            } else { 
                // login unsuccessful, do something else
                alert("Invalid username or password"); // display an alert
            }
        
          }).catch(error => console.log("Network error"));
          



    
        // api stuff
    });
    document.querySelectorAll(".form__input").forEach(inputElement => { 
        inputElement.addEventListener("blur", e => { // blur means when the input field is not selected
            if (e.target.id === "signupUsername" && e.target.value.length > 0 && e.target.value.length < 10) { // if there is an input and theres less then 10 chars
                setInputError(inputElement, "Username must be at least 10 characters in length");
            }
        });
        inputElement.addEventListener("input", e => {
            clearInputError(inputElement); //clears the errors in the input fields whilst you type inside of it
        });
    });
});
//dark mode
