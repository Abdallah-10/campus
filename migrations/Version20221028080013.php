<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221028080013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE slider (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6A76ED395');
        $this->addSql('DROP INDEX IDX_5E90F6D6A76ED395 ON inscription');
        $this->addSql('ALTER TABLE inscription ADD id_user_id INT DEFAULT NULL, DROP user_id');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D679F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5E90F6D679F37AE5 ON inscription (id_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE slider');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D679F37AE5');
        $this->addSql('DROP INDEX IDX_5E90F6D679F37AE5 ON inscription');
        $this->addSql('ALTER TABLE inscription ADD user_id INT NOT NULL, DROP id_user_id');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5E90F6D6A76ED395 ON inscription (user_id)');
    }
}
