const firstName = document.getElementById('firstName');
const lastName = document.getElementById('lastName');
const phoneNumber = document.getElementById('phoneNumber');
const email = document.getElementById('email');
const addContactButton = document.getElementById('addContactButton');
const contactTable = document.getElementById('contactList');
//adds the contact button
addContactButton.addEventListener("click", e => {
    e.preventDefault();
    const newRow = contactTable.insertRow();

    const firstNameCell = newRow.insertCell();
    firstNameCell.textContent = firstName.value;

    const lastNameCell = newRow.insertCell();
    lastNameCell.textContent = lastName.value;

    const phoneNumberCell = newRow.insertCell();
    phoneNumberCell.textContent = phoneNumber.value;

    const emailCell = newRow.insertCell();
    emailCell.textContent = email.value;


}); 

const settingsBtn = document.getElementById('settings-btn');
const editUsernameBtn = document.querySelector('#Edit-User');
const editPasswordBtn = document.querySelector('#Edit-pass');



//added settings button

document.getElementById("settings-btn").addEventListener("click", e => {
  e.preventDefault();
  var dropdown = document.getElementById("settings-dropdown");
  if (dropdown.style.display === "none") {
    dropdown.style.display = "block";
  } else {
    dropdown.style.display = "none";
  }
});

// When the slider value changes, update the text font size
document.getElementById("size-slider").addEventListener("change", function() {
  var size = this.value;
  document.getElementById("container").style.fontSize = size + "px";
});

editUsernameBtn.addEventListener('click', e => {
  e.preventDefault();

  const newUsername = prompt('Enter your new username:');
  if (newUsername) {
    document.querySelector('#username').value = newUsername;
  }
});

editPasswordBtn.addEventListener('click', e => {
  e.preventDefault();

  const newPassword = prompt('Enter your new password:');
  if (newPassword) {
    document.querySelector('#password').value = newPassword;
  }
});
  