CREATE TABLE `user`
(
    `id`        bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `createdAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `email`     varchar(255)        NOT NULL,
    `token`     varchar(255)        NOT NULL,
    `username`  varchar(255)        NOT NULL,
    `bio`       text                NOT NULL,
    `image`     mediumtext          NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `article`
(
    `id`          bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `slug`        varchar(255) UNIQUE NOT NULL,
    `title`       text                NOT NULL,
    `description` text                NOT NULL,
    `body`        text                NOT NULL,
    `authorId`    bigint(20) unsigned NOT NULL,
    `createdAt`   datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt`   datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT fk_author_id
        FOREIGN KEY (authorId)
            REFERENCES user (id)
            ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;



CREATE TABLE `tag`
(
    `id`        bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `createdAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `tag`       varchar(255)        NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `articleTags`
(
    `tagId`     bigint(20) unsigned NOT NULL,
    `articleId` bigint(20) unsigned NOT NULL,
    `createdAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`tagId`, `articleId`),
    CONSTRAINT fk_tag_id
        FOREIGN KEY (tagId)
            REFERENCES tag (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_article_id
        FOREIGN KEY (articleId)
            REFERENCES article (id)
            ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `comment`
(
    `id`        bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `articleId` bigint(20) unsigned NOT NULL,
    `body`      text                NOT NULL,
    `author`    bigint(20) unsigned NOT NULL,
    `createdAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT fk_comment
        FOREIGN KEY (articleId)
            REFERENCES article (id)
            ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `favorite`
(
    `userId`    bigint(20) unsigned NOT NULL,
    `articleId` bigint(20) unsigned NOT NULL,
    `favorited` tinyint(1)          NOT NULL,
    `createdAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`userId`, `articleId`),
    CONSTRAINT fk_favorite_user
        FOREIGN KEY (userId)
            REFERENCES user (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_favorite_id
        FOREIGN KEY (articleId)
            REFERENCES article (id)
            ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `following`
(
    `createdAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `user_id`   bigint(20) unsigned NOT NULL,
    `followTo`  bigint(20) unsigned NOT NULL,
    PRIMARY KEY (`user_id`, `followTo`),
    CONSTRAINT fk_following_user_id
        FOREIGN KEY (user_id)
            REFERENCES user (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_following_follow_to_user_id
        FOREIGN KEY (user_id)
            REFERENCES user (id)
            ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
