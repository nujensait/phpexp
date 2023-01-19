# What is it?
"OTUS PHP Pro" course: https://fas.st/wRyRs
Lesson #5: Webservers, homework

# Author
Mikhail Ikonnikov <mishaikon@gmail.com>

################################

# A task

Description / step-by-step instructions for completing homework

Task: Verification of a string with brackets

Using Docker, you described building two containers:
- one with nginx,
- the second one is with php-fpm and your code.

Using docker-compose you start both containers.
The nginx container forwards port 80 to your host machine and listens for connections.
The client connects and sends the following HTTP request:
```
POST/HTTP/1.1
string=(()()()()))((((()()()))(()()()(((()))))))
```
String is a POST parameter that can be checked:
- To nonemptiness
- On the correctness of the number of open and closed brackets

All requests with dynamic content (*.php) nginx,
using the fastcgi_pass directive, proxies to a container with php-fpm and your code.

Nginx should process requests regardless of the Host directive.

After processing:
- if the string is correct, then a 200 OK response is returned to the user, with the informational text that everything is fine;
- if the string is incorrect, then a 400 Bad Request response is returned to the user, with the informational text that everything is bad.

Create a Balanced Cluster
- nginx-upstream balancer
- Balanced backends on nginx (each has its own php-fpm, ideally you can request any available fpm)
- Connect the Memcache container to both fpm containers
- If you have balancing, standard sessions are no longer enough. Otherwise, authentication will not work. Transfer session storage to it (Memcache)
- A more difficult task for those who want to test their strength: combine both Memcache into a cluster. You can use Repcached

Criteria for evaluation
- The line in the example is just an example. On tests, it should be any
- Parentheses must match in terms of parentheses. Test ")(" should not pass
- The @ and die constructs are not acceptable. Use exceptions instead
- From the point of view of the web service logic, the response 400 is a valid completion of the script

################################

# Setup/start

## write to hosts file:
```
127.0.0.1hw5
```

### goto workdir
```
cd ./hw5
```

### build containers
```
docker-compose build
```

### exec containers
```
docker-compose-up
```

### open in browser
```
http://hw5:8083/
```

### send postman request
- URL: http://hw5:8083/
- params: string: ())

### get result (example):
-connection →keep-alive
- content-type →text/html; charset=UTF-8
- date →Fri, 19 Aug 2022 09:41:49 GMT
- fail →icorrect string (Response from 83e503a64f67)
  -server →nginx/1.21.6
- transfer-encoding →chunked
  -x-powered-by→PHP/7.4.30

### stop containers
```
docker-compose down
```

################################