CREATE TABLE "events" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "name" TEXT NOT NULL,
  "start" TEXT,
  "stop" TEXT,
  "organiser" TEXT,
  "location" TEXT,
  "description" TEXT
);

-- PROJECTS

CREATE TABLE "project_group" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "title" TEXT NOT NULL,
  "description_en" TEXT NOT NULL,
  "description_no" TEXT NOT NULL,
  "gitea_link" TEXT NOT NULL,
  "wiki_link" TEXT
);

INSERT INTO
  project_group (title, description_en, description_no, gitea_link, wiki_link)
VALUES
  (
    'Projects',
    'Projects developed by members of PVV.',
    'Prosjekter utviklet av medlemmer i PVV.',
    'https://git.pvv.ntnu.no/Projects',
    'https://wiki.pvv.ntnu.no/wiki/Programvareutvikling'
  );

CREATE TABLE "project" (
  "id" INTEGER PRIMARY KEY AUTOINCREMENT,
  "group_id" INTEGER NOT NULL DEFAULT 1,
  "title" TEXT NOT NULL,
  "description_en" TEXT NOT NULL,
  "description_no" TEXT NOT NULL,
  "gitea_link" TEXT,
  "issue_board_link" TEXT,
  "wiki_link" TEXT,
  "programming_languages" TEXT,
  "technologies" TEXT,
  "keywords" TEXT,
  "license" TEXT,
  "logo_url" TEXT,
  "is_hidden" BOOLEAN DEFAULT FALSE,
  FOREIGN KEY (group_id) REFERENCES project_group (id) ON DELETE SET DEFAULT
);

CREATE TABLE "project_maintainer" (
  "uname" TEXT NOT NULL,
  "project_id" INTEGER NOT NULL,
  "name" TEXT NOT NULL,
  "email" TEXT,
  "is_organizer" BOOLEAN DEFAULT FALSE,
  PRIMARY KEY (uname, project_id),
  FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE
);

--

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
