<?php
// Database initialization script
$servername = "localhost";
$username = "ctf_user";
$password = "ctf_password";
$dbname = "ctf_database";

try {
    // Create connection
    $pdo = new PDO("mysql:host=$servername", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    echo "Database created successfully<br>";
    
    // Select database
    $pdo->exec("USE $dbname");
    
    // Create users table
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100),
        role VARCHAR(20) DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "Table users created successfully<br>";
    
    // Insert sample data
    $users = [
        ['admin', 'admin123', 'admin@securefile.com', 'admin'],
        ['filemanager', 'fm_pass2024', 'filemanager@securefile.com', 'user'],
        ['testuser', 'testpass', 'test@securefile.com', 'user'],
        ['guest', 'guestaccess', 'guest@securefile.com', 'guest'],
        ['ctfuser', 'ctf_challenge_pwd', 'ctf@securefile.com', 'user']
    ];
    
    foreach ($users as $user) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
        $stmt->execute($user);
    }
    
    echo "Sample users inserted successfully<br>";
    
    // Create additional table with sensitive information
    $sql = "CREATE TABLE IF NOT EXISTS system_config (
        id INT AUTO_INCREMENT PRIMARY KEY,
        config_key VARCHAR(100) NOT NULL,
        config_value TEXT NOT NULL,
        description TEXT
    )";
    
    $pdo->exec($sql);
    
    // Insert sensitive configuration data
    $configs = [
        ['ssh_username', 'ctfuser', 'SSH username for system access'],
        ['ssh_password', 'SecretPassword123!', 'SSH password for system access'],
        ['admin_panel_url', '/admin_panel_secret/', 'Hidden admin panel location'],
        ['backup_location', '/var/backups/system/', 'System backup directory'],
        ['flag_stage2', 'CTF{sql_injection_database_dumped}', 'Flag for SQL injection stage']
    ];
    
    foreach ($configs as $config) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO system_config (config_key, config_value, description) VALUES (?, ?, ?)");
        $stmt->execute($config);
    }
    
    echo "System configuration inserted successfully<br>";
    
    echo "<h2>Database initialized! You can now delete this file.</h2>";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
