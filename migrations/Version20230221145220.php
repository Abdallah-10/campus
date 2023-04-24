<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221145220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, cover VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actualite CHANGE type type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE inscription CHANGE phone phone VARCHAR(255) NOT NULL, CHANGE organisme organisme VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE slider CHANGE ordre ordre INT NOT NULL');
        $this->addSql('ALTER TABLE temoignage CHANGE langue langue VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) DEFAULT NULL, CHANGE cover cover VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE profil');
        $this->addSql('ALTER TABLE actualite CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE organisme organisme VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE slider CHANGE ordre ordre INT DEFAULT NULL');
        $this->addSql('ALTER TABLE temoignage CHANGE langue langue VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP is_verified, CHANGE cover cover VARCHAR(255) DEFAULT \'user.png\'');
    }
}
