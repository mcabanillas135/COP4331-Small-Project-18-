const firstName = document.getElementById('firstName');
const lastName = document.getElementById('lastName');
const phoneNumber = document.getElementById('phoneNumber');
const email = document.getElementById('email');
const addContactButton = document.getElementById('addContactButton');
const contactTable = document.getElementById('contactList');
const tableRows = contactTable.getElementsByTagName('tr');

const contactDetailsPage = document.getElementById('contactDetails');
const detailedFirstName = document.getElementById('detailedFirstName');
const detailedLastName = document.getElementById('detailedLastName');
const detailedEmail = document.getElementById('detailedEmail');
const detailedPhone = document.getElementById('detailedPhone');
const street = document.getElementById('street');
const city = document.getElementById('city');
const state = document.getElementById('state');
const zip = document.getElementById('zip');
const birth = document.getElementById('birth');
const added = document.getElementById('added');
const edited = document.getElementById('edited');
const editButton = document.getElementById('editButton');
const confirmButton = document.getElementById('confirmButton');
const allDetailedInfo = document.getElementsByClassName("detailedInfo");

for(let i=0; i < allDetailedInfo.length; i++) {
	allDetailedInfo[i].disabled = true;
}

// adds the highlight function (adds "selected" class to highlighted row)
for(let i=1; i < tableRows.length; i++) {
	const row = tableRows[i];
	row.addEventListener('click', selectRow);
}

function selectRow() {
	if(this.classList.contains('selected')){
		this.classList.remove('selected');
		contactDetailsPage.style.display = 'none';
		return;
	}
	// remove previously selected row
	for(let i=0; i < tableRows.length; i++) {
		tableRows[i].classList.remove('selected');
	}
	this.classList.add('selected');
	
	fillDetailed(this);	
}

function fillDetailed(selectedRow) {
	// api call that fills information for detailed tableRows
	
	contactDetailsPage.style.display = 'block';
	
	const cells = selectedRow.querySelectorAll('td');
	const fName = cells[0].textContent;
	const lName = cells[1].textContent;
	const phone = cells[2].textContent;
	const email = cells[3].textContent;
	const STREET = "";
	const CITY = "";
	const STATE = "";
	const ZIP = "";
	const BIRTH = "";
	const ADDED = "";
	const EDITED = "";
	
	detailedFirstName.value = fName;
	detailedLastName.value = lName;
	detailedPhone.value = phone;
	detailedEmail.value = email;
	street.value = STREET;
	city.value = CITY;
	state.value = STATE;
	zip.value = ZIP;
	birth.value = BIRTH;
	added.value = ADDED;
	edited.value = EDITED;
}


function deleteSelected(){
	for(let i=0; i<tableRows.length; i++){
		if(tableRows[i].classList.contains('selected')) {
			contactTable.deleteRow(i);
		}
	}
	contactDetailsPage.style.display = 'none';
}
	
function setEditable() {
	
}
	
/* legacy code (add button is handled differently now)

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
*/

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
  