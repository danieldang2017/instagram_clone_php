CREATE TABLE IF NOT EXISTS Users (
	ID INT AUTO_INCREMENT PRIMARY KEY,
	displayName VARCHAR(50) ,
	userName VARCHAR(50) ,
	email VARCHAR(50) ,
	password VARCHAR(150) ,
	imageProfile VARCHAR(100) ,
	firstName VARCHAR(50) ,
	lastName VARCHAR(50) ,
	postsCount INT DEFAULT 0,
	followersCount INT DEFAULT 0,
	followingCount INT DEFAULT 0,
	createdDate DATETIME 
);

-- insert into Users( displayName, userName, email, password) values ('aa', 'bb', 'cc', 'dd');
-- insert into Users( displayName, userName, email, password) values ('Justin Be', 'Justin', 'a@gmail.com', '12345');   

--  insert into Users( displayName, userName, email, password, imageProfile, firstName, lastName , createdDate) values ('Justin Be', 'Justin', 'a@gmail.com', '12345', 'profile', 'firstname', 'last', now()); 