CREATE DATABASE Payment_System;

USE Payment_System;
CREATE TABLE customert(id INT PRIMARY KEY AUTO_INCREMENT, name VARCHAR(55), email VARCHAR(55));

CREATE TABLE orders(id INT PRIMARY KEY AUTO_INCREMENT, total_amount FLOAT, status ENUM('Pending', 'Completed', 'Cancelled'), customert_id INT, FOREIGN KEY(customert_id) REFERENCES customert(id));

CREATE TABLE paiement(id INT PRIMARY KEY AUTO_INCREMENT, amount FLOAT , status ENUM('Pending', 'Completed', 'Failed'), datePaiement DATETIME DEFAULT CURRENT_TIMESTAMP, order_id INT , FOREIGN KEY(order_id) REFERENCES orders (id));

CREATE TABLE carte_bancaire(paiemrnt_id INT PRIMARY KEY, FOREIGN KEY(paiemrnt_id) REFERENCES paiement(id));

CREATE TABLE paypal(paiemrnt_id INT PRIMARY KEY, FOREIGN KEY(paiemrnt_id) REFERENCES paiement(id));

CREATE TABLE virement(paiemrnt_id INT PRIMARY KEY, FOREIGN KEY(paiemrnt_id) REFERENCES paiement(id));



