CREATE TABLE `article`
(
    `id`          bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `slug`        varchar(255) UNIQUE NOT NULL,
    `title`       text                NOT NULL,
    `description` text                NOT NULL,
    `body`        text                NOT NULL,
    `authorId`    bigint(20) unsigned NOT NULL,
    `createdAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` datetime            NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT fk_author_id
        FOREIGN KEY (authorId)
            REFERENCES user (id)
            ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

