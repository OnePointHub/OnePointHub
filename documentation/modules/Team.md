# Team Module

## Team

1. Invite team members: - Done
2. Team member can register: - Done
3. Manage team member's role: - Done
4. Manage team members' status: - Done
5. Delete team member: - Done

# Team Database Scheme:

### Table Name: user_invitations

| Field            | Type            | Null | Key | Default | Extra          |
|------------------|-----------------|------|-----|---------|----------------|
| id               | bigint unsigned | NO   | PRI | NULL    | auto_increment |
| email            | varchar(255)    | NO   | UNI | NULL    |                |
| invitation_token | varchar(255)    | YES  | UNI | NULL    |                |
| registered_at    | timestamp       | YES  |     | NULL    |                |
| created_at       | timestamp       | YES  |     | NULL    |                |
| updated_at       | timestamp       | YES  |     | NULL    |                |
