CREATE TABLE IF NOT EXISTS lgas (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    state_id INT NOT NULL,
    created_at DATE NOT NULL,
    PRIMARY KEY(id)
);