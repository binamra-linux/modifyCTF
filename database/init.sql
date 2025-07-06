-- CTF Database initialization
CREATE DATABASE IF NOT EXISTS ctf_database;
USE ctf_database;

-- Users table for login
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    role VARCHAR(20) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert vulnerable user accounts
INSERT IGNORE INTO users (username, password, email, role) VALUES

('filemanager', 'fm_pass2024', 'filemanager@securefile.com', 'user'),
('testuser', 'testpass', 'test@securefile.com', 'user'),
('guest', 'guestaccess', 'guest@securefile.com', 'user'),


-- System configuration table with sensitive data
CREATE TABLE IF NOT EXISTS system_config (
    id INT AUTO_INCREMENT PRIMARY KEY,
    config_key VARCHAR(100) NOT NULL,
    config_value TEXT NOT NULL,
    description TEXT
);

-- Insert sensitive configuration (discoverable via SQLi)
INSERT IGNORE INTO system_config (config_key, config_value, description) VALUES
('ssh_username', 'ctfuser', 'SSH username for system access'),
('ssh_password', 'SecretPassword123!', 'SSH password for system access'),
('admin_panel_url', '/admin_panel_secret/', 'Hidden admin panel location'),
('backup_location', '/var/backups/system/', 'System backup directory'),
('tmux_session_file', '/home/ctfuser/.tmux_session_restore', 'Tmux session restoration script'),
('flag_stage2', 'CTF{sql_injection_database_dumped}', 'Flag for SQL injection stage'),
('initial_access_flag', 'CTF{initial_user_access_via_tmux}', 'Flag for initial user access');

-- Additional table with user privileges  
CREATE TABLE IF NOT EXISTS user_privileges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    privilege_name VARCHAR(100),
    privilege_value VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert privilege data
INSERT IGNORE INTO user_privileges (user_id, privilege_name, privilege_value) VALUES
(1, 'admin_access', 'full'),
(2, 'file_management', 'read_write'),
(5, 'ssh_access', 'enabled');
