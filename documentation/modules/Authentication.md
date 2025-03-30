# Authentication Module

## Authentication

1. User Login: - IN PROGRESS
    * Login using provided email and password.
2. Reset Password: - IN PROGRESS
    * Request reset password.
    * Send reset password email.
    * Reset Password.
3. Invite Only Registration: - IN PROGRESS
    * Send invitation to user.
    * Register to application through received invitation.

# Authentication Database Scheme:

## Users:

### Table Name: users

| Field             | Type            | Null | Key | Default | Extra          |
|-------------------|-----------------|------|-----|---------|----------------|
| id                | bigint unsigned | NO   | PRI | NULL    | auto_increment |
| name              | varchar(255)    | NO   |     | NULL    |                |
| email             | varchar(255)    | NO   | UNI | NULL    |                |
| email_verified_at | timestamp       | YES  |     | NULL    |                |
| password          | varchar(255)    | NO   |     | NULL    |                |
| remember_token    | varchar(100)    | YES  |     | NULL    |                |
| created_at        | timestamp       | YES  |     | NULL    |                |
| updated_at        | timestamp       | YES  |     | NULL    |                |

### Table Name: password_reset_tokens

| Field      | Type         | Null | Key | Default | Extra |
|------------|--------------|------|-----|---------|-------|
| email      | varchar(255) | NO   | PRI | NULL    |       |
| token      | varchar(255) | NO   |     | NULL    |       |
| created_at | timestamp    | YES  |     | NULL    |       |

### Table Name: sessions

| Field         | Type            | Null | Key | Default | Extra |
|---------------|-----------------|------|-----|---------|-------|
| id            | varchar(255)    | NO   | PRI | NULL    |       |
| user_id       | bigint unsigned | YES  | MUL | NULL    |       |
| ip_address    | varchar(45)     | YES  |     | NULL    |       |
| user_agent    | text            | YES  |     | NULL    |       |
| payload       | longtext        | NO   |     | NULL    |       |
| last_activity | int             | NO   | MUL | NULL    |       |

# Application Roles & Permissions:

## Permissions:

* To be determined

## Roles:

* Super-Admin:
* Admin:
* Member:
* Guest:
