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
	
	var buttons = document.getElementsByTagName("button");
	for (var i = 0; i < buttons.length; i++) {
	  buttons[i].style.fontSize = size + "px";
	}
  });

editUsernameBtn.addEventListener('click', e => {
  e.preventDefault();
  window.location.href = "edituser.html";

});

editPasswordBtn.addEventListener('click', e => {
  e.preventDefault();
  window.location.href = "editpass.html";
  
});
document.getElementById("logout").addEventListener("click", e => {
	e.preventDefault();
	window.location.href = "index.html";

});
