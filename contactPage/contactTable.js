const contactTable = document.getElementById('contactList');
const contactTableRows = contactTable.getElementsByTagName('tr');
const contactDetailsPage = document.getElementById('contactDetails');
const searchBar = document.getElementById("searchBar");

const userId = getCookie("userId");
const username = getCookie("username");

searchBar.addEventListener('input', searchTable);
fillContactTable();

async function fillContactTable(){
	const tmp = {
		User_Id : userId
	};
	const data = await makeRequest("ContactDisplay.php", tmp);
	
	for(let i = 0; i < data.contacts.length; i++) {
		const cur = data.contacts[i];
		addToTable(cur.FName, cur.LName, cur.Phone, cur.Email, cur.Contact_Id);
	}
}

function addToTable(tempFirstName, tempLastName, tempPhone, tempEmail, tempID) {
	const newRow = contactTable.insertRow();
	
	const firstNameCell = newRow.insertCell();
	firstNameCell.textContent = tempFirstName;
	
	const lastNameCell = newRow.insertCell();
	lastNameCell.textContent = tempLastName;

    const phoneNumberCell = newRow.insertCell();
    phoneNumberCell.textContent = tempPhone;

    const emailCell = newRow.insertCell();
    emailCell.textContent = tempEmail;
	
	const hiddenCell = newRow.insertCell();
	hiddenCell.style.display = "none";
	hiddenCell.textContent = tempID;
	
	newRow.addEventListener('click', selectRow);
}

function selectRow() {
	if(this.classList.contains('selected')){
		this.classList.remove('selected');
		contactDetailsPage.style.display = 'none';
		return;
	}
	// remove previously selected row
	for(let i=0; i < contactTableRows.length; i++) {
		contactTableRows[i].classList.remove('selected');
	}
	this.classList.add('selected');
	
	fillDetailed(this);	
}

function deleteFromDatabase(row){
	const cells = row.querySelectorAll('td');
	const phone = cells[2].textContent;
	
	let tmp = {
		Contact_Id: cells[4].textContent
	};
	console.log("delete: ");
	console.log(tmp);
	let handleFunction = function(){} // don't need to do anything with return values
	
	makeRequest("ContactDelete.php", tmp);
	
}

function deleteSelected() {
	for(let i=0; i<contactTableRows.length; i++){
		if(contactTableRows[i].classList.contains('selected')) {
			deleteFromDatabase(contactTableRows[i]);
			contactTable.deleteRow(i);
		}
	}
	contactDetailsPage.style.display = 'none';
}

function deselectAll(){
	for(let i = 0;i < contactTableRows.length; i++) {
		contactTableRows[i].classList.remove('selected');
	}
	contactDetailsPage.style.display = 'none';
}

function searchTable() {
	console.log("Searching");
	// Needs to be improved to search detailed values as well
    var input, filter, found, table, tr, td, i, j;
    filter = searchBar.value.toUpperCase();
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