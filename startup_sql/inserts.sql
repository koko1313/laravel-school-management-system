INSERT INTO roles (role)
VALUES
  ('administrator'),
  ('class teacher'),
  ('teacher'),
  ('student');

INSERT INTO administrators (username, password, role_id, allow_password_change)
VALUES ('administrator', 'password', '1', '1');

INSERT INTO terms (term, term_label, now)
VALUES
  ('1', 'Първи', '1'),
  ('2', 'Втори', '0');

INSERT INTO grades (grade, grade_label)
VALUES
  ('2', 'Слаб'),
  ('3', 'Среден'),
  ('4', 'Добър'),
  ('5', 'Много Добър'),
  ('6', 'Отличен');

INSERT INTO school (school_name, description)
VALUES ('Име на училището', 'Описание');

