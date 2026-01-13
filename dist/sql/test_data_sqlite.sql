
-- See users in ../authsources.php
INSERT INTO
  "users"("uname", "groups")
VALUES
  ('admin', 1 | 2 | 4),
  ('user', 0);

INSERT INTO
  "motd"("title", "content")
VALUES
  (
    'MOTD ./dev.sh',
    'du kan endre motd i admin panelet'
  );
