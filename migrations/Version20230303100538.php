<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230303100538 extends AbstractMigration
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
        $this->addSql('ALTER TABLE inscription ADD ministere_id INT DEFAULT NULL, CHANGE phone phone VARCHAR(255) NOT NULL, CHANGE organisme organisme VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6AD745416 FOREIGN KEY (ministere_id) REFERENCES ministere (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D6AD745416 ON inscription (ministere_id)');
        $this->addSql('ALTER TABLE slider CHANGE ordre ordre INT NOT NULL');
        $this->addSql('ALTER TABLE temoignage CHANGE langue langue VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE cover cover VARCHAR(255) DEFAULT NULL, CHANGE is_verified is_verified TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE profil');
        $this->addSql('ALTER TABLE actualite CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6AD745416');
        $this->addSql('DROP INDEX IDX_5E90F6D6AD745416 ON inscription');
        $this->addSql('ALTER TABLE inscription DROP ministere_id, CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE organisme organisme VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE slider CHANGE ordre ordre INT DEFAULT NULL');
        $this->addSql('ALTER TABLE temoignage CHANGE langue langue VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE cover cover VARCHAR(255) DEFAULT \'0\', CHANGE is_verified is_verified TINYINT(1) DEFAULT 0');
    }
}
