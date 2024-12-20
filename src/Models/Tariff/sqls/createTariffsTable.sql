CREATE TABLE IF NOT EXISTS tariffs
(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT UNUQUE NOT NULL,
    description TEXT,
    price REAL NOT NULL,
    created_at TEXT NOT NULL,
    expires_at TEXT NOT NULL,
    logo TEXT
)
