#!/bin/bash
echo "Creating CTF database and user..."

mysql -u root -p << 'EOF'
CREATE DATABASE IF NOT EXISTS ctf_database;
CREATE USER IF NOT EXISTS 'ctf_user'@'localhost' IDENTIFIED BY 'ctf_password';
GRANT ALL PRIVILEGES ON ctf_database.* TO 'ctf_user'@'localhost';
FLUSH PRIVILEGES;
USE ctf_database;
source database/init.sql;
EOF

echo "Database setup complete!"
