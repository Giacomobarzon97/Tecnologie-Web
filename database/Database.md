## USERS

* Email (Primary Key)
* Nickname (UNIQUE)
* Password
* Name
* Surname
* ProfilePic

## ROLES (Normal User/Admin User)

* RoleName (Primary Key)

## USER_ROLES

* UserID -> UTENTI (ExternalKey)
* RoleName -> ROLES (ExternalKey)

## TOPICS

* ID (Primary Key - AutoIncrement)
* Name
* Image

## SUBTOPICS

* ID (Primary Key - AutoIncrement)
* Title
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
* Author -> UTENTI (ExternalKey)
* ArticleID -> ArticleID (ExternalKey)

## COMMENTS-VOTES

* CommentID (Primary Key - ExternalKey)
* UserID (Primary Key - ExternalKey)
* is_like (boolean)

## Tabella per i token di chi dimentica la password
Quanto un utente dimentica la password bisogna inviargli tramite email un link con un token temoraneo per cambiare la password.