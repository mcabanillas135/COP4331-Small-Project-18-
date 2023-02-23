var mysql = require('mysql');

var con = mysql.createConnection({
  host: "localhost",
  user: "yourusername",
  password: "yourpassword",
  database: "cop4331"
});

con.connect(function(err) {
  if (err) throw err;
  console.log("Connected!");
  var sql = "insert into Contact_Database values('000-000-0000', 'Testing', 'Stuff', 'TestingStuff@TESTSTUFF.com')";
  con.query(sql, function (err, result) {
    if (err) throw err;
    console.log("1 record inserted");
  });
});
