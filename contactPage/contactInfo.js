const contactDetailsPage = document.getElementById('contactDetailsPage');
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

