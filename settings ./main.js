const settingsBtn = document.getElementById('settings-btn');
const editUsernameBtn = document.querySelector('#Edit-User');
const editPasswordBtn = document.querySelector('#Edit-pass');



document.getElementById("settings-btn").addEventListener("click", function() {
    var dropdown = document.getElementById("settings-dropdown");
    if (dropdown.style.display === "none") {
      dropdown.style.display = "block";
    } else {
      dropdown.style.display = "none";
    }
  });

  // When the slider value changes, update the text font size
  document.getElementById("size-slider").addEventListener("input", function() {
    var size = this.value;
    document.getElementById("text").style.fontSize = size + "px";
  });

  editUsernameBtn.addEventListener('click', () => {
    const newUsername = prompt('Enter your new username:');
    if (newUsername) {
      document.querySelector('#username').value = newUsername;
    }
  });
  
  editPasswordBtn.addEventListener('click', () => {
    const newPassword = prompt('Enter your new password:');
    if (newPassword) {
      document.querySelector('#password').value = newPassword;
    }
  });
  // Get the settings button and the dark mode widget script
const settingsButton = document.getElementById('settings-btn');
const darkModeScript = document.createElement('script');
darkModeScript.src = 'https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js';

// Add a click event listener to the settings button
settingsButton.addEventListener('click', () => {
  // If the dark mode widget script hasn't been added yet, add it to the page
  if (!document.querySelector('script[src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"]')) {
    document.body.appendChild(darkModeScript);
  }

  // Show the dark mode widget
  new Darkmode().showWidget();
});

  
const options = {
    bottom: '64px', // default: '32px'
    right: '32px', // default: '32px'
    left: 'unset', // default: 'unset'
    time: '0.3', // default: '0.3s'
    mixColor: '#fff', // default: '#fff'
    backgroundColor: '#fff',  // default: '#fff'
    buttonColorDark: '#100f2c',  // default: '#100f2c'
    buttonColorLight: '#fff', // default: '#fff'
    saveInCookies: true, // default: true,
    label: '🌓', // default: ''
    autoMatchOsTheme: true // default: true
  }
  
  const darkmode = new Darkmode(options);
  darkmode.showWidget();