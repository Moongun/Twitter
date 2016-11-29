<?php

CREATE TABLE Users(
       id int(11) unsigned not null  auto_increment,
       email varchar(255) not null UNIQUE,
       username varchar(255) not null,
       hashed_password varchar(60) not null,
       PRIMARY KEY(id)
       );

CREATE TABLE Tweets(
        id int(11) unsigned not null auto_increment,
        user_id int(11) unsigned not null,
        tweet_text varchar(140) not null,
        creation_date datetime,
        PRIMARY KEY(id),
        FOREIGN KEY(user_id) references Users(id) on delete cascade
        );

