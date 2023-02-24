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
  host: 'cop4332.xyz',
  user: 'contactmanager',
  password: 'COP4331',
  database: 'COP4331'
});

connection.connect(err => {
  if (err) 
  {
    console.error(err); 
    return res.status(501).json({ message: 'Server cannot connect' });
  };
  console.log('Connected to the database');
});

// Signup + Login + ContactAdd endpoint
app.post('/signup', handleSignup);
app.post('/login', handleLogin);
app.post('/ContactAdd', handleContactAdd);

// Start server
app.listen(3000, () => 
{
  console.log('Server running on port 3000')
});
