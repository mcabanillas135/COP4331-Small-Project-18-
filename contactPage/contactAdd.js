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

function isIntegerString(value){
	for(var i=0;i<value.length;i++){
		if(value[i]<'0' || value[i]>'9') return false;
	}
	return true;
}
// (for now?) just tests if it is an integer
function validZip(value) {
	if(parseInt(value,10).toString()===value) {
		return true
	}
	return false;
}

function validBirthday(date){
	if(date.length != 10) {
		console.log("Invalid Length");
		return false;
	}
	if( !(date[4]=='-' && date[7]=='-') ) {
		console.log("Invalid dashes");
		return false;
	}
	if( !isIntegerString(date.substr(0, 4)) || !isIntegerString(date.substr(5,2)) || !isIntegerString(date.substr(8,2)) ){
		console.log("Not Integers");
		console.log(isIntegerString(date.substr(0, 4)));
		console.log(isIntegerString(date.substr(5, 2)));
		console.log(isIntegerString(date.substr(8 ,2)));
		return false;
	}
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
	if(addBirth.value == ""){
		addBirth.value = "0001-01-01";
	}
	// check if birth date is valid
	if(!validBirthday(addBirth.value)){
		document.getElementById("addErrorMessage").innerHTML = "Birth Date is invalid, must be in format YYYY-MM-DD";
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
		FName: addFirstName.value, 
		LName: addLastName.value, 
		Phone: addPhone.value, 
		Email: addEmail.value,
		Street: addStreet.value,
		City: addCity.value,
		State: addState.value,
		Zip_Code: addZip.value,
		DOB: addBirth.value,
		Date_Created: "2023-03-27"
	}
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