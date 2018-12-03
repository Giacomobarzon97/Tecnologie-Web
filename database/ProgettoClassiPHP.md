# Progetto classi PHP

## ConnectionManager
\- String databaseIP, databasePW, databaseUsername, databaseName

\+ DatabaseManager();
\+ void connectToDatabase();
\+ void disconnectFromDatabase();

\+ static void createSession();
\+ static void deleteSession();
\+ static bool getIsSessionActive();

## Topics

\- HTMLCode getTopicCode(String name, byte[] image, Map<String, String> links);
\+ void getAllTopicsFromDatabase();

## SubTopics

\- HTMLCode getSubTopicCode(String name, Map<String, String> links);
\+ void getAllSubTopicsFromDatabase();

## Article
\+ HTMLCode getArticleCode(String articleId);
\+ void addArticle(String articleHTML, String subTopicID);

## Comments
\- int getCommentVote(String commentID);
\- HTMLCode getCommentCode(String commentID);

\+ HTMLCode getCommentsForArticle(String articleId);

## User
\+ void voteComment(String commentID, bool is_like);
\+ void addComment(String articleID, String commentText);

\+ void changePassword(String newPassword);
\+ void deleteAccount();

## Admin extends User
\+ deleteComment(String commentID);

//----------------------------------------------------------//
# Lista file PHP
* Header
* Navbar
* Footer
* Sidebar
* ...more(?)
