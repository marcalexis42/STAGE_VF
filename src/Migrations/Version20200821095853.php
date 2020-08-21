<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200821095853 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, subject_id INT NOT NULL, created_at DATETIME NOT NULL, content LONGTEXT NOT NULL, edited_at DATETIME NOT NULL, INDEX IDX_D9BEC0C4F675F31B (author_id), INDEX IDX_D9BEC0C423EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, editor_id INT NOT NULL, object VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_2694D7A56995AC4C (editor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topics (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, subject VARCHAR(255) NOT NULL, edited_at DATETIME NOT NULL, content LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, pin TINYINT(1) NOT NULL, msg_counter INT NOT NULL, INDEX IDX_91F64639F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, delegate TINYINT(1) NOT NULL, position VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C423EDC87 FOREIGN KEY (subject_id) REFERENCES topics (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A56995AC4C FOREIGN KEY (editor_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE topics ADD CONSTRAINT FK_91F64639F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C423EDC87');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4F675F31B');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A56995AC4C');
        $this->addSql('ALTER TABLE topics DROP FOREIGN KEY FK_91F64639F675F31B');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE topics');
        $this->addSql('DROP TABLE users');
    }
}
