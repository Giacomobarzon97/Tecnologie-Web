## USERS

* Email (Primary Key)
* Nickname (UNIQUE)
* Name
* Surname
* ProfilePic

## USER_ROLES

* UserID -> UTENTI (ExternalKey)
* RoleID -> ROLES (ExternalKey)

## ROLES (Normal User/Admin User)

* RoleID
* RoleName

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
