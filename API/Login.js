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
  };
  console.log('Connected to the database');
});

const handleLogin = (req, res) => 
{
  const { id, user, password } = req.body;

  // Check if user exists
  const sqlSelect = `SELECT * FROM Contact_User WHERE User_Name = '${user}' AND Password = '${password}'`;
  connection.query(sqlSelect, (err, results) => {
    if (err) 
    {
      console.error(err);
      return res.status(500).json({ message: 'Server error' });
    }
    if (results.length === 0) 
    {
      return res.status(401).json({ message: 'Invalid email or password' });
    }

    const user = results[0];
    return res.status(200).json({ message: 'Login successful', user });
  });

};

module.exports = handleLogin;
