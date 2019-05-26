# Symfony Console Twitter

## Installation
Make sure you have Docker installed. From a command prompt in the project's root folder, issue:

```bash
> make docker-start
```

This will build the necessary Docker containers and use Docker compose to bring them up. Next, issue:

```bash
> make docker-shell
```

To get a shell prompt from inside the PHP Docker container. Install dependencies:

```bash
> composer install
```

Import database migrations (when prompted, answer Y):

```bash
> bin/console doc:mig:mig
```

Import fixtures (when prompted, answer Y):

```bash
> bin/console doc:fix:load
```

In the provided data fixtures, there are 4 users: frenchie, duke, mitch and bill. Each has some posts that were created
at different, staggered, times

## Usage
### Post new message
```bash
t <username> -- <message>
```
This is also user to create new users. An example:
```bash
t fred -- My name is fred and this is my first message.
```

### View a given user's messages
```bash
t <username>
```
The provided username must be for an existing user.

### Follow another user
```bash
t <username> follows <username>
```
The provided username must be for existing users.

### Show all message subscriptions (own posts, and those of users you are following)
```bash
t <username> wall
```
The provided username must be for an existing user. Bill is subscribed to mitch and duke, so is a good wall to look at.
