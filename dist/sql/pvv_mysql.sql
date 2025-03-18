CREATE TABLE events (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `name` TEXT NOT NULL,
  `start` INTEGER,
  `stop` INTEGER,
  `organiser` TEXT,
  `location` TEXT,
  `description` TEXT
);

CREATE TABLE project_group (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `title` TEXT NOT NULL,
  `description_en` TEXT NOT NULL,
  `description_no` TEXT NOT NULL,
  `gitea_link` TEXT NOT NULL,
  `wiki_link` TEXT
);

CREATE TABLE project (
  `id` INTEGER PRIMARY KEY AUTO_INCREMENT,
  `group_id` INTEGER NOT NULL REFERENCES project_group (id),
  `title` TEXT NOT NULL,
  `description_en` TEXT NOT NULL,
  `description_no` TEXT NOT NULL,
  `gitea_link` TEXT NOT NULL,
  `issue_board_link` TEXT NOT NULL,
  `wiki_link` TEXT,
  `languages` TEXT,
  `technologies` TEXT,
  `keywords` TEXT,
  `license` TEXT,
  `logo_url` TEXT,
  FOREIGN KEY (group_id) REFERENCES project_group (id)
);

CREATE TABLE project_maintainer (
  `uname` TEXT PRIMARY KEY,
  `name` TEXT NOT NULL,
  `link` TEXT NOT NULL,
  `mail` TEXT NOT NULL,
  FOREIGN KEY (project_id) REFERENCES project (id),
  FOREIGN KEY (uname) REFERENCES maintainer (uname),
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
