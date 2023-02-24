const mysql = require('mysql');

const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'password',
  database: 'mydatabase'
});

connection.connect(err => {
  if (err)
  {
    console.error(err); 
    return res.status(501).json({ message: 'Server cannot connect' });
  };
  console.log('Connected to the database');
});

const handleSignup = (req, res) =>
{
  const { user, password } = req.body;

  // Check if user already exists
  const sqlSelect = `SELECT * FROM users WHERE user = '${user}'`;
  connection.query(sqlSelect, (err, results) => {
    if (err) 
    {
      console.error(err);
    };
    if (results.length > 0) {
      return res.status(409).json({ message: 'User already exists' });
    }

    // Add new user
    const sqlInsert = `INSERT INTO users (user, password) VALUES ('${user}', '${password}')`;
    connection.query(sqlInsert, (error, result) => {
      if (error) throw error;
      const newUser = { id: result.insertId, user };
      return res.status(201).json({ message: 'User created', user: newUser });
    });
  });
});

module.exports = handleSignup;
