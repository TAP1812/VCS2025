CREATE DATABASE IF NOT EXISTS student_management;

USE student_management;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
    role ENUM('teacher', 'student') NOT NULL,
    avatar VARCHAR(255)
);

CREATE TABLE assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    assignment_id INT,
    student_id INT,
    file_path VARCHAR(255) NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (assignment_id) REFERENCES assignments(id),
    FOREIGN KEY (student_id) REFERENCES users(id)
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    receiver_id INT,
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
);

CREATE TABLE challenges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hint TEXT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE challenge_status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    challenge_id INT,
    status ENUM('solved', 'not solved') DEFAULT 'not solved',
    solved_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (student_id) REFERENCES users(id),
    FOREIGN KEY (challenge_id) REFERENCES challenges(id),
    UNIQUE KEY unique_student_challenge (student_id, challenge_id)
);
-- Thêm tài khoản giáo viên 1
INSERT INTO users (username, password, fullname, email, phone, role)
VALUES (
    'teacher1',
    'f83e69e4170a786e44e3d32a2479cce9', -- Mật khẩu: 123456a@A (MD5)
    'Teacher One',
    'teacher1@example.com',
    '1234567890',
    'teacher'
);

-- Thêm tài khoản giáo viên 2
INSERT INTO users (username, password, fullname, email, phone, role)
VALUES (
    'teacher2',
    'f83e69e4170a786e44e3d32a2479cce9', -- Mật khẩu: 123456a@A (MD5)
    'Teacher Two',
    'teacher2@example.com',
    '0987654321',
    'teacher'
);

-- Thêm tài khoản sinh viên 1
INSERT INTO users (username, password, fullname, email, phone, role)
VALUES (
    'student1',
    'f83e69e4170a786e44e3d32a2479cce9', -- Mật khẩu: 123456a@A (MD5)
    'Student One',
    'student1@example.com',
    '1112223333',
    'student'
);

-- Thêm tài khoản sinh viên 2
INSERT INTO users (username, password, fullname, email, phone, role)
VALUES (
    'student2',
    'f83e69e4170a786e44e3d32a2479cce9', -- Mật khẩu: 123456a@A (MD5)
    'Student Two',
    'student2@example.com',
    '4445556666',
    'student'
);
