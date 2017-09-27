CREATE TABLE IF NOT EXISTS Users (
	ID INT AUTO_INCREMENT PRIMARY KEY,
	displayName VARCHAR(50) NOT NULL,
	userName VARCHAR(50) NOT NULL,
	email VARCHAR(50) NOT NULL,
	password VARCHAR(200) NOT NULL,
	imageProfile VARCHAR(50) ,
	firstName VARCHAR(50) NOT NULL,
	lastName VARCHAR(50) NOT NULL,
	postsCount INT DEFAULT 0,
	followersCount INT DEFAULT 0,
	followingCount INT DEFAULT 0,
	createdDate DATETIME NOT NULL
);