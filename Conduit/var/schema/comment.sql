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
