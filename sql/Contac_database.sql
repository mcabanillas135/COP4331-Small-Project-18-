-- Contact Manager

-- Syntax for creation, using the database
create database COP4331;
use COP4331;

-- List of tables created are:
  -- Contact_database
  -- Contact_personal
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
-- Contact_database will have the columns Phone,  First Name, Last Name, Email.
-- The “Email” is the primary key here taking only unique values and no duplicates.
-- Syntax for Contact_database

create table Contact_database(Phone varchar(255) NOT NULL,
                                  First_Name varchar(255) NOT NULL,
                                   Last_Name varchar(255) NOT NULL,
                             Email varchar(255), PRIMARY KEY (Email));

insert into Contact_database values('440-253-2934', 'Jeff', 'Humphrey', 'JeffrHumphrey@jourrapide.com');
insert into Contact_database values('619-521-6156', 'Margaret', 'Rose', 'MargaretJRose@jourrapide.com');
insert into Contact_database values('708-729-5525', 'Tracy', 'Moyers', 'TracyCMoyers@rhyta.com');
insert into Contact_database values('920-630-8895', 'Vanessa', 'McDonald', 'VanessaTMcDonald@jourrapide.com');
insert into Contact_database values('213-339-1046', 'Wilbert', 'Humphrey', 'WilbertSHumphrey@rhyta.com');

-- Description of Contact_personal
-- Contact_personal will have the columns Email, Phone, Street, City, State, Zip_Code, DOB, Date_Created, Date_Edited.
-- The “Email” acts as the primary key in this table.
-- Syntax of Contact_personal

create table Contact_personal(Email varchar(255),
                                  Phone varchar(255),
                                   Street varchar(255),
                                   City varchar(255),
                                   State varchar(255),
                                   Zip_Code int, DOB DATE,
                                   Date_Created DATE, Date_Edited DATE,
                                   PRIMARY KEY (Email));

insert into Contact_personal values('TracyCMoyers@rhyta.com', '708-729-5525', '496 Rose Street', 'Arlington Heights', 'IL', '60005', '1955-03-15', '2001-06-20', '2020-09-12');
insert into Contact_personal values('VanessaTMcDonald@jourrapide.com', '920-630-8895', '3410 Tail Ends Road', 'Milwaukee', 'WI', '53202', '1984-04-14', '1999-07-30', '2010-07-30');
insert into Contact_personal values('MargaretJRose@jourrapide.com', '619-521-6156', '2251 Poplar Avenue', 'San Diego', 'CA', '92105', '1996-10-28', '2010-01-27', '2019-08-09');
insert into Contact_personal values('JeffRHumphrey@jourrapide.com', '440-253-2934', '2934 Ralph Drive', 'Independence', 'OH', '44131', '1974-07-05', '1999-09-08', '2018-05-04');
insert into Contact_personal values('WilbertSHumphre@rhyta.com', '213-339-1046', '4706 Brannon Street', 'Los Angeles', 'CA', '90057', '1958-12-16', '2001-06-20', '2011-06-20');


