CREATE VIEW teachers_subjects_view AS
SELECT
  teachers_subjects.subject_id,
  subjects.subject,
  teachers_subjects.teacher_id,
  concat(teachers.first_name, ' ', teachers.last_name) AS "teacher"
FROM teachers_subjects 
INNER JOIN teachers ON teachers_subjects.teacher_id = teachers.id
INNER JOIN subjects ON teachers_subjects.subject_id = subjects.id
ORDER BY subject, teacher;

CREATE VIEW class_teachers_view AS
SELECT
  class_teachers.class_id,
  classes.class,
  concat(classes.class, ' ', classes.class_section) AS "class_and_section",
  class_teachers.teacher_id, concat(teachers.first_name, ' ', teachers.last_name) AS "teacher"
FROM class_teachers 
INNER JOIN teachers ON class_teachers.teacher_id = teachers.id
INNER JOIN classes ON class_teachers.class_id = classes.id
ORDER BY class, teacher;

CREATE VIEW classes_view AS
SELECT
  classes.id,
  classes.class,
  classes.class_section,
  concat(classes.class, ' ', classes.class_section) AS "class_and_section",
  classes.class_teacher_id,
  concat(teachers.first_name, ' ', teachers.last_name) AS "class_teacher",
  classes.graduating_year,
  classes.is_graduated
FROM classes
LEFT JOIN teachers ON classes.class_teacher_id = teachers.id
ORDER BY class, class_section;

CREATE VIEW students_view AS
SELECT
  students.egn,
  students.first_name,
  students.second_name,
  students.last_name,
  students.class_no,
  students.class_id,
  classes.class,
  concat(classes.class, ' ', classes.class_section) AS "class_and_section",
  students.username, students.password, teachers.id AS "class_teacher_id",
  concat(teachers.first_name, ' ', teachers.last_name) AS "class_teacher",
  students.description,
  students.role_id,
  classes.graduating_year,
  classes.is_graduated
FROM students
INNER JOIN classes ON students.class_id = classes.id
LEFT JOIN teachers ON classes.class_teacher_id = teachers.id
ORDER BY class, class_no;

CREATE VIEW students_teachers_view AS
SELECT
  students.egn AS "student_egn",
  students.class_no,
  concat(students.first_name, ' ', students.second_name, ' ', students.last_name) AS "student_name",
  students.class_id,
  students.class,
  class_teachers.teacher_id
FROM students_view students, class_teachers_view class_teachers
WHERE students.class_id = class_teachers.class_id
ORDER BY class, class_no;

-- ----------------------------------

CREATE VIEW current_grades_view_not_grouped AS
SELECT
  students.egn AS "student_egn",
  concat(students.first_name, ' ', students.second_name, ' ', students.last_name) AS "student_name",
  students.class_no,
  classes.id AS "class_now_id",
  concat(classes.class, ' ', classes.class_section) AS "class_now",
  classes.class_teacher_id,
  current_grades.subject_id,
  subjects.subject,
  GROUP_CONCAT(grade_id ORDER BY current_grades.created_at ASC) AS "grade_id",
  GROUP_CONCAT(grades.grade ORDER BY current_grades.created_at ASC) AS "grade",
  current_grades.term_id,
  terms.term_label AS "term",
  current_grades.for_class,
  current_grades.teacher_id,
  concat(teachers.first_name, ' ', teachers.last_name) AS "teacher",
  GROUP_CONCAT(current_grades.created_at ORDER BY current_grades.created_at ASC) AS "created_at"
FROM current_grades
INNER JOIN students ON current_grades.student_egn = students.egn
INNER JOIN classes ON students.class_id = classes.id
INNER JOIN subjects ON current_grades.subject_id = subjects.id
INNER JOIN grades ON current_grades.grade_id = grades.id
INNER JOIN terms ON current_grades.term_id = terms.id
INNER JOIN teachers ON current_grades.teacher_id = teachers.id
GROUP BY current_grades.student_egn, subjects.subject, term_id, for_class

