-- ------------------------------------------
-- Cancellazione tabelle precedenti
-- ------------------------------------------

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS USERS;
DROP TABLE IF EXISTS ROLES;
DROP TABLE IF EXISTS USER_ROLES;
DROP TABLE IF EXISTS TOPICS;
DROP TABLE IF EXISTS SUBTOPICS;
DROP TABLE IF EXISTS ARTICLES;
DROP TABLE IF EXISTS COMMENTS;
DROP TABLE IF EXISTS COMMENTS_VOTES;

SET FOREIGN_KEY_CHECKS=1;

-- ------------------------------------------
-- Creazione Tabelle
-- ------------------------------------------

CREATE TABLE USERS(
    Email varchar(100) PRIMARY KEY,
    Nickname varchar(100) UNIQUE,
    Password varchar(255),
    Name varchar(100) NOT NULL,
    Surname varchar(100) NOT NULL,
    ProfilePic varchar(255)
) ENGINE=InnoDB;

CREATE TABLE ROLES(
    RoleName varchar(100) PRIMARY KEY
) ENGINE=InnoDB;

CREATE TABLE USER_ROLES(
    UserID varchar(100) REFERENCES USERS(Email) ON UPDATE CASCADE ON DELETE CASCADE,
    RoleName varchar(100) REFERENCES ROLES(RoleName) ON UPDATE CASCADE ON DELETE CASCADE,
    PRIMARY KEY (UserID,RoleName)
) ENGINE=InnoDB;

CREATE TABLE TOPICS(
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Name varchar(100),
    Description MEDIUMTEXT,
    ImageLink varchar(255)
) ENGINE=InnoDB;

CREATE TABLE SUBTOPICS(
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Title varchar(100),
    TopicID INT REFERENCES TOPICS(Id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE ARTICLES(
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Title varchar(100) NOT NULL,
    HTMLCode LONGTEXT NOT NULL,
    AuthorID varchar(100) REFERENCES USERS(Email) ON UPDATE CASCADE ON DELETE CASCADE,
    SubtopicID INT REFERENCES SUBTOPICS(Id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE COMMENTS(
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Text LONGTEXT NOT NULL,
    AuthorID varchar(100) REFERENCES USERS(Email) ON UPDATE CASCADE ON DELETE CASCADE,
    ArticleID INT REFERENCES ARTICLES(Id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE COMMENTS_VOTES(
    CommentID INT REFERENCES COMMENTS(Id) ON UPDATE CASCADE ON DELETE CASCADE,
    AuthorID varchar(100) REFERENCES USERS(Email) ON UPDATE CASCADE ON DELETE CASCADE,
    is_like BOOLEAN,
    PRIMARY KEY (CommentID,AuthorID)
) ENGINE=InnoDB;

-- ------------------------------------------
-- Inserimento dati di test nel database
-- ------------------------------------------

INSERT INTO USERS (Email, Nickname, Password, Name, Surname, ProfilePic) VALUES
    ('user@user.com', 'User', 'User', 'User Test', '1', 'https://frncscdf.github.io/Tecnologie-Web/img/coding.svg'),
    ('user2@user.com', 'User2', 'User', 'User Test', '2', 'https://frncscdf.github.io/Tecnologie-Web/img/coding.svg'),
    ('admin@admin.com', 'Admin', 'Admin', 'Admin Test', '1', 'https://frncscdf.github.io/Tecnologie-Web/img/coding.svg');

INSERT INTO ROLES (RoleName) VALUES
    ('Normal User'), ('Admin User');

INSERT INTO USER_ROLES (UserID, RoleName) VALUES
    ('user@user.com', 'Normal User'),
    ('user2@user.com', 'Normal User'),
    ('admin@admin.com', 'Admin User');

INSERT INTO TOPICS (Name, Image) VALUES
    ('Algoritmi', "Descrizione Lunga Topic Algoritmi",  NULL),
    ('Sistemi Operativi', "Descrizione Lunga Topic Sistemi Operativi", NULL),
    ('Architettura degli Elaboratori', "Descrizione Lunga Topic Architettura degli Elaboratori", NULL);

INSERT INTO SUBTOPICS (Title, TopicID) VALUES
    ('Algoritmi di Ordinamento', (SELECT Id FROM TOPICS WHERE Name = 'Algoritmi')),
    ('Programmazione Dinamica', (SELECT Id FROM TOPICS WHERE Name = 'Algoritmi')),
    ('Kernel', (SELECT Id FROM TOPICS WHERE Name = 'Sistemi Operativi')),
    ('File System', (SELECT Id FROM TOPICS WHERE Name = 'Sistemi Operativi')),
    ('Basi di I/O', (SELECT Id FROM TOPICS WHERE Name = 'Sistemi Operativi')),
    ('La CPU', (SELECT Id FROM TOPICS WHERE Name = 'Architettura degli Elaboratori')),
    ('Memoria RAM', (SELECT Id FROM TOPICS WHERE Name = 'Architettura degli Elaboratori')),
    ('La cache', (SELECT Id FROM TOPICS WHERE Name = 'Architettura degli Elaboratori'));

INSERT INTO ARTICLES (Title, HTMLCode, AuthorID, SubtopicID) VALUES
    ('Articolo test 1', '<p>Contenuto di esempio articolo<p>', 'admin@admin.com', (SELECT Id FROM SUBTOPICS WHERE Title = 'Algoritmi di Ordinamento')),
    ('Articolo test 2', '<p>Contenuto di esempio articolo<p>', 'admin@admin.com', (SELECT Id FROM SUBTOPICS WHERE Title = 'Algoritmi di Ordinamento')),
    ('Articolo test 3', '<p>Contenuto di esempio articolo<p>', 'admin@admin.com', (SELECT Id FROM SUBTOPICS WHERE Title = 'Programmazione Dinamica')),
    ('Articolo test 4', '<p>Contenuto di esempio articolo<p>', 'admin@admin.com', (SELECT Id FROM SUBTOPICS WHERE Title = 'Programmazione Dinamica')),
    ('Articolo test 5', '<p>Contenuto di esempio articolo<p>', 'admin@admin.com', (SELECT Id FROM SUBTOPICS WHERE Title = 'Programmazione Dinamica')),
    ('Articolo test 6', '<p>Contenuto di esempio articolo<p>', 'admin@admin.com', (SELECT Id FROM SUBTOPICS WHERE Title = 'Kernel')),
    ('Articolo test 7', '<p>Contenuto di esempio articolo<p>', 'admin@admin.com', (SELECT Id FROM SUBTOPICS WHERE Title = 'File System')),
    ('Articolo test 8', '<p>Contenuto di esempio articolo<p>', 'admin@admin.com', (SELECT Id FROM SUBTOPICS WHERE Title = 'File System')),
    ('Articolo test 9', '<p>Contenuto di esempio articolo<p>', 'admin@admin.com', (SELECT Id FROM SUBTOPICS WHERE Title = 'Basi di I/O')),
    ('Articolo test 10', '<p>Contenuto di esempio articolo<p>', 'admin@admin.com', (SELECT Id FROM SUBTOPICS WHERE Title = 'La CPU')),
    ('Articolo test 11', '<p>Contenuto di esempio articolo<p>', 'admin@admin.com', (SELECT Id FROM SUBTOPICS WHERE Title = 'La CPU')),
    ('Articolo test 12', '<p>Contenuto di esempio articolo<p>', 'admin@admin.com', (SELECT Id FROM SUBTOPICS WHERE Title = 'La CPU')),
    ('Articolo test 13', '<p>Contenuto di esempio articolo<p>', 'admin@admin.com', (SELECT Id FROM SUBTOPICS WHERE Title = 'Memoria RAM')),
    ('Articolo test 14', '<p>Contenuto di esempio articolo<p>', 'admin@admin.com', (SELECT Id FROM SUBTOPICS WHERE Title = 'La cache')),
    ('Articolo test 15', '<p>Contenuto di esempio articolo<p>', 'admin@admin.com', (SELECT Id FROM SUBTOPICS WHERE Title = 'La cache'));

INSERT INTO COMMENTS (Text, AuthorID, ArticleID) VALUES
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 1')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 2')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 3')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 4')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 5')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 6')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 7')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 8')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 9')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 9')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 10')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 11')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 12')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 13')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 14')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 15')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 7')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 10')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 4')),
    ('Bello!', 'user@user.com', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 2'));

INSERT INTO COMMENTS_VOTES (CommentID, AuthorID, is_like) VALUES
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '1' LIMIT 1), 'user@user.com', TRUE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '1' LIMIT 1), 'user2@user.com', FALSE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '1' LIMIT 1), 'admin@admin.com', FALSE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '2' LIMIT 1), 'admin@admin.com', FALSE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '2' LIMIT 1), 'user2@user.com', FALSE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '3' LIMIT 1), 'admin@admin.com', TRUE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '3' LIMIT 1), 'user2@user.com', FALSE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '4' LIMIT 1), 'admin@admin.com', TRUE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '5' LIMIT 1), 'user@user.com', FALSE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '5' LIMIT 1), 'admin@admin.com', TRUE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '6' LIMIT 1), 'admin@admin.com', TRUE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '7' LIMIT 1), 'admin@admin.com', FALSE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '8' LIMIT 1), 'admin@admin.com', FALSE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '8' LIMIT 1), 'user2@user.com', TRUE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '9' LIMIT 1), 'admin@admin.com', TRUE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '10' LIMIT 1), 'admin@admin.com', TRUE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '11' LIMIT 1), 'admin@admin.com', FALSE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '11' LIMIT 1), 'user@user.com', TRUE);