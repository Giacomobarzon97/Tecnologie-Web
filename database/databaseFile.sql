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
DROP TABLE IF EXISTS FORGOT_PASSWORD_TOKENS;

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
    Banned BOOLEAN
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
    Description MEDIUMTEXT,
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
    Date DATETIME,
    AuthorID varchar(100) REFERENCES USERS(Email) ON UPDATE CASCADE ON DELETE CASCADE,
    ArticleID INT REFERENCES ARTICLES(Id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE COMMENTS_VOTES(
    CommentID INT REFERENCES COMMENTS(Id) ON UPDATE CASCADE ON DELETE CASCADE,
    AuthorID varchar(100) REFERENCES USERS(Email) ON UPDATE CASCADE ON DELETE CASCADE,
    is_like BOOLEAN,
    PRIMARY KEY (CommentID,AuthorID)
) ENGINE=InnoDB;

CREATE TABLE FORGOT_PASSWORD_TOKENS(
    Id INT PRIMARY KEY AUTO_INCREMENT,
    UserID varchar(100) REFERENCES USERS(Email) ON UPDATE CASCADE ON DELETE CASCADE,
    Token varchar(255) UNIQUE,
    expireDate date
) ENGINE=InnoDB;

-- ------------------------------------------
-- Inserimento dati di test nel database
-- ------------------------------------------

INSERT INTO USERS (Email, Nickname, Password, Name, Surname, Banned) VALUES
    ('user@user.com', 'User', 'User', 'User Test', '1', 0),
    ('user2@user.com', 'User2', 'User', 'User Test', '2', 0),
    ('admin@admin.com', 'Admin', 'Admin', 'Admin Test', '1', 0);

INSERT INTO ROLES (RoleName) VALUES
    ('Normal User'), ('Admin User');

INSERT INTO USER_ROLES (UserID, RoleName) VALUES
    ('user@user.com', 'Normal User'),
    ('user2@user.com', 'Normal User'),
    ('admin@admin.com', 'Admin User');

INSERT INTO TOPICS (Name, Description, ImageLink) VALUES
    ('Algoritmi', "Descrizione Lunga Topic Algoritmi",  "https://frncscdf.github.io/Tecnologie-Web/img/algo.jpg"),
    ('Sistemi Operativi', "Descrizione Lunga Topic Sistemi Operativi", "https://frncscdf.github.io/Tecnologie-Web/img/algo.jpg"),
    ('Architettura degli Elaboratori', "Descrizione Lunga Topic Architettura degli Elaboratori", "https://frncscdf.github.io/Tecnologie-Web/img/algo.jpg"),
    ('Topic enorme di test', "Descrizione Lunga Topic di test, bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla 
    bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla 
    bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao 
    ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ciao ", "https://frncscdf.github.io/Tecnologie-Web/img/algo.jpg");

INSERT INTO SUBTOPICS (Title, Description, TopicID) VALUES
    ('Algoritmi di Ordinamento', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Algoritmi')),
    ('Programmazione Dinamica', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Algoritmi')),
    ('Kernel',"Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Sistemi Operativi')),
    ('File System', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Sistemi Operativi')),
    ('Basi di I/O', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Sistemi Operativi')),
    ('La CPU', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Architettura degli Elaboratori')),
    ('Memoria RAM', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Architettura degli Elaboratori')),
    ('La cache', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Architettura degli Elaboratori')),
    ('Subtopic test 1', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 2', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 3', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 4', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 5', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 6', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 7', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 8', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 9', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 10', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 11', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 12', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 13', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 14', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 15', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 16', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 17', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 18', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 19', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 20', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 21', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 22', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 23', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 24', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 25', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 26', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 27', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 28', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 29', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test')),
    ('Subtopic test 30', "Descrizione Semplice Subtopic", (SELECT Id FROM TOPICS WHERE Name = 'Topic enorme di test'));

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

INSERT INTO COMMENTS (Text, AuthorID, Date, ArticleID) VALUES
    ('Bello!', 'user@user.com', '2018-12-17 10:34:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 1')),
    ('Bello 2!', 'user2@user.com', '2018-12-15 10:34:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 1')),
    ('Bello by admin!', 'admin@admin.com', '2018-12-16 10:34:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 1')),
    ('Bello!', 'user@user.com', '2018-12-17 10:35:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 2')),
    ('Bello!', 'user@user.com', '2018-12-17 10:36:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 3')),
    ('Bello!', 'user@user.com', '2018-12-17 10:37:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 4')),
    ('Bello!', 'user@user.com', '2018-12-17 10:38:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 5')),
    ('Bello!', 'user@user.com', '2018-12-17 10:39:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 6')),
    ('Bello!', 'user@user.com', '2018-12-17 10:40:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 7')),
    ('Bello!', 'user@user.com', '2018-12-17 10:41:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 8')),
    ('Bello!', 'user@user.com', '2018-12-17 10:42:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 9')),
    ('Bello!', 'user@user.com', '2018-12-17 10:43:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 9')),
    ('Bello!', 'user@user.com', '2018-12-17 10:55:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 10')),
    ('Bello!', 'user@user.com', '2018-12-17 10:44:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 11')),
    ('Bello!', 'user@user.com', '2018-12-17 10:45:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 12')),
    ('Bello!', 'user@user.com', '2018-12-17 10:45:10', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 13')),
    ('Bello!', 'user@user.com', '2018-12-17 10:46:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 14')),
    ('Bello!', 'user@user.com', '2018-12-17 10:47:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 15')),
    ('Bello!', 'user@user.com', '2018-12-17 10:47:10', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 7')),
    ('Bello!', 'user@user.com', '2018-12-17 10:24:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 10')),
    ('Bello!', 'user@user.com', '2018-12-17 10:54:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 4')),
    ('Bello!', 'user@user.com', '2018-12-17 10:24:09', (SELECT Id FROM ARTICLES WHERE Title = 'Articolo test 2'));

INSERT INTO COMMENTS_VOTES (CommentID, AuthorID, is_like) VALUES
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '1' LIMIT 1), 'user@user.com', TRUE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '1' LIMIT 1), 'user2@user.com', FALSE),
    ((SELECT Id FROM COMMENTS WHERE ArticleID = '1' LIMIT 1), 'admin@admin.com', FALSE),
    ((SELECT Id FROM COMMENTS WHERE Date = '2018-12-15 10:34:09' LIMIT 1), 'user@user.com', TRUE),
    ((SELECT Id FROM COMMENTS WHERE Date = '2018-12-15 10:34:09' LIMIT 1), 'user2@user.com', TRUE),
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
