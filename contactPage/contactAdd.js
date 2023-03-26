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
const allAddInfo = document.getElementsByClassName('addInfo');
const confirmAdd = document.getElementById('confirmAdd');

function setEditable() {
	editButton.style.display = 'none';
	confirmButton.style.display = 'inline';
	cancelButton.style.display = 'inline';
	
	for(let i = 0; i < allDetailedInfo.length; i++){
		allDetailedInfo[i].disabled = false;
	}
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
	document.getElementById("editErrorMessage").style.display = "none";
}

function confirmEdits() {
	
	// update the database
	let tmp = {
		FName: detailedFirstName.value, 
		LName: detailedLastName.value, 
		Phone: detailedPhone.value, 
		Email: detailedEmail.value,
		Street: street.value,
		City: city.value,
		State: state.value,
		Zip_Code: zip.value,
		DOB: birth.value
	};
	let handleFunction = function(){}; // we don't do anything with the response
	
	console.log("Sending Update Request: ");
	console.log(tmp);
	makeRequest("ContactUpdate.php", tmp);
	
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

function hideAddContactPage(){
	addContactPage.style.display = 'none';
	document.getElementById("addErrorMessage").style.display = 'none';
}

// (for now?) just tests if it is an integer
function validZip(value) {
	if(parseInt(value,10).toString()===value) {
	return true
	}
	return false;
}

function validBirthday(date){
	return true;
}

function unused(tempPhone){
	return true;
	
	// query database for if element is used
	let tmp = {
		User_Id: userId,
		Phone: tempPhone
	}
	let handleFunction = function(output) {
		// check if result is error message
		
	}
	postRequest("", tmp, handleFunction);
}

function addContact() {
	
	// check that entries are valid
	
	document.getElementById("addErrorMessage").style.display = 'none';
	// check that entries are non-empty
	if(addFirstName.value == "" || addLastName.value == "" || addEmail.value == "" || addPhone.value == "") {
		document.getElementById("addErrorMessage").innerHTML = "Must include first name, last name, email, and phone number";
		document.getElementById("addErrorMessage").style.display = 'block';
		return;
	}
	// check that phone number is not used
	if(!unused(addPhone.value)){
		document.getElementById("addErrorMessage").innerHTML = "Phone number is already in use for another contact";
		document.getElementById("addErrorMessage").style.display = 'block';
		return false;
	}
	// check if birth date is valid
	if(!validBirthday(addBirth.value)){
		document.getElementById("addErrorMessage").innerHTML = "Birth Date is invalid";
		document.getElementById("addErrorMessage").style.display = 'block';
		return false;
	}
	if(addZip.value == "") {
		addZip.value = "0";
	}
	// check if zip code is valid
	if(!validZip(addZip.value)){
		document.getElementById("addErrorMessage").innerHTML = "Zip-Code is invalid";
		document.getElementById("addErrorMessage").style.display = 'block';
		return false;
	}
	
	
	// add entries to database
	
	let yourDate = new Date();
	yourDate.toISOString().split('T')[0];
	
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
		Date_Created: yourDate
	}
	handleFunction = function() {}; // I don't do anything with the output data, I just want to add
	makeRequest("ContactAdd.php", tmp);
	
	
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