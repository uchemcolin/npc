CREATE TABLE IF NOT EXISTS company_admins (
    id INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(6) NOT NULL,
    created_at DATE NOT NULL,
    PRIMARY KEY(id)
);