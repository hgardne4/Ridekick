USE ridekick;

LOAD DATA INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/passenger.csv'
	INTO TABLE passenger
	FIELDS TERMINATED BY ','
	IGNORE 1 rows;

LOAD DATA INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/service.csv'
	INTO TABLE service
	FIELDS TERMINATED BY ','
	IGNORE 1 rows;

LOAD DATA INFILE 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/delay.csv'
	INTO TABLE delay
	FIELDS TERMINATED BY ','
	IGNORE 1 rows;