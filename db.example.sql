-- Sanitized example database for nette-blog.
-- Contains fake users only. Do not commit production dumps.

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  role INT NOT NULL DEFAULT 0
);

INSERT INTO users (id, username, password, email, role) VALUES
(1, 'demo', '$2y$10$exampleexampleexampleexampleexampleexampleexampleexampleex', 'demo@example.test', 0);
