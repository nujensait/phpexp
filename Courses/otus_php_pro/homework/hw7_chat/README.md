# What is this?
Homework #7 for ["Otus PHP Pro"](https://fas.st/wRyRs)

# Author
Mikhail Ikonnikov <mishaikon@gmail.com>

# Launch example
```
# setup project
docker-compose-up

# go into client container
docker exec -it hw7_chat_app_client_1 bash

# run client daemon (server alrady running on docker start)
php app.php client
<type any message, hit enter, type :q to exit>
```

# Exercise

## Homework
Socket Chat

## Target:

- We continue to learn how to write applications and work with new technologies.

## Step-by-step instructions for completing homework:

Console chat on sockets Create logic hosted in two php containers (server and client),
united by a common volume.
Scripts run in STDIN listening mode and exchange input messages with each other via unix sockets.

- the server is always up first
- the client expects input from STDIN and sends messages to the server
- the server prints the received message to STDOUT and sends an acknowledgment to the client (for example, "Received 24 bytes")
- the client outputs the received confirmation to STDOUT and starts a new iteration of the loop

## Criteria for evaluation:

- The @ and die constructs are not acceptable. Use exceptions instead
- Only Unix socket accepted
- We write code using OOP
- The code must be configurable via settings files like config.ini
- Pay attention to the FrontController pattern (it is also a single access point).
- All applications that you create here and further must be called through one index.php file,
  which has ONLY one entry point - app.php

- Server and client are started by commands
```
php app.php server
php app.php client
```

- In app.php only lines:
```
require_once('/path/to/composer/autoload.php');

try {
         $app = newApp();
         $app->run();
     }
     catch(Exception $e) {
     }
}
```
- The logic of reading configurations and working with sockets - only in classes.