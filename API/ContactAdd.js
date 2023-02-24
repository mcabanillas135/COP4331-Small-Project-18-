const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const mysql = require('mysql');

const app = express();

// Middleware
app.use(bodyParser.json());
app.use(cors());

var con = mysql.createConnection({
  host: 'cop4332.xyz',
  user: 'contactmanager',
  password: 'COP4331',
  database: 'COP4331'
});

con.connect(function(err) {
  if (err) throw err;
  console.log("Connected!");
});

app.post('/ContactAdd', (req, res) => {
  const { Phone, First_Name, Last_Name, Email } = req.body;

  // Check if contact already exists
  const sqlSelect = `SELECT * FROM Contact_Database WHERE Phone = '${Phone}'`;
  connection.query(sqlSelect, (error, results) => {
    if (error) throw error;
    if (results.length > 0) {
      return res.status(409).json({ message: 'Contact already exists' });
    }

    // Add new contact
    const sqlInsert = `INSERT INTO Contact_Database (Phone, First_Name, Last_Name, Email) VALUES ('${Phone}', '${First_Name}', '${Last_Name}', '${Email}')`;
    connection.query(sqlInsert, (error, result) => {
      if (error) throw error;
      return res.status(201).json({ message: 'Contact created'});
    });
  });
});
