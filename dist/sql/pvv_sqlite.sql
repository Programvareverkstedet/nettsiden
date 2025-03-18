CREATE TABLE "events" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "name" TEXT NOT NULL,
  "start" TEXT,
  "stop" TEXT,
  "organiser" TEXT,
  "location" TEXT,
  "description" TEXT
);

CREATE TABLE "project_group" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "title" TEXT NOT NULL,
  "description_en" TEXT NOT NULL,
  "description_no" TEXT NOT NULL,
  "gitea_link" TEXT NOT NULL,
  "wiki_link" TEXT
);

CREATE TABLE "project" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "group_id" INTEGER NOT NULL REFERENCES project_group (id),
  "title" TEXT NOT NULL,
  "description_en" TEXT NOT NULL,
  "description_no" TEXT NOT NULL,
  "gitea_link" TEXT NOT NULL,
  "issue_board_link" TEXT NOT NULL,
  "wiki_link" TEXT,
  "languages" TEXT,
  "technologies" TEXT,
  "keywords" TEXT,
  "license" TEXT,
  "logo_url" TEXT
);

CREATE TABLE "project_maintainer" (
  "uname" TEXT PRIMARY KEY,
  "name" TEXT NOT NULL,
  "link" TEXT NOT NULL,
  "mail" TEXT NOT NULL
);

CREATE TABLE "project__project_maintainer" (
  "project_id" INTEGER REFERENCES project (id),
  "uname" TEXT REFERENCES maintainer (uname),
  PRIMARY KEY (project_id, uname)
);

CREATE TABLE "users" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "uname" TEXT NOT NULL UNIQUE,
  "groups" INT NOT NULL DEFAULT 0
);

CREATE TABLE "motd" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "title" TEXT NOT NULL,
  "content" TEXT NOT NULL
);

CREATE TABLE "door" (
  "time" INTEGER PRIMARY KEY,
  "open" BOOLEAN NOT NULL
);
