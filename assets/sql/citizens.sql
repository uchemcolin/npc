CREATE TABLE IF NOT EXISTS citizens (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    gender VARCHAR(6) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone VARCHAR(11) NOT NULL,
    ward_id INT NOT NULL,
    created_at DATE NOT NULL,
    PRIMARY KEY(id)
);