CREATE TABLE "events" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "name" TEXT,
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

CREATE TABLE "users" ("uname" TEXT, "groups" INT DEFAULT 0);

CREATE TABLE "motd" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "title" TEXT,
  "content" TEXT
);

INSERT INTO
  motd (title, content)
VALUES
  (
    'MOTD ./dev.sh',
    'du kan endre motd i admin panelet'
  );

CREATE TABLE "door" ("time" INTEGER PRIMARY KEY, "open" BOOLEAN);

INSERT INTO
  door (time, open)
VALUES
  (0, FALSE);

INSERT INTO
  users (uname, groups)
VALUES
  ('min_test_bruker', 1);
