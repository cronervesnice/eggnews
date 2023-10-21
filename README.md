# eggnews

Simple ass news site, not even that good but it's whatever.

u need sql btw and all of the php extensions idk im dumb

create


db called realnews
table called news


with


id    title         article        author         uploadtime NOW()


also create users like so

CREATE TABLE users (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);



then change config_users.php and config.php

use this to insert stuff into news articles
INSERT INTO news (id, title, article, author, uploadtime) VALUES (2, 'The Palestine vs Israel War: The Truth.', 'https://eggboyscooter.xyz/articles/2.txt', 'NoventaDos', NOW());
