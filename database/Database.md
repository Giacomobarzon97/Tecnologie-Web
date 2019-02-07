## USERS

* Email (Primary Key)
* Nickname (UNIQUE)
* Password
* Name
* Surname
* Banned

## ROLES (Normal User/Admin User)

* RoleName (Primary Key)

## USER_ROLES

* UserID -> UTENTI (ExternalKey)
* RoleName -> ROLES (ExternalKey)

## TOPICS

* ID (Primary Key - AutoIncrement)
* Name
* Description
* ImageLink

## SUBTOPICS

* ID (Primary Key - AutoIncrement)
* Title
* Description
* TopicID -> TOPICS (ExternalKey)

## ARTICLE

* ID (Primary Key - AutoIncrement)
* Title
* ArticleHTML (LongText)
* Author -> UTENTI (ExternalKey)
* SubTopicID -> SUBTOPICS (ExternalKey)

## COMMENTS

* ID (Primary Key - AutoIncrement)
* Content (LongText)
* Date (DATETIME)
* Author -> UTENTI (ExternalKey)
* ArticleID -> ArticleID (ExternalKey)

## COMMENTS-VOTES

* CommentID (Primary Key - ExternalKey)
* UserID (Primary Key - ExternalKey)
* is_like (boolean)

## Tabella per i token di chi dimentica la password

Quanto un utente dimentica la password bisogna inviargli tramite email un link con un token temoraneo per cambiare la password.

## FORGOT_PASSWORD_TOKENS

* UserID (Primary Key - ExternalKey)
* Token (Primary Key)
* expireDate (Primary Key)