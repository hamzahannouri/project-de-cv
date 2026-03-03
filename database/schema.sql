-- database/schema.sql
CREATE DATABASE IF NOT EXISTS almassar_jobs CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE almassar_jobs;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role ENUM('candidat', 'recruteur') NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    company_name VARCHAR(150),
    siret VARCHAR(14),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recruiter_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    job_type ENUM('CDI', 'CDD', 'Freelance', 'Stage', 'Alternance') NOT NULL,
    location VARCHAR(255) NOT NULL,
    is_remote BOOLEAN DEFAULT FALSE,
    salary_range VARCHAR(100),
    status ENUM('active', 'suspended', 'closed') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (recruiter_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_id INT NOT NULL,
    candidate_id INT NOT NULL,
    resume_path VARCHAR(255) NOT NULL,
    cover_letter TEXT,
    status ENUM('pending', 'reviewed', 'accepted', 'rejected') DEFAULT 'pending',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    FOREIGN KEY (candidate_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE alerts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    candidate_id INT NOT NULL,
    keywords VARCHAR(255),
    location VARCHAR(255),
    job_type ENUM('CDI', 'CDD', 'Freelance', 'Stage', 'Alternance'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (candidate_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    job_id INT,
    content TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE SET NULL
);

-- Insert some fake data for testing
INSERT INTO users (role, email, password_hash, company_name, siret) VALUES 
('recruteur', 'contact@techcorp.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'TechCorp', '12345678901234'); -- password: password

INSERT INTO jobs (recruiter_id, title, description, job_type, location, is_remote) VALUES 
(1, 'Développeur Full-Stack PHP', 'Nous recherchons un développeur PHP passionné pour rejoindre notre équipe. Vous travaillerez sur des projets innovants.', 'CDI', 'Paris', TRUE),
(1, 'Intégrateur Web HTML/CSS', 'Poste en agence pour intégration HTML/CSS. Vous devez maîtriser les standards du web et l\'accessibilité.', 'CDD', 'Lyon', FALSE),
(1, 'Tech Lead PHP', 'Poste à responsabilités. Vous encadrerez une équipe de 5 développeurs.', 'CDI', 'Bordeaux', TRUE);
