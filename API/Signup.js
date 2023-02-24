const mysql = require('mysql');

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
  }
  console.log('Connected to the database');
});

const handleSignup = (req, res) =>
{
  const { id, user, password } = req.body;

  // Check if user already exists
  const sqlSelect = `SELECT * FROM Contact_User WHERE User_Id = '${id}'`;
  connection.query(sqlSelect, (err, results) => {
    if (err) 
    {
      console.error(err);
      return res.status(500).json({ message: 'Server error' });
    }
    if (results.length > 0) 
    {
      return res.status(409).json({ message: 'User already exists' });
    }

    // Add new user
    const sqlInsert = `INSERT INTO Contact_User VALUES ('${id}', '${user}', '${password}')`;
    connection.query(sqlInsert, (err, result) => {
      if (err)
      {
        console.error(err);
        return res.status(500).json({ message: 'Server error' });
      };
      const newUser = { id: result.insertId, user };
      return res.status(201).json({ message: 'User created', user: newUser });
    });
  });
});

module.exports = handleSignup;
