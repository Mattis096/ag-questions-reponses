CREATE TABLE questions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,

    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    email TEXT NOT NULL,

    club TEXT NOT NULL,
    club_function TEXT,

    department TEXT NOT NULL,
    department_function TEXT,

    region TEXT NOT NULL,
    region_function TEXT,

    question_1 TEXT NOT NULL,
    question_2 TEXT,
    question_3 TEXT,

    created_at TEXT NOT NULL
);