CREATE TABLE IF NOT EXISTS PasswordRecoveries (
	ID INT AUTO_INCREMENT PRIMARY KEY,
	user INT NOT NULL,
	password varchar(200) NOT NULL,
	verifyID varchar(200) NOT NULL,
	expirationDate DATETIME ,
	FOREIGN KEY (user) REFERENCES Users(ID) ON DELETE NO ACTION
);