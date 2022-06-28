CREATE TABLE locations (
  item_number VARCHAR(20) NOT NULL PRIMARY KEY,
  location VARCHAR(7) NOT NULL
);

CREATE TABLE orders (
  id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
  invoice VARCHAR(20) NOT NULL,
  item_number VARCHAR(20) NOT NULL,
  amount INTEGER NOT NULL
);

INSERT INTO locations (
  item_number,
  location
) VALUES (
  "Z123456      0000001",
  "B123456"
);

INSERT INTO locations (
  item_number,
  location
) VALUES (
  "Z135791      0000001",
  "B246810"
);

INSERT INTO orders (
  invoice,
  item_number,
  amount
) VALUES (
  "1234567890",
  "Z135791      0000001",
  1
);

INSERT INTO orders (
  invoice,
  item_number,
  amount
) VALUES (
  "1234567890",
  "Z123456      0000001",
  2
);

INSERT INTO orders (
  invoice,
  item_number,
  amount
) VALUES (
  "9876543210",
  "Z123456      0000001",
  1
);
