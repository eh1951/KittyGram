CREATE TABLE IF NOT EXISTS KG_users (
	userID int(4) NOT NULL AUTO_INCREMENT,
	fName varchar(20) NOT NULL,
	lName varchar(30) NOT NULL,
	email varchar(30) NOT NULL,
	address varchar(60) NOT NULL,
	password varchar(150) NOT NULL,
	gender varchar(10),
	PRIMARY KEY (userID),
	UNIQUE KEY email (email)
)	ENGINE=InnoDB DEFAULT CHARSET=utf8;