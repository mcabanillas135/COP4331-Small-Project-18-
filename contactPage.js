const firstName = document.getElementById('firstName');
const lastName = document.getElementById('lastName');
const phoneNumber = document.getElementById('phoneNumber');
const email = document.getElementById('email');
const addContactButton = document.getElementById('addContactButton');
const contactTable = document.getElementById('contactList');

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