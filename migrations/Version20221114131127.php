<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221114131127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messanger (id INT AUTO_INCREMENT NOT NULL, contacter_id INT DEFAULT NULL, sender INT NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_17AAE5C1BA1C89F1 (contacter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, cover VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE messanger ADD CONSTRAINT FK_17AAE5C1BA1C89F1 FOREIGN KEY (contacter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE slider CHANGE ordre ordre INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE cover cover VARCHAR(255) DEFAULT NULL, CHANGE age age INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messanger DROP FOREIGN KEY FK_17AAE5C1BA1C89F1');
        $this->addSql('DROP TABLE messanger');
        $this->addSql('DROP TABLE profil');
        $this->addSql('ALTER TABLE slider CHANGE ordre ordre INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE age age INT DEFAULT NULL, CHANGE cover cover VARCHAR(255) DEFAULT \'user.png\'');
    }
}
