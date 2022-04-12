CREATE DATABASE ridekick;
USE ridekick;

CREATE TABLE passenger (
	pid INT,
	fName VARCHAR(20),
	lName VARCHAR(20),
	nApp INT NOT NULL DEFAULT 0,
    PRIMARY KEY (pid)
);

CREATE TABLE appointment (
	date DATE NOT NULL,
	time TIME NOT NULL,
	aid INT,
	isfor_sid INT NOT NULL,
	schedules_pid INT NOT NULL,
    PRIMARY KEY (aid),
    FOREIGN KEY (isfor_sid) REFERENCES service(sid),
    FOREIGN KEY (schedules_pid) REFERENCES passenger(pid)
);

CREATE TABLE service (
	sid INT,
    startL VARCHAR(20) NOT NULL,
    endL VARCHAR(20) NOT NULL,
    isactive BOOLEAN NOT NULL DEFAULT false,
    napp INT NOT NULL DEFAULT 0 CHECK (napp <= nseats),
    nseats INT NOT NULL,
    deptime TIME NOT NULL,
    date DATE NOT NULL,
    PRIMARY KEY (sid)
);

CREATE TABLE delay (
	reporttime TIME,
    length INT,
    experience_sid INT NOT NULL,
    PRIMARY KEY (reporttime),
    FOREIGN KEY (experience_sid) REFERENCES service(sid)
);
	
