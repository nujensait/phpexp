CREATE TABLE orders (
                        id VARCHAR(20) NOT NULL PRIMARY KEY,
                        sum  INT DEFAULT 0,
                        contractor_type SMALLINT,
                        is_paid SMALLINT DEFAULT 0,
                        createdAt TIMESTAMP DEFAULT NOW()
) CHARACTER SET utf8 COLLATE utf8_general_ci engine MyISAM;

CREATE TABLE order_products (
                                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                order_id VARCHAR(20),
                                product_id INT,
                                price INT DEFAULT 0,
                                quantity INT DEFAULT 1,
                                FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL
) CHARACTER SET utf8 COLLATE utf8_general_ci  engine MyISAM;