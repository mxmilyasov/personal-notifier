<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250102145102 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE users (id CHAR(36) NOT NULL, telegram_id INT NOT NULL, username VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE reminders (id CHAR(36) NOT NULL, subject VARCHAR(255) NOT NULL, date DATETIME NOT NULL, text LONGTEXT DEFAULT NULL, type VARCHAR(20) NOT NULL, repeat_interval VARCHAR(20) NOT NULL, is_completed TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, user_id CHAR(36) DEFAULT NULL, INDEX IDX_6D92B9D4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('ALTER TABLE reminders ADD CONSTRAINT FK_6D92B9D4A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE users');
        $this->addSql('ALTER TABLE reminders DROP FOREIGN KEY FK_6D92B9D4A76ED395');
        $this->addSql('DROP TABLE reminders');
    }

    public function isTransactional(): bool
    {
        return true;
    }
}
