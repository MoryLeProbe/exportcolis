<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251202141341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expedition DROP FOREIGN KEY `FK_692907E19EB6921`');
        $this->addSql('DROP INDEX IDX_692907E19EB6921 ON expedition');
        $this->addSql('ALTER TABLE expedition DROP client_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expedition ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE expedition ADD CONSTRAINT `FK_692907E19EB6921` FOREIGN KEY (client_id) REFERENCES client (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_692907E19EB6921 ON expedition (client_id)');
    }
}
