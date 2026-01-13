CREATE TABLE events (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` TEXT NOT NULL,
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
  `projectid` INTEGER FOREIGN KEY REFERENCES projects(id),
  `name` TEXT,
  `uname` TEXT,
  `mail` TEXT,
  `role` TEXT,
  `lead` BOOLEAN DEFAULT FALSE,
  `owner` BOOLEAN DEFAULT FALSE
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
  `time` INTEGER PRIMARY KEY,
  `open` BOOLEAN NOT NULL
);

INSERT INTO
  door (time, open)
VALUES
  (0, FALSE);
