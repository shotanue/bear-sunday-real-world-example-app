CREATE TABLE `article`
(
    `id`          bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `createdAt`   datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt`   datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `title`       text                NOT NULL,
    `description` text                NOT NULL,
    `slug`        varchar(255) UNIQUE NOT NULL,
    `body`        text                NOT NULL,
    `authorId`    binary(16)          NOT NULL,
    PRIMARY KEY (`id`)
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
    `createdAt` datetime   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` datetime   NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
    `createdAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `body`      text                NOT NULL,
    `authorId`  binary(16)          NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT fk_comment
        FOREIGN KEY (articleId)
            REFERENCES article (id)
            ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

CREATE TABLE `favorite`
(
    `userId`    binary(16)          NOT NULL,
    `articleId` bigint(20) unsigned NOT NULL,
    `createdAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `favorited` tinyint(1)          NOT NULL,
    PRIMARY KEY (`userId`, `articleId`),
    CONSTRAINT fk_favorite_id
        FOREIGN KEY (articleId)
            REFERENCES article (id)
            ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;
