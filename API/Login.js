const connection = mysql.createConnection({
  host: 'cop4332.xyz',
  user: 'contactmanager',
  password: 'COP4331',
  database: 'COP4331'
});

connection.connect(error => {
  if (error) 
  {
    console.log('Failed to connect to database'); 
  };
  console.log('Connected to the database');
});

const handleLogin = (req, res) => 
{
  const { user, password } = req.body;

  // Check if user exists
  const sqlSelect = `SELECT * FROM Contact_User WHERE User_Name = '${User_Name}' AND Password = '${Password}'`;
  connection.query(sqlSelect, (error, results) => {
    if (error) throw error;
    if (results.length === 0) {
      return res.status(401).json({ message: 'Invalid email or password' });
    }

    const user = results[0];
    return res.status(200).json({ message: 'Login successful', user });
  });
};

module.exports = handleLogin;
