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
  `description` TEXT,
  `active` BOOLEAN DEFAULT TRUE
);

CREATE TABLE projectmembers (
  `projectid` INTEGER,
  `name` TEXT,
  `uname` TEXT,
  `mail` TEXT,
  `role` TEXT,
  `lead` BOOLEAN DEFAULT FALSE,
  `owner` BOOLEAN DEFAULT FALSE
);

CREATE TABLE users (`uname` TEXT, `groups` INT DEFAULT 0);

CREATE TABLE motd (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `title` TEXT,
  `content` TEXT
);

/*
INSERT INTO motd (title, content)
VALUES ("MOTD ./dev.sh", "du kan endre motd i admin panelet");
*/
CREATE TABLE door (`time` INTEGER PRIMARY KEY, `open` BOOLEAN);

INSERT INTO
  door (time, open)
VALUES
  (0, FALSE);
