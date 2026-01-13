CREATE TABLE events (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` TEXT NOT NULL,
  `start` INTEGER,
  `stop` INTEGER,
  `organiser` TEXT,
  `location` TEXT,
  `description` TEXT
);

CREATE TABLE projects (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` TEXT NOT NULL,
  `description` TEXT,
  `active` BOOLEAN DEFAULT TRUE
);

CREATE TABLE projectmembers (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `projectid` INTEGER FOREIGN KEY REFERENCES projects(`id`),
  `name` TEXT NOT NULL,
  `uname` TEXT NOT NULL REFERENCES users(`uname`),
  `mail` TEXT,
  `role` TEXT,
  `lead` BOOLEAN NOT NULL DEFAULT FALSE,
  `owner` BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE users (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `uname` TEXT NOT NULL UNIQUE,
  `groups` INT NOT NULL DEFAULT 0
);

CREATE TABLE motd (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `title` TEXT NOT NULL,
  `content` TEXT NOT NULL
);

CREATE TABLE door (
  `time` DATETIME PRIMARY KEY,
  `open` BOOLEAN NOT NULL
);

INSERT INTO
  `door`(`time`, `open`)
VALUES
  (0, FALSE);
