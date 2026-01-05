-- On créer la base de données et on l'utilise
CREATE DATABASE resavelo;
USE resavelo;

-- On créer les tables
CREATE TABLE velos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(25) NOT NULL,
    price DECIMAL(6,2) NOT NULL,
    quantity INT NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    velo_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_price DECIMAL(8,2),
    status ENUM('en_attente', 'validee', 'refusee', 'annulee') DEFAULT 'en_attente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (velo_id) REFERENCES velos(id) ON DELETE CASCADE
);

-- On implante quelques données dans les différentes tables
INSERT INTO velos (name, price, quantity, description, image_url) VALUES
('Vélo City', 12.00, 5, 'Vélo confortable pour la ville', 'velo_city.jpg'),
('VTT Explorer', 18.00, 3, 'VTT pour chemins difficiles', 'vtt.jpg'),
('Vélo Électrique', 25.00, 2, 'Assistance électrique', 'velo_elec.jpg');

INSERT INTO reservations (velo_id, start_date, end_date, total_price, status) VALUES
(1, '2026-01-10', '2026-01-12', 24.00, 'validee'),
(2, '2026-01-15', '2026-01-18', 54.00, 'en_attente'),
(3, '2026-01-20', '2026-01-22', 50.00, 'annulee');


-- On vérifie si les requêtes basiques fonctionnent
SELECT * FROM velos;
SELECT * FROM reservations;