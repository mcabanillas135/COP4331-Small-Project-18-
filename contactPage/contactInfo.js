const detailedFirstName = document.getElementById('detailedFirstName');
const detailedLastName = document.getElementById('detailedLastName');
const detailedEmail = document.getElementById('detailedEmail');
const detailedPhone = document.getElementById('detailedPhone');
const detailedStreet = document.getElementById('detailedStreet');
const detailedCity = document.getElementById('detailedCity');
const detailedState = document.getElementById('detailedState');
const detailedZipCode = document.getElementById('detailedZipCode');
const detailedBirthDate = document.getElementById('detailedBirthDate');
const detailedDateCreated = document.getElementById('detailedDateCreated');
const detailedEditButton = document.getElementById('detailedEditButton');
const detailedConfirmButton = document.getElementById('detailedConfirmButton');
const detailedCancelButton = document.getElementById('detailedCancelButton');
const allDetailedInfo = document.getElementsByClassName("detailedInfo");


for(let i=0; i < allDetailedInfo.length; i++) {
	allDetailedInfo[i].disabled = true;
}

async function fillDetailed(selectedRow) {
	// api call that fills information for detailed tableRows
	
	contactDetailsPage.style.display = 'block';
	
	const cells = selectedRow.querySelectorAll('td');
	
	let tmp = {
		User_Id : userId,
		FName: cells[0].textContent,
		LName: cells[1].textContent
	};
	
	data = await makeRequest("ContactSearch.php", tmp);
	data = data.contacts[0];
	
	const fName = data.FName;
	const lName = data.LName;
	const phone = cells[2].textContent;
	const email = cells[3].textContent;
	const STREET = data.Street;
	const CITY = data.City;
	const STATE = data.State;
	const ZIP = data.Zip_Code;
	const BIRTH = data.DOB;
	const CREATED = data.Date_Created;

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
	
}

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
	
	const selectedRow = document.querySelector('.selected');
	const cells = selectedRow.querySelectorAll('td');
	
	// update the database
	let tmp = {
		FName: detailedFirstName.value, 
		LName: detailedLastName.value, 
		Contact_Id: cells[4].innerHTML,
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
	cells[0].innerHTML = detailedFirstName.value;
	cells[1].innerHTML = detailedLastName.value;
	cells[2].innerHTML = detailedPhone.value;
	cells[3].innerHTML = detailedEmail.value;
}