-- CREATE DATABASE school_management_system;
-- USE school_management_system;

-- --------------------------------------------------------

/*
DELIMITER $$
CREATE FUNCTION username_exist (username varchar(255))
RETURNS tinyint
DETERMINISTIC
BEGIN
  DECLARE rows_count int;
  SET rows_count = (SELECT COUNT(*) FROM administrator WHERE administrator.username = username) +
      (SELECT COUNT(*) FROM teachers WHERE teachers.username = username) +
      (SELECT COUNT(*) FROM students WHERE students.username = username);
  RETURN rows_count;
END$$
DELIMITER ;
*/

-- --------------------------------------------------------
CREATE TABLE roles (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  role varchar(50) NOT NULL,
  created_at datetime NOT NULL,
  updated_at datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE terms (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  term tinyint(4) NOT NULL,
  term_label varchar(50) NOT NULL,
  now tinyint(1) NOT NULL CHECK (now IN (0, 1)),
  created_at datetime NOT NULL,
  updated_at datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE grades (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  grade tinyint(4) NOT NULL,
  grade_label varchar(50) NOT NULL,
  created_at datetime NOT NULL,
  updated_at datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE school (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  school_name varchar(100),
  description varchar(500),
  created_at datetime NOT NULL,
  updated_at datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE administrators (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username varchar(50) NOT NULL UNIQUE,
  password varchar(255) NOT NULL,
  role_id int(11) UNSIGNED NOT NULL,
  allow_password_change tinyint(1) NOT NULL,
  remember_token varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  created_at datetime NOT NULL,
  updated_at datetime NOT NULL,
  FOREIGN KEY (role_id) REFERENCES roles(id) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE teachers (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  first_name varchar(50) NOT NULL,
  last_name varchar(50) NOT NULL,
  username varchar(50) NOT NULL UNIQUE,
  password varchar(50) NOT NULL,
  role_id int(11) UNSIGNED NOT NULL,
  remember_token varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  created_at datetime NOT NULL,
  updated_at datetime NOT NULL,
  UNIQUE (first_name,last_name),
  FOREIGN KEY (role_id) REFERENCES roles (id) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE subjects (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  subject varchar(100) NOT NULL UNIQUE,
  created_at datetime NOT NULL,
  updated_at datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE teachers_subjects (
  teacher_id int(11) UNSIGNED NOT NULL,
  subject_id int(11) UNSIGNED NOT NULL,
  created_at datetime NOT NULL,
  updated_at datetime NOT NULL,
  UNIQUE (teacher_id,subject_id),
  FOREIGN KEY (teacher_id) REFERENCES teachers (id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (subject_id) REFERENCES subjects (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE classes (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  class tinyint(4),
  class_section varchar(2) DEFAULT NULL,
  class_teacher_id int(11) UNSIGNED DEFAULT NULL,
  graduating_year varchar(4),
  is_graduated boolean DEFAULT false,
  created_at datetime NOT NULL,
  updated_at datetime NOT NULL,
  UNIQUE (class, class_section, graduating_year),
  FOREIGN KEY (class_teacher_id) REFERENCES teachers (id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE class_teachers (
  class_id int(11) UNSIGNED NOT NULL,
  teacher_id int(11) UNSIGNED NOT NULL,
  created_at datetime NOT NULL,
  updated_at datetime NOT NULL,
  UNIQUE (class_id,teacher_id),
  FOREIGN KEY (class_id) REFERENCES classes (id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (teacher_id) REFERENCES teachers (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE students (
  egn varchar(10) NOT NULL UNIQUE,
  first_name varchar(50) NOT NULL,
  second_name varchar(50) NOT NULL,
  last_name varchar(50) NOT NULL,
  class_no tinyint(4) NOT NULL,
  class_id int(11) UNSIGNED NOT NULL,
  description varchar(500) DEFAULT NULL,
  username varchar(50) NOT NULL UNIQUE,
  password varchar(50) NOT NULL,
  role_id int(11) UNSIGNED NOT NULL,
  remember_token varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  created_at datetime NOT NULL,
  updated_at datetime NOT NULL,
  UNIQUE (class_no,class_id),
  FOREIGN KEY (class_id) REFERENCES classes (id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (role_id) REFERENCES roles (id) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE current_grades (
  student_egn varchar(10) NOT NULL,
  subject_id int(11) UNSIGNED NOT NULL,
  grade_id int(11) UNSIGNED NOT NULL,
  term_id int(11) UNSIGNED NOT NULL,
  for_class tinyint(2) NOT NULL,
  teacher_id int(11) UNSIGNED NOT NULL,
  created_at datetime NOT NULL,
  updated_at datetime NOT NULL,
  FOREIGN KEY (student_egn) REFERENCES students (egn) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (grade_id) REFERENCES grades (id) ON UPDATE CASCADE,
  FOREIGN KEY (term_id) REFERENCES terms (id) ON UPDATE CASCADE,
  FOREIGN KEY (subject_id) REFERENCES subjects (id) ON UPDATE CASCADE,
  FOREIGN KEY (teacher_id) REFERENCES teachers (id) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE term_grades (
  student_egn varchar(10) NOT NULL,
  subject_id int(11) UNSIGNED NOT NULL,
  grade_id int(11) UNSIGNED NOT NULL,
  term_id int(11) UNSIGNED NOT NULL,
  for_class tinyint(2) NOT NULL,
  teacher_id int(11) UNSIGNED NOT NULL,
  created_at datetime NOT NULL,
  updated_at datetime NOT NULL,
  UNIQUE (student_egn,subject_id,term_id, for_class),
  FOREIGN KEY (student_egn) REFERENCES students (egn) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (grade_id) REFERENCES grades (id) ON UPDATE CASCADE,
  FOREIGN KEY (subject_id) REFERENCES subjects (id) ON UPDATE CASCADE,
  FOREIGN KEY (term_id) REFERENCES terms (id) ON UPDATE CASCADE,
  FOREIGN KEY (teacher_id) REFERENCES teachers (id) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE session_grades (
  student_egn varchar(10) NOT NULL,
  subject_id int(11) UNSIGNED NOT NULL,
  grade_id int(11) UNSIGNED NOT NULL,
  for_class tinyint(2) NOT NULL,
  teacher_id int(11) UNSIGNED NOT NULL,
  class_teacher_id int(11) UNSIGNED,
  created_at datetime NOT NULL,
  updated_at datetime NOT NULL,
  UNIQUE (student_egn,subject_id,for_class),
  FOREIGN KEY (student_egn) REFERENCES students (egn) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (grade_id) REFERENCES grades (id) ON UPDATE CASCADE,
  FOREIGN KEY (subject_id) REFERENCES subjects (id) ON UPDATE CASCADE,
  FOREIGN KEY (teacher_id) REFERENCES teachers (id) ON UPDATE CASCADE,
  FOREIGN KEY (class_teacher_id) REFERENCES classes (class_teacher_id) ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
  

