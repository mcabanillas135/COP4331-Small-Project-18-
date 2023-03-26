const contactTable = document.getElementById('contactList');
const contactTableRows = contactTable.getElementsByTagName('tr');
const contactDetailsPage = document.getElementById('contactDetails');

const userId = getCookie("userId");
const username = getCookie("username");

fillContactTable();

async function fillContactTable(){
	const tmp = {
		User_Id : userId
	};
	const data = await makeRequest("ContactDisplay.php", tmp);
	
	for(let i = 0; i < data.contacts.length; i++) {
		const cur = data.contacts[i];
		addToTable(cur.FName, cur.LName, cur.Phone, cur.Email);
	}
}

function addToTable(tempFirstName, tempLastName, tempPhone, tempEmail) {
	const newRow = contactTable.insertRow();
	
	const nameCell = newRow.insertCell();
	nameCell.textContent = tempFirstName + tempLastName;

    const phoneNumberCell = newRow.insertCell();
    phoneNumberCell.textContent = tempPhone;

    const emailCell = newRow.insertCell();
    emailCell.textContent = tempEmail;
	
	newRow.addEventListener('click', selectRow);
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