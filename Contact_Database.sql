-- Contact Manager

-- Syntax for creation, using the database
create database COP4331;
use COP4331;

-- List of tables created are:
  -- Contact_Database
  -- Contact_Personal
  -- Contact_User

-- Description of Contact_User:
-- Contact_User has the columns User_Id, User_Name, Password.
-- The User_Id acts as the primary key in Contact_User, being it a foreign key in the Contact_Database.
-- Syntax for Contact_User:

create table Contact_User(User_Id varchar(255),
                          User_Name varchar(255) NOT NULL,
                          Password varchar(255) NOT NULL UNIQUE,
                          PRIMARY KEY (User_Id));

insert into Contact_User values('TM', 'tmoyers', 'Tmoyers01@');
insert into Contact_User values('VM', 'vmcdonald', 'Vmcdonald02@');
insert into Contact_User values('MR', 'mrose', 'Mrose03@');
insert into Contact_User values('TD', 'tderryberry', 'Tderryberry04@');
insert into Contact_User values('JH', 'jhumphrey', 'Jhumphrey05@');
insert into Contact_User values('WH', 'Whumphrey', 'Whumphrey06@');
insert into Contact_User values('CS', 'csmith', 'Csmith07@');
insert into Contact_User values('QG', 'qgarcia', 'Qgarcia08@');
insert into Contact_User values('LD', 'ldriggers', 'Ldriggers09@');
insert into Contact_User values('VW', 'vwebsters', 'Vwebster10@');
insert into Contact_User values('LC', 'lcowles', 'Lcowles11@');
insert into Contact_User values('EE', 'eearly', 'Eearly12@');
insert into Contact_User values('JJ', 'jjohnson', 'Jjohnshon13@');
insert into Contact_User values('KR', 'krideout', 'Krideout14@');
insert into Contact_User values('DP', 'dpaulin', 'Dpaulin15@');
insert into Contact_User values('BM', 'bmosher', 'Bmosher16@');
insert into Contact_User values('EG', 'egoodman', 'Egoodman17@');
insert into Contact_User values('TG', 'tgalarza', 'Tgalarza18@');
insert into Contact_User values('AM', 'amurray', 'Amurray19@');
insert into Contact_User values('LE', 'ldexter', 'Ldexter20@');

-- Description of Contact_Database
-- Contact_Database will have the columns Phone,  First Name, Last Name, Email, Userid.
-- The “Phone” is the primary key here taking only unique values and no duplicates.
-- Syntax for Contact_Database

create table Contact_Database(Phone varchar(255) NOT NULL,
                              First_Name varchar(255) NOT NULL,
                              Last_Name varchar(255) NOT NULL,
                              Email varchar(255), PRIMARY KEY (Email));

insert into Contact_Database values('708-729-5525', 'Tracy', 'Moyers', 'TracyCMoyers@rhyta.com');
insert into Contact_Database values('920-630-8895', 'Vanessa', 'McDonald', 'VanessaTMcDonald@jourrapide.com');
insert into Contact_Database values('619-521-6156', 'Margaret', 'Rose', 'MargaretJRose@jourrapide.com');
insert into Contact_Database values('478-274-4245', 'Thomas', 'Derryberry', 'ThomasRDerryberry@teleworm.com');
insert into Contact_Database values('440-253-2934', 'Jeff', 'Humphrey', 'JeffrHumphrey@jourrapide.com');
insert into Contact_Database values('213-339-1046', 'Wilbert', 'Humphrey', 'WilbertSHumphrey@rhyta.com');
insert into Contact_Database values('302-622-8370', 'Carol', 'Smith', 'CarolDSmith@teleworm.us');
insert into Contact_Database values('708-283-4388', 'Qunicy', 'Garcia', 'QunicyAGarcia@teleworm.us');
insert into Contact_Database values('509-667-2285', 'Liliian', 'Driggers', 'LiliianEDriggers@teleworm.us');
insert into Contact_Database values('330-821-4470', 'Vanessa', 'Webster', 'VanessaHWebster@jourrapide.com');
insert into Contact_Database values('972-646-7613', 'Lorie', 'Cowles', 'LorieMCowles@armyspy.com');
insert into Contact_Database values('402-763-5241', 'Eugene', 'Early', 'EugeneEEarly@jourrapide.com');
insert into Contact_Database values('612-601-1226', 'James', 'Johnson', 'JamesCJohnson@jourrapide.com');
insert into Contact_Database values('775-249-3345', 'Kathryn', 'Rideout', 'KathrynORideout@jourrapide.com');
insert into Contact_Database values('724-756-5649', 'Dennis', 'Paulin', 'DennisRPaulin@rhyta.com');
insert into Contact_Database values('813-295-3085', 'Brian', 'Mosher', 'BrianMMosher@rhyta.com');
insert into Contact_Database values('401-254-3338', 'Earl', 'Goodman', 'EarlEGoodman@rhyta.com');
insert into Contact_Database values('786-302-7724', 'Theresa', 'Galarza', 'TheresaJGalarza@armyspy.com');
insert into Contact_Database values('775-490-1233', 'Anna', 'Murray', 'AnnaRMurray@teleworm.us');
insert into Contact_Database values('828-318-7515', 'Lois', 'Dexter', 'LoisDDexter@armyspy.com');

