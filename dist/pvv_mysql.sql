CREATE TABLE events (
`id` INTEGER PRIMARY KEY AUTO_INCREMENT,
`name` TEXT,
`start` TEXT,
`stop` TEXT,
`organiser` TEXT,
`location` TEXT,
`description` TEXT
);

CREATE TABLE projects ( 
`id` INTEGER PRIMARY KEY AUTO_INCREMENT,
`name` TEXT,
`owner` TEXT,
`owneruname` TEXT,
`description` TEXT,
`active` BOOLEAN
);

CREATE TABLE users (
`uname` TEXT,
`groups` INT DEFAULT 0
);