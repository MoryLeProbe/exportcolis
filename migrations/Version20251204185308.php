<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251204185308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP INDEX UNIQ_470BDFF9F55AE19E ON colis');
        $this->addSql('ALTER TABLE expedition DROP FOREIGN KEY `FK_692907E141EAE06`');
        $this->addSql('ALTER TABLE expedition DROP FOREIGN KEY `FK_692907E94C9CCD3`');
        $this->addSql('DROP INDEX IDX_692907E141EAE06 ON expedition');
        $this->addSql('DROP INDEX IDX_692907E94C9CCD3 ON expedition');
        $this->addSql('ALTER TABLE expedition ADD port_depart VARCHAR(100) NOT NULL, ADD port_arrivee VARCHAR(100) NOT NULL, DROP port_depart_id, DROP port_arrivee_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, roles JSON NOT NULL, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_0900_ai_ci`, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_470BDFF9F55AE19E ON colis (numero)');
        $this->addSql('ALTER TABLE expedition ADD port_depart_id INT DEFAULT NULL, ADD port_arrivee_id INT DEFAULT NULL, DROP port_depart, DROP port_arrivee');
        $this->addSql('ALTER TABLE expedition ADD CONSTRAINT `FK_692907E141EAE06` FOREIGN KEY (port_arrivee_id) REFERENCES port (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE expedition ADD CONSTRAINT `FK_692907E94C9CCD3` FOREIGN KEY (port_depart_id) REFERENCES port (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_692907E141EAE06 ON expedition (port_arrivee_id)');
        $this->addSql('CREATE INDEX IDX_692907E94C9CCD3 ON expedition (port_depart_id)');
    }
}
