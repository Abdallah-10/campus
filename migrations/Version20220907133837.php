<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220907133837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscription_formation (inscription_id INT NOT NULL, formation_id INT NOT NULL, INDEX IDX_E655E3A75DAC5993 (inscription_id), INDEX IDX_E655E3A75200282E (formation_id), PRIMARY KEY(inscription_id, formation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscription_formation ADD CONSTRAINT FK_E655E3A75DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription_formation ADD CONSTRAINT FK_E655E3A75200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D65200282E');
        $this->addSql('DROP INDEX UNIQ_5E90F6D65200282E ON inscription');
        $this->addSql('ALTER TABLE inscription DROP formation_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription_formation DROP FOREIGN KEY FK_E655E3A75DAC5993');
        $this->addSql('ALTER TABLE inscription_formation DROP FOREIGN KEY FK_E655E3A75200282E');
        $this->addSql('DROP TABLE inscription_formation');
        $this->addSql('ALTER TABLE inscription ADD formation_id INT NOT NULL');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D65200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5E90F6D65200282E ON inscription (formation_id)');
    }
}
