<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251202122652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY `FK_B1DC7A1E4D268D70`');
        $this->addSql('DROP INDEX IDX_B1DC7A1E4D268D70 ON paiement');
        $this->addSql('ALTER TABLE paiement CHANGE colis_id expedition_id INT NOT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E576EF81E FOREIGN KEY (expedition_id) REFERENCES expedition (id)');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E576EF81E ON paiement (expedition_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E576EF81E');
        $this->addSql('DROP INDEX IDX_B1DC7A1E576EF81E ON paiement');
        $this->addSql('ALTER TABLE paiement CHANGE expedition_id colis_id INT NOT NULL');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT `FK_B1DC7A1E4D268D70` FOREIGN KEY (colis_id) REFERENCES colis (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B1DC7A1E4D268D70 ON paiement (colis_id)');
    }
}
