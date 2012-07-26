CREATE TABLE logs (
    id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    datetime INTEGER NOT NULL,
    monitor_type INTEGER NOT NULL,
    specification TEXT NOT NULL,
    parameters TEXT NOT NULL,
    result_info TEXT NOT NULL,
    result_code INTEGER NOT NULL
);
