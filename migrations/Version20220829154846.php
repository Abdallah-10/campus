<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220829154846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, cover VARCHAR(255) DEFAULT NULL, duration DOUBLE PRECISION DEFAULT NULL, langue VARCHAR(255) NOT NULL, date_start DATE DEFAULT NULL, date_end DATE DEFAULT NULL, type VARCHAR(255) NOT NULL, apercu LONGTEXT NOT NULL, objectifs LONGTEXT DEFAULT NULL, certifs LONGTEXT DEFAULT NULL, structure LONGTEXT DEFAULT NULL, criteres LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE formation');
    }
}
