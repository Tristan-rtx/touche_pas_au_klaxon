USE covoiturage_ce;

-- 1. Insertion des agences
INSERT INTO agence (nom_agence) VALUES
('Paris'), ('Lyon'), ('Marseille'), ('Toulouse'), ('Nice'), 
('Nantes'), ('Strasbourg'), ('Montpellier'), ('Bordeaux'), 
('Lille'), ('Rennes'), ('Reims');

-- 2. Insertion de l'administrateur --Le mot de passe de l'admin est admin123
INSERT INTO utilisateur (nom, prenom, telephone, email, mot_de_passe, role) VALUES
('Admin', 'Super', '0102030405', 'admin@entreprise.fr', '$2y$10$wYwK9p5M.052I.H51mP73O6qUo81.p9.KIfEezm6P3uT1l9eLXZC2', 'ROLE_ADMIN');

-- 3. Insertion des employés depuis le système RH --Le mot de passe de tous les employés est password
INSERT INTO utilisateur (nom, prenom, telephone, email, mot_de_passe, role) VALUES
('Martin', 'Alexandre', '0612345678', 'alexandre.martin@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Dubois', 'Sophie', '0698765432', 'sophie.dubois@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Bernard', 'Julien', '0622446688', 'julien.bernard@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Moreau', 'Camille', '0611223344', 'camille.moreau@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Lefèvre', 'Lucie', '0777889900', 'lucie.lefevre@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Leroy', 'Thomas', '0655443322', 'thomas.leroy@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Roux', 'Chloé', '0633221199', 'chloe.roux@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Petit', 'Maxime', '0766778899', 'maxime.petit@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Garnier', 'Laura', '0688776655', 'laura.garnier@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Dupuis', 'Antoine', '0744556677', 'antoine.dupuis@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Lefebvre', 'Emma', '0699887766', 'emma.lefebvre@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Fontaine', 'Louis', '0655667788', 'louis.fontaine@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Chevalier', 'Clara', '0788990011', 'clara.chevalier@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Robin', 'Nicolas', '0644332211', 'nicolas.robin@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Gauthier', 'Marine', '0677889922', 'marine.gauthier@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Fournier', 'Pierre', '0722334455', 'pierre.fournier@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Girard', 'Sarah', '0688665544', 'sarah.girard@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Lambert', 'Hugo', '0611223366', 'hugo.lambert@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Masson', 'Julie', '0733445566', 'julie.masson@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER'),
('Henry', 'Arthur', '0666554433', 'arthur.henry@email.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ROLE_USER');