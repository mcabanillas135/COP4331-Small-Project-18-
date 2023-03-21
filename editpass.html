let testVar = "thisisatest";

baseurl = "http://cop4332.xyz";
editPass = baseurl + "/API/EditPass.php";

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
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }
  
  const userId = getCookie("userId");

document.addEventListener("DOMContentLoaded", () => { //displays the login or the signup form
    const loginForm = document.querySelector("#Username");



    loginForm.addEventListener("submit", async e => { 
        e.preventDefault();
        const newPass = document.getElementById("newPass").value;
        const username = document.getElementById("username").value;
        const confirmPass = document.getElementById("confirmPass").value;
        const password = document.getElementById("Password").value;
        console.log(password);
        if(newPass != confirmPass)
        {
            setFormMessage(loginForm, "error", "New Password and Confirm New Password dont match");
        }

        if (newPass === confirmPass)
        {
            let tmp = {
                User_id: userId,
                User_name: username,
                password: newPass
            }
            let request = new XMLHttpRequest();
            if (!request.open("POST", editPass))
            {
                baseurl = "http://24.199.121.145";
                editPass = baseurl + "/API/EditPass.php";
                request.open("POST", editPass);
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
                            window.location.href = "Index.html";
                        }
    
                    };
            
                    console.log("Sending a request");
            
                    if (tmp instanceof FormData) request.send(tmp);
                    else request.send(JSON.stringify(tmp));
                } catch (err) {
                    console.log("test");
                }
            
            }

        

    });
});


