<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200902121830 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE demande_cse (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, object VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, createdat DATE NOT NULL, INDEX IDX_F4220A12A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_comptable (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, object VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, createdat DATE NOT NULL, holidaysrequest DOUBLE PRECISION DEFAULT NULL, hoursrequest DOUBLE PRECISION DEFAULT NULL, hourssupp DOUBLE PRECISION DEFAULT NULL, accepted TINYINT(1) DEFAULT NULL, money DOUBLE PRECISION DEFAULT NULL, INDEX IDX_2E48B9B2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_data (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, poste VARCHAR(255) NOT NULL, delegate TINYINT(1) NOT NULL, adress VARCHAR(255) DEFAULT NULL, phonenumber VARCHAR(255) DEFAULT NULL, birthday DATE DEFAULT NULL, hours DOUBLE PRECISION DEFAULT NULL, holidays DOUBLE PRECISION DEFAULT NULL, UNIQUE INDEX UNIQ_D772BFAA67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande_cse ADD CONSTRAINT FK_F4220A12A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE demande_comptable ADD CONSTRAINT FK_2E48B9B2A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE user_data ADD CONSTRAINT FK_D772BFAA67B3B43D FOREIGN KEY (users_id) REFERENCES users (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE demande_cse');
        $this->addSql('DROP TABLE demande_comptable');
        $this->addSql('DROP TABLE user_data');
    }
}
