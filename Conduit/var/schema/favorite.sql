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