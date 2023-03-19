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
const created = document.getElementById('created');
const edited = document.getElementById('edited');
const editButton = document.getElementById('editButton');
const confirmButton = document.getElementById('confirmButton');
const allDetailedInfo = document.getElementsByClassName("detailedInfo");

const addContactPage = document.getElementById('addContactDetails');
const addFirstName = document.getElementById('addFirstName');
const addLastName = document.getElementById('addLastName');
const addEmail = document.getElementById('addEmail');
const addPhone = document.getElementById('addPhone');
const addStreet = document.getElementById('addStreet');
const addCity = document.getElementById('addCity');
const addState = document.getElementById('addState');
const addZip = document.getElementById('addZip');
const addBirth = document.getElementById('addBirth');
const addCreated = document.getElementById('addCreated');
const addEdited = document.getElementById('addEdited');
const allAddInfo = document.getElementsByClassName('addInfo');
const confirmAdd = document.getElementById('confirmAdd');

// get userId and UserName cookies
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
const username = getCookie("username");

for(let i=0; i < allDetailedInfo.length; i++) {
	allDetailedInfo[i].disabled = true;
}

// adds the highlight function (adds "selected" class to highlighted row)
for(let i=1; i < tableRows.length; i++) {
	const row = tableRows[i];
	row.addEventListener('click', selectRow);
}

makeContactList();

function addToTable(tempFirstName, tempLastName, tempPhone, tempEmail) {
	const newRow = contactTable.insertRow();
	const firstNameCell = newRow.insertCell();
    firstNameCell.textContent = tempFirstName;

    const lastNameCell = newRow.insertCell();
    lastNameCell.textContent = tempLastName;

    const phoneNumberCell = newRow.insertCell();
    phoneNumberCell.textContent = tempPhone;

    const emailCell = newRow.insertCell();
    emailCell.textContent = tempEmail;
	
	newRow.addEventListener('click', selectRow);
}

function populateTable(data) {
	console.log("populateTable:");
	console.log(data);
	console.log(data.contacts);
	console.log(data.contacts.length);
	console.log(data.contacts[0]);
}

function makeContactList(){
	let tmp = {
		User_Id : userId,
		User_Name: username
	};
	let handleFunction = function(output) {
		console.log("handler: ");
		console.log(output);
		populateTable(output);
	}
	postRequest("ContactDisplay.php", tmp, handleFunction);
	console.log("data=");
	console.log(data);
	
	// get table info from SQL query and fill table
	
	//let text = ...
	//document.getElementById("contactList").innerHTML = text;
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

function postRequest(loc, tmp, handler){
	baseurl = "http://24.199.121.145";
	url = baseurl + "/API/"+loc;
	let request = new XMLHttpRequest();
	request.open("POST", url);
	console.log(tmp);
	let inputJSON = JSON.stringify(tmp);
	console.log(inputJSON);
	request.setRequestHeader("Content-Type", "application/json");
	request.onload = function() {
		if (request.status === 200) {
			// parse the response JSON and do something with it
			var outputData = JSON.parse(request.responseText);
			console.log("postrequest: "+outputData);
			console.log(outputData);
			// handler should do whatever needs to be done with that data
			handler(outputData);
		} else {
			console.log("Request failed with status " + request.status);
		}
	};
	request.send(inputJSON);
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
	const CREATED = "";
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
	created.value = CREATED;
	edited.value = EDITED;
	
}


function deleteSelected() {
	for(let i=0; i<tableRows.length; i++){
		if(tableRows[i].classList.contains('selected')) {
			contactTable.deleteRow(i);
		}
	}
	contactDetailsPage.style.display = 'none';
}
	
function setEditable() {
	editButton.style.display = 'none';
	confirmButton.style.display = 'inline';
	cancelButton.style.display = 'inline';
	
	for(let i = 0; i < allDetailedInfo.length; i++){
		allDetailedInfo[i].disabled = false;
	}
}

function deselectAll(){
	for(let i = 0;i < tableRows.length; i++) {
		tableRows[i].classList.remove('selected');
	}
	contactDetailsPage.style.display = 'none';
}

function setUneditable() {
	editButton.style.display = 'inline';
	confirmButton.style.display = 'none';
	cancelButton.style.display = 'none';
	
	for(let i=0; i<allDetailedInfo.length; i++) {
		allDetailedInfo[i].disabled = true;
	}
}

function cancelEdits() {
	// need to reload information from database
	const selectedRow = document.querySelector('.selected');
	fillDetailed(selectedRow);
	setUneditable();
}

function confirmEdits() {
	// update the database
	setUneditable();
	const selectedRow = document.querySelector('.selected');
	const cells = selectedRow.querySelectorAll('td');
	cells[0].innerHTML = detailedFirstName.value;
	cells[1].innerHTML = detailedLastName.value;
	cells[2].innerHTML = detailedPhone.value;
	cells[3].innerHTML = detailedEmail.value;
}

function showAddContactPage() {
	// deselectAll();
	addContactPage.style.display = 'block';
	for(let i=0; i < allAddInfo.length; i++) {
		allAddInfo[i].value = "";
	}
}

function addContact() {
	// add contact to database
	
	let tmp = {
		User_Id: userId,
		User_Name: username,
		FName: addFirstName.value, 
		LName: addLastName.value, 
		Phone: addPhone.value, 
		Email: addEmail.value,
		Street: addStreet.value,
		City: addCity.value,
		State: addState.value,
		Zip_Code: addZip.value,
		DOB: addBirth.value,
		Date_Created: addCreated.value
	}
	handleFunction = function() {}; // I don't do anything with the output data, I just want to add
	postRequest("ContactAdd.php", tmp, handleFunction);
	
	
	// add contact information to table
	const newRow = contactTable.insertRow();
	const firstNameCell = newRow.insertCell();
    firstNameCell.textContent = addFirstName.value;

    const lastNameCell = newRow.insertCell();
    lastNameCell.textContent = addLastName.value;

    const phoneNumberCell = newRow.insertCell();
    phoneNumberCell.textContent = addPhone.value;

    const emailCell = newRow.insertCell();
    emailCell.textContent = addEmail.value;
	
	newRow.addEventListener('click', selectRow);
	
	addContactPage.style.display = 'none';
}

function searchTable() {
	// Needs to be improved to search detailed values as well
    var input, filter, found, table, tr, td, i, j;
    input = document.getElementById("searchBar");
    filter = input.value.toUpperCase();
    table = document.getElementById("contactList");
    tr = table.getElementsByTagName("tr");
    for (i = 1; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        for (j = 0; j < td.length; j++) {
            if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                found = true;
            }
        }
        if (found) {
            tr[i].style.display = "";
            found = false;
        } else {
            tr[i].style.display = "none";
        }
    }
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
  