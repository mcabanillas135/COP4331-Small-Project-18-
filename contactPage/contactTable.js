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
		Phone: phone
	};
	console.log("delete: ");
	console.log(tmp);
	let handleFunction = function(){} // don't need to do anything with return values
	
	postRequest("ContactDelete.php",tmp,handleFunction);
	
}

function deleteSelected() {
	for(let i=0; i<tableRows.length; i++){
		if(tableRows[i].classList.contains('selected')) {
			deleteFromDatabase(tableRows[i]);
			contactTable.deleteRow(i);
		}
	}
	contactDetailsPage.style.display = 'none';
}

function deselectAll(){
	for(let i = 0;i < tableRows.length; i++) {
		tableRows[i].classList.remove('selected');
	}
	contactDetailsPage.style.display = 'none';
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