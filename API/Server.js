const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const mysql = require('mysql');
const handleLogin = require('./Login');
const handleSignup = require('./Signup');

const app = express();

// Middleware
app.use(bodyParser.json());
app.use(cors());

// MySQL connection
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'password',
  database: 'mydatabase'
});

connection.connect(error => {
  if (error) throw error;
  console.log('Connected to the database');
});

// Signup + Login endpoint
app.post('/signup', handleSignup);
app.post('/login', HandleLogin);

// Start server
app.listen(3000, () => 
{
  console.log('Server running on port 3000')
});