-- Adding another attribute in Contact_Database named “User_Id”.
-- The “User_Id” will take only unique keys and no duplicate values.
-- Altering the structure of the table using the alter command.
-- Updating the records of the table using the update command.

alter table Contact_Database add User_Id varchar(255) UNIQUE;
update Contact_Database set User_Id = 'WH' where Phone = '213-339-1046';
update Contact_Database set User_Id = 'CS' where Phone = '302-622-8370';
update Contact_Database set User_Id = 'TM' where Phone = '708-729-5525';
update Contact_Database set User_Id = 'MR' where Phone = '920-630-8895';
update Contact_Database set User_Id = 'TD' where Phone = '619-521-6156';
update Contact_Database set User_Id = 'VM' where Phone = '920-630-8895';
update Contact_Database set User_Id = 'MR' where Phone = '619-521-6156';
update Contact_Database set User_Id = 'TD' where Phone = '478-274-4245';
update Contact_Database set User_Id = 'JH' where Phone = '440-253-2934';
update Contact_Database set User_Id = 'QG' where Phone = '708-283-4388';
update Contact_Database set User_Id = 'LD' where Phone = '509-667-2285';
update Contact_Database set User_Id = 'VW' where Phone = '330-821-4470';
update Contact_Database set User_Id = 'LC' where Phone = '972-646-7613';
update Contact_Database set User_Id = 'EE' where Phone = '402-763-5241';
update Contact_Database set User_Id = 'JJ' where Phone = '614-601-1226';
update Contact_Database set User_Id = 'KR' where Phone = '775-249-3345';
update Contact_Database set User_Id = 'DP' where Phone = '724-756-5649';
update Contact_Database set User_Id = 'BM' where Phone = '813-295-3085';
update Contact_Database set User_Id = 'EG' where Phone = '401-254-3338';
update Contact_Database set User_Id = 'TG' where Phone = '786-302-7724';
update Contact_Database set User_Id = 'AM' where Phone = '775-490-1233';
update Contact_Database set User_Id = 'LE' where Phone = '828-318-7515';
update Contact_Database set User_Id = 'JJ' where Phone = '612-601-1226';

-- Description of Contact_Personal
-- Contact_Personal will have the columns Email, Phone, Street, City, State, Zip_Code, DOB, Date_Created, Date_Edited.
-- The “Email” acts as the primary key in this table with the “Phone” from Contact_Database as the foreign key.
-- Syntax of Contact_Personal

create table Contact_Personal(Email varchar(255),
                              Phone varchar(255),
                              Street varchar(255),
                              City varchar(255),
                              State varchar(255),
                              Zip_Code int, DOB DATE,
                              Date_Created DATE, Date_Edited DATE,
                              PRIMARY KEY (Email),
                              FOREIGN KEY (Phone) REFERENCES Contact_Database (Phone));