UNION

SELECT
  students.egn,
  concat(students.first_name, ' ', students.second_name, ' ', students.last_name) AS "student_name",
  class_no,
  students.class_id,
  concat(classes.class, ' ', classes.class_section),
  classes.class_teacher_id,
  subjects.id,
  subjects.subject,
  null,
  null,
  terms.term,
  terms.term_label,
  classes.class, -- "for_class"
  null,
  null,
  null
FROM subjects, terms, students, classes;

CREATE VIEW current_grades_view AS
SELECT * FROM current_grades_view_not_grouped
GROUP BY student_egn, subject_id, term_id, for_class;

-- --

CREATE VIEW term_grades_view_not_grouped AS
SELECT
  students.egn AS "student_egn",
  concat(students.first_name, ' ', students.second_name, ' ', students.last_name) AS "student_name",
  students.class_no,
  classes.id AS "class_now_id",
  concat(classes.class, ' ', classes.class_section) AS "class_now",
  classes.class_teacher_id,
  term_grades.subject_id,
  subjects.subject,
  grade_id,
  grades.grade,
  term_grades.term_id,
  terms.term_label,
  term_grades.for_class,
  term_grades.teacher_id,
  concat(teachers.first_name, ' ', teachers.last_name) AS "teacher",
  term_grades.created_at
FROM term_grades
INNER JOIN students ON term_grades.student_egn = students.egn
INNER JOIN classes ON students.class_id = classes.id
INNER JOIN subjects ON term_grades.subject_id = subjects.id
INNER JOIN grades ON term_grades.grade_id = grades.id
INNER JOIN terms ON term_grades.term_id = terms.id
INNER JOIN teachers teachers ON term_grades.teacher_id = teachers.id

UNION

SELECT
  students.egn,
  concat(students.first_name, ' ', students.second_name, ' ', students.last_name) AS "student_name",
  class_no,
  students.class_id,
  concat(classes.class, ' ', classes.class_section),
  classes.class_teacher_id,
  subjects.id,
  subjects.subject,
  null,
  null,
  terms.term,
  terms.term_label,
  classes.class, -- "for_class"
  null,
  null,
  null
FROM subjects, terms, students, classes;

CREATE VIEW term_grades_view AS
SELECT * FROM term_grades_view_not_grouped
GROUP BY student_egn, subject_id, term_id, for_class;

-- --

CREATE VIEW session_grades_view_not_grouped AS
SELECT
  students.egn AS "student_egn",
  concat(students.first_name, ' ', students.second_name, ' ', students.last_name) AS "student_name",
  students.class_no,
  classes.id AS "class_now_id",
  concat(classes.class, ' ', classes.class_section) AS "class_now",
  classes.class_teacher_id,
  session_grades.subject_id,
  subjects.subject,
  grade_id,
  grades.grade,
  session_grades.for_class,
  session_grades.teacher_id,
  concat(teachers.first_name, ' ', teachers.last_name) AS "teacher",
  session_grades.created_at
FROM session_grades
INNER JOIN students ON session_grades.student_egn = students.egn
INNER JOIN classes ON session_grades.class_teacher_id = classes.class_teacher_id
INNER JOIN subjects ON session_grades.subject_id = subjects.id
INNER JOIN grades ON session_grades.grade_id = grades.id
INNER JOIN teachers ON session_grades.teacher_id = teachers.id

UNION

SELECT
  students.egn,
  concat(students.first_name, ' ', students.second_name, ' ', students.last_name) AS "student_name",
  class_no,
  students.class_id,
  concat(classes.class, ' ', classes.class_section),
  classes.class_teacher_id,
  subjects.id,
  subjects.subject,
  null,
  null,
  classes.class, -- "for_class"
  null,
  null,
  null
FROM subjects, terms, students, classes;

CREATE VIEW session_grades_view AS
SELECT * FROM session_grades_view_not_grouped
GROUP BY student_egn, subject_id, for_class;

-- -------------------------------------