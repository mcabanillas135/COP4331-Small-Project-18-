<?php
class User
{
    private $conn;
    public $id;
    public $username;
    public $email;
    public $password;
    public $data;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function signup()
    {
        if (!$this->isEmailExist()) {
            $query = "INSERT INTO users SET username=:username, email=:email, password=:password";
            $stmt = $this->conn->prepare($query);
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":email", $this->email);
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
            $stmt->bindParam(":password", $password_hash);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function login()
    {
        $query = "SELECT id, username, email, password FROM users WHERE email='$this->email' LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->data = $row;

            if (password_verify($this->password, $row['password'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function isEmailExist()
    {
        $query = "SELECT email FROM users WHERE email='$this->email'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
