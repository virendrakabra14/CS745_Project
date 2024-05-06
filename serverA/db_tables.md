$ sudo -u postgres -i
$ psql

CREATE DATABASE bb_db;

\c bb_db

CREATE TABLE messages (
    id SERIAL PRIMARY KEY,
    user_id INT,
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255)
);
