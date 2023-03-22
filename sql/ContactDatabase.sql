-- Contact Manager

-- Syntax for creation, using the database
create database COP4331;
use COP4331;

-- List of tables created are:
  -- Contact_database
  -- Contact_user

-- Description of Contact_user:
-- Contact_user has the columns User_Name, Password.
-- The User_Name acts as the primary key in Contact_user.
-- Syntax for Contact_user 

 CREATE TABLE `Contact_user` (
      User_Name varchar(255) NOT NULL,
      Password varchar(255) NOT NULL,
      User_Id int NOT NULL AUTO_INCREMENT,
      PRIMARY KEY (`User_Id`),
      UNIQUE KEY `User_Id` (`User_Id`),
      UNIQUE KEY `User_Name` (`User_Name`)
)

insert into Contact_user values('jhumphrey', 'Jhumphrey05@');
insert into Contact_user values('mrose', 'Mrose03@');
insert into Contact_user values('tmoyers', 'Tmoyers01@');
insert into Contact_user values('vmcdonald', 'Vmcdonald02@');
insert into Contact_user values('Whumphrey', 'Whumphrey06@');

-- addign field User_Id and making it an auto_increment field
alter table Contact_user ADD User_Id int(20) UNIQUE AUTO_INCREMENT;
-- adding new primary key
alter table Contact_user ADD PRIMARY KEY(User_Id);



-- Description of Contact_database
-- Contact_database will have the columns User_Name, FName, LName,Phone, Email, Street, City,
-- State, Zip_Code, DOB, Date_Created.
-- The “Phone” is the primary key here taking only unique values and no duplicates.
-- The "User_Name" is regarded as the foreign key referencing the parent table Contact_user.
-- Syntax for Contact_database

CREATE TABLE `Contact_database` (
      User_Id int(20) NULL,
      FName varchar(255) NOT NULL,
      LName varchar(255) NOT NULL,
      Phone varchar(255) NOT NULL,
      Email varchar(255) NOT NULL,
      Street varchar(255) NOT NULL,
      City varchar(255) NOT NULL,
      State varchar(255) DEFAULT NULL,
      Zip_Code int DEFAULT NULL,
      DOB date DEFAULT NULL,
      Date_Created` date DEFAULT NULL,
      Contact_Id int NOT NULL AUTO_INCREMENT,
      PRIMARY KEY (`Contact_Id`),
      UNIQUE KEY `Contact_Id` (`Contact_Id`),
      KEY `FK_ud` (`User_Id`),
      CONSTRAINT `FK_ud` FOREIGN KEY (`User_Id`) REFERENCES `Contact_user` (`User_Id`)
)