insert into Contact_Personal values('TracyCMoyers@rhyta.com', '708-729-5525', '496 Rose Street', 'Arlington Heights', 'IL', '60005', '1955-03-15', '2001-06-20', '2020-09-12');
insert into Contact_Personal values('VanessaTMcDonald@jourrapide.com', '920-630-8895', '3410 Tail Ends Road', 'Milwaukee', 'WI', '53202', '1984-04-14', '1999-07-30', '2010-07-30');
insert into Contact_Personal values('MargaretJRose@jourrapide.com', '619-521-6156', '2251 Poplar Avenue', 'San Diego', 'CA', '92105', '1996-10-28', '2010-01-27', '2019-08-09');
insert into Contact_Personal values('JeffRHumphrey@jourrapide.com', '440-253-2934', '2934 Ralph Drive', 'Independence', 'OH', '44131', '1974-07-05', '1999-09-08', '2018-05-04');
insert into Contact_Personal values('WilbertSHumphre@rhyta.com', '213-339-1046', '4706 Brannon Street', 'Los Angeles', 'CA', '90057', '1958-12-16', '2001-06-20', '2011-06-20');
insert into Contact_Personal values('CarolDSmith@teleworm.us', '302-622-8370', '3434 Maud Street', 'Wilmington' ,'DE', '19801', '1955-03-15', '1998-10-28', '2010-07-30');
insert into Contact_Personal values('QunicyAGarcia@teleworm.us', '708-283-4388', '1931 Post Farm Road', 'Arlington Heights', 'IL', '6005', '1969-03-31', '2013-05-01', '2023-09-09');
insert into Contact_Personal values('LiliianEDriggers@teleworm.us', '509-667-2285', '1492 Calico Drive', 'Wenatchee', 'WA', '98801', '1957-12-22', '2011-10-11', '2021-02-09');
insert into Contact_Personal values('VaneesaHWebster@jourrapide.com', '330-821-4470', '203 Rivendell Drive', 'Alliance', 'OH', '44601', '1939-05-11','1955-03-15', '2017-09-27');
insert into Contact_Personal values('LorieMCowles@armyspy.com', '972-646-7613', '216 Worhtington Drive', 'Bardwell', 'TX', '75165', '1982-03-31', '2007-05-05', '2012-09-16');
insert into Contact_Personal values('EugeneEEarly@jourrapide.com', '402-763-5241', '1000 North Avenue', 'Omaha', 'NE', '68154', '1999-03-14', '2017-07-16', '2023-09-18');
insert into Contact_Personal values('JamesCJohnson@jourrapide.com', '612-601-1226', '4197 Palmer Road', 'Westerville', 'OH', '43081', '2002-12-19', '2019-10-12', '2021-06-05');
insert into Contact_Personal values('KathrynORideout@jourrapide.com', '775-249-3345', '3555 Rockford Road', 'Renvo', 'NV', '89501', '2001-01-14', '2010-10-12', '2016-03-15');
insert into Contact_Personal values('DennisRPaulin@rhyta.com', '724-756-5649', '1900 Platinum Drive', 'Petrolia', 'PA', '16050', '1959-07-27', '2005-02-20', '2019-09-14');
insert into Contact_Personal values('BrianMMosher@rhyta.com', '813-295-3085', '4719 Bernado Street', 'Tampa', 'FL', '33610', '1966-02-09', '2005-02-20', '2019-09-14');
insert into Contact_Personal values('EarlEGoodman@rhyta.com', '401-254-3338', '1253 Melm Street', 'Warren', 'RI', '28850', '1987-03-30', '1999-04-29', '2008-08-07');
insert into Contact_Personal values('TheresaJGalarza@armyspy.com', '786-302-7724', '3012 Ridenour Street', 'Miramar', 'FL', '33025', '1997-08-19', '2004-09-04', '2013-05-03');
insert into Contact_Personal values('AnnaRMurray@teleworm.us', '775-490-1233', '3295 Sheila Lane', 'Las Vegas', 'NV', '89101', '1989-05-07', '1999-08-09', '2019-10-19');
insert into Contact_Personal values('LoisDDexter@armyspy.com', '828-318-7515', '1346 Hannah Street', 'Asheville', 'NC', '28806', '1980-07-19', '1995-05-05', '2018-12-31');
