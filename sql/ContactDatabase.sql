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

create table Contact_user(User_Name varchar(255) NOT NULL,
                              Password varchar(255) NOT NULL UNIQUE,
                               PRIMARY KEY (User_Name));

insert into Contact_user values('jhumphrey', 'Jhumphrey05@');
insert into Contact_user values('mrose', 'Mrose03@');
insert into Contact_user values('tmoyers', 'Tmoyers01@');
insert into Contact_user values('vmcdonald', 'Vmcdonald02@');
insert into Contact_user values('Whumphrey', 'Whumphrey06@');


-- Description of Contact_database
-- Contact_database will have the columns User_Name, FName, LName,Phone, Email, Street, City,
-- State, Zip_Code, DOB, Date_Created.
-- The “Phone” is the primary key here taking only unique values and no duplicates.
-- The "User_Name" is regarded as the foreign key referencing the parent table Contact_user.
-- Syntax for Contact_database

create table Contact_database(User_Name varchar(255) NOT NULL,
                              FName varchar(255) NOT NULL,
                              LName varchar(255) NOT NULL,
                              Phone varchar(255) NOT NULL,
                              Email varchar(255) NOT NULL,
                              Street varchar(255) NOT NULL,
                              City varchar(255) NOT NULL,
                              State varchar(255), Zip_Code int, DOB DATE, Date_Created DATE,
                              PRIMARY KEY (Phone)
                              CONSTRAINT FK_ud FOREIGN KEY(User_Name)
                              REFERENCES Contact_user(User_Name));

