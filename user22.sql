
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    fio VARCHAR(255),
    phone VARCHAR(20),
    email VARCHAR(100),
    is_admin TINYINT DEFAULT 0
);

CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    type VARCHAR(50)
);

CREATE TABLE requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    room_id INT,
    date_start DATETIME,
    payment_method VARCHAR(50),
    status VARCHAR(50) DEFAULT 'Новая',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    request_id INT,
    text TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO rooms (name, type) VALUES 
('Аудитория А1', 'аудитория'),
('Аудитория Б2', 'аудитория'),
('Коворкинг К1', 'коворкинг'),
('Коворкинг К2', 'коворкинг'),
('Кинозал М1', 'кинозал');

INSERT INTO users (login, password, fio, phone, email, is_admin) VALUES 
('Admin26', 'Demo20', 'Администратор', '+79999999999', 'admin@conf.ru', 1);