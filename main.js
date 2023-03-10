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
        let response =fetch(login, {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify(tmp),
            
          }).then (res =>  {
            if(res.ok) { 
                console.log("good");
            } else { 
                console.log("bad");
            }
        
          }).catch(error => console.log("Network error"));
          



    
        // api stuff
    });

});
//dark mode