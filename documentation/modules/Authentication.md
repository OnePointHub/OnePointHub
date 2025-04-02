# Authentication Module

## Authentication

1. User Login: - Done
    * Login using provided email and password.
2. Reset Password: - Done
    * Request reset password.
    * Send reset password email.
    * Reset Password.
3. Logout: - Done
    * User can log out .

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
| status            | varchar(255)    | NO   |     | active  |                |
| phone             | varchar(255)    | YES  |     |         |                |
| location          | varchar(255)    | YES  |     |         |                |
| last_active_at    | timestamp       | YES  |     |         |                |

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

### Table Name: permissions

| Field      | Type            | Null | Key | Default | Extra          |
|------------|-----------------|------|-----|---------|----------------|
| id         | bigint unsigned | NO   | PRI | NULL    | auto_increment |
| name       | varchar(255)    | NO   | MUL | NULL    |                |
| guard_name | varchar(255)    | NO   |     | NULL    |                |
| created_at | timestamp       | YES  |     | NULL    |                |
| updated_at | timestamp       | YES  |     | NULL    |                |

### Table Name: roles

| Field      | Type            | Null | Key | Default | Extra          |
|------------|-----------------|------|-----|---------|----------------|
| id         | bigint unsigned | NO   | PRI | NULL    | auto_increment |
| name       | varchar(255)    | NO   | MUL | NULL    |                |
| guard_name | varchar(255)    | NO   |     | NULL    |                |
| created_at | timestamp       | YES  |     | NULL    |                |
| updated_at | timestamp       | YES  |     | NULL    |                |

### Table Name: model_has_permissions

| Field         | Type            | Null | Key | Default | Extra |
|---------------|-----------------|------|-----|---------|-------|
| permission_id | bigint unsigned | NO   | PRI | NULL    |       |
| model_type    | varchar(255)    | NO   | PRI | NULL    |       |
| model_id      | bigint unsigned | NO   | PRI | NULL    |       |

### Table Name: model_has_roles

| Field      | Type            | Null | Key | Default | Extra |
|------------|-----------------|------|-----|---------|-------|
| role_id    | bigint unsigned | NO   | PRI | NULL    |       |
| model_type | varchar(255)    | NO   | PRI | NULL    |       |
| model_id   | bigint unsigned | NO   | PRI | NULL    |       |

### Table Name: model_has_roles

| Field         | Type            | Null | Key | Default | Extra |
|---------------|-----------------|------|-----|---------|-------|
| permission_id | bigint unsigned | NO   | PRI | NULL    |       |
| role_id       | bigint unsigned | NO   | PRI | NULL    |       |

# Application Roles & Permissions:

## Permissions:

* Invite Members
* Manage Team

## Roles:

* Super-Admin:
    * Invite Members
    * Manage Team
* Admin:
    * Invite Members
    * Manage Team
* Member:
* Guest:
