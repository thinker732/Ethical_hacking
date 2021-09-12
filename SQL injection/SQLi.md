# More about SQLi


## Introduction

SQL injection (SQLi) is a web security vulnerability that allows an attacker to interfere with the queries that an application makes to its database.
it usually allows an attacker to viw data that they are not supposed to retreive and can even interact and do Data tampering(modification/delection) on our application.

## Variety of SQLi techniques/attacks

### Retrieving hidden data

where you can modify an SQL query to return additional results.

usually by using remplacing the injectable parameters after the WHERE clause with sql comment (##,--)  so that i will exclude a part of the command 
exemple:
(retreiving data portswigger)[https://portswigger.net/web-security/sql-injection#retrieving-hidden-data]

### Subverting application logic

where you can change a query to interfere with the application's logic.


Consider an application that lets users log in with a username and password. If a user submits the username wiener and the password bluecheese, the application checks the credentials by performing the following SQL query:

```sql
SELECT * FROM users WHERE username = 'paolo' AND password = 'azertyui'
```
If the query returns the details of a user, then the login is successful. Otherwise, it is rejected.

Here, an attacker can log in as any user without a password simply by using the SQL comment sequence -- to remove the password check from the WHERE clause of the query. For example, submitting the username admin'-- and a blank password results in the following query:

```sql
SELECT * FROM users WHERE username = 'admin'--' AND password = ''
```

and we will get the acces to the account


### Retrieving data from other database tables


## more about and references
 
(from)[https://portswigger.net/web-security/sql-injection]