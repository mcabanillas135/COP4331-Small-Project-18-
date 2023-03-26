const baseurl = "http://24.199.121.145/API/";

// just returns data from php request
async function makeRequest(file, input){
	return await fetch(baseurl+file, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json'
		},
		body: JSON.stringify(input)
	}).then(function(response){		
		console.log(response);
		return response.json();
	);
}

// gets value of cookie given its name
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