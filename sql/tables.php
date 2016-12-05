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

CREATE TABLE Comments(
        id int(11) unsigned not null auto_increment,
        user_id int(11) unsigned not null,
        post_id int(11) unsigned not null,
        creation_date datetime,
        text varchar(60) not null,
        PRIMARY KEY(id),
        FOREIGN KEY(post_id) references Tweets(id) on delete cascade
        );

CREATE TABLE Messages(
        id int(11) unsigned not null auto_increment,
        send_user_id int(11) unsigned not null,
        receive_user_id int(11) unsigned not null,
        creation_date datetime,
        text varchar(255) not null,
        seen int(11) unsigned not null,
        PRIMARY KEY(id),
        FOREIGN KEY(send_user_id) references Users(id),
        FOREIGN KEY(receive_user_id) references Users(id)
        );