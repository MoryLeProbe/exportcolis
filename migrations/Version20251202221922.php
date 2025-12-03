<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251202221922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE port (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, pays VARCHAR(100) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tarif_port (id INT AUTO_INCREMENT NOT NULL, type_transport VARCHAR(20) NOT NULL, prix_kg NUMERIC(10, 2) NOT NULL, port_depart_id INT DEFAULT NULL, port_arrivee_id INT DEFAULT NULL, INDEX IDX_A150712594C9CCD3 (port_depart_id), INDEX IDX_A1507125141EAE06 (port_arrivee_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE tarif_port ADD CONSTRAINT FK_A150712594C9CCD3 FOREIGN KEY (port_depart_id) REFERENCES port (id)');
        $this->addSql('ALTER TABLE tarif_port ADD CONSTRAINT FK_A1507125141EAE06 FOREIGN KEY (port_arrivee_id) REFERENCES port (id)');
        $this->addSql('ALTER TABLE expedition ADD port_depart_id INT DEFAULT NULL, ADD port_arrivee_id INT DEFAULT NULL, DROP port_depart, DROP port_arrivee');
        $this->addSql('ALTER TABLE expedition ADD CONSTRAINT FK_692907E94C9CCD3 FOREIGN KEY (port_depart_id) REFERENCES port (id)');
        $this->addSql('ALTER TABLE expedition ADD CONSTRAINT FK_692907E141EAE06 FOREIGN KEY (port_arrivee_id) REFERENCES port (id)');
        $this->addSql('CREATE INDEX IDX_692907E94C9CCD3 ON expedition (port_depart_id)');
        $this->addSql('CREATE INDEX IDX_692907E141EAE06 ON expedition (port_arrivee_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tarif_port DROP FOREIGN KEY FK_A150712594C9CCD3');
        $this->addSql('ALTER TABLE tarif_port DROP FOREIGN KEY FK_A1507125141EAE06');
        $this->addSql('DROP TABLE port');
        $this->addSql('DROP TABLE tarif_port');
        $this->addSql('ALTER TABLE expedition DROP FOREIGN KEY FK_692907E94C9CCD3');
        $this->addSql('ALTER TABLE expedition DROP FOREIGN KEY FK_692907E141EAE06');
        $this->addSql('DROP INDEX IDX_692907E94C9CCD3 ON expedition');
        $this->addSql('DROP INDEX IDX_692907E141EAE06 ON expedition');
        $this->addSql('ALTER TABLE expedition ADD port_depart VARCHAR(100) NOT NULL, ADD port_arrivee VARCHAR(100) NOT NULL, DROP port_depart_id, DROP port_arrivee_id');
    }
}
