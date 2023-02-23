const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const mysql = require('mysql');
const session = require('express-session');
const path = require('path');
const app = express();

// Middleware
app.use(bodyParser.json());
app.use(cors());

// MySQL connection
const connection = mysql.createConnection(
  {
    host: 'localhost',
    user: 'contactmanager',
    password: 'COP4331',
    database: 'COP4331'
  }
);

connection.connect(error => 
  {
    if (error) 
    {
      console.log('Error connecting to the database:', err):
      return;
    }
    console.log('Connected to the database');
  }
);

// Signup endpoint
app.post('/signup', (req, res) => 
  {
    const { user, password } = req.body;

    // Check if user already exists
    const sqlSelect = `SELECT * FROM Contact_User WHERE User_Name = '${user}'`;
    connection.query(sqlSelect, (error, results) => 
      {
        if (error) throw error;
        if (results.length > 0) 
          {
            return res.status(409).json({ message: 'User already exists' });
          }

        // Add new user
        const sqlInsert = `INSERT INTO Contact_User (user, password) VALUES ('${user}', '${password}')`;
        connection.query(sqlInsert, (error, result) => 
          {
            if (error) throw error;
            const newUser = { id: result.insertId, user };
            return res.status(201).json({ message: 'User created', user: newUser });
          });
      });
  });

// Login endpoint
app.post('/login', (req, res) => {
  const { user, password } = req.body;

  // Check if user exists
  const sqlSelect = `SELECT * FROM Contact_User WHERE User_Name = '${user}' AND Password = '${password}'`;
  connection.query(sqlSelect, (error, results) => {
    if (error) throw error;
    if (results.length === 0) {
      return res.status(401).json({ message: 'Invalid email or password' });
    }

    const user = results[0];
    return res.status(200).json({ message: 'Login successful', user });
  });
});

// Start server
app.listen(3000, () => console.log('Server running on port 3000'));
