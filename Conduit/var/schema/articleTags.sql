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
