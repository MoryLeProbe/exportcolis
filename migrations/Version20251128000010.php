<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251128000010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, telephone VARCHAR(20) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE colis (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(50) NOT NULL, poids DOUBLE PRECISION NOT NULL, type VARCHAR(50) NOT NULL, contenu LONGTEXT DEFAULT NULL, prix NUMERIC(10, 2) NOT NULL, statut VARCHAR(30) NOT NULL, photo VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, client_id INT NOT NULL, destinataire_id INT NOT NULL, expedition_id INT DEFAULT NULL, INDEX IDX_470BDFF919EB6921 (client_id), INDEX IDX_470BDFF9A4F84F6E (destinataire_id), INDEX IDX_470BDFF9576EF81E (expedition_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE destinataire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, telephone VARCHAR(20) DEFAULT NULL, adresse VARCHAR(255) NOT NULL, ville VARCHAR(100) NOT NULL, pays VARCHAR(100) NOT NULL, code_postal VARCHAR(20) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE expedition (id INT AUTO_INCREMENT NOT NULL, numero VARCHAR(50) NOT NULL, type VARCHAR(20) NOT NULL, date_depart DATE NOT NULL, date_arrivee_prevue DATE NOT NULL, date_arrivee_reelle DATE DEFAULT NULL, port_depart VARCHAR(100) NOT NULL, port_arrivee VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE historique_colis (id INT AUTO_INCREMENT NOT NULL, statut VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, date_action DATETIME NOT NULL, colis_id INT NOT NULL, INDEX IDX_98B058A4D268D70 (colis_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, montant NUMERIC(10, 2) NOT NULL, mode VARCHAR(30) NOT NULL, statut VARCHAR(30) NOT NULL, date_paiement DATETIME NOT NULL, colis_id INT NOT NULL, UNIQUE INDEX UNIQ_B1DC7A1E4D268D70 (colis_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(150) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE colis ADD CONSTRAINT FK_470BDFF919EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE colis ADD CONSTRAINT FK_470BDFF9A4F84F6E FOREIGN KEY (destinataire_id) REFERENCES destinataire (id)');
        $this->addSql('ALTER TABLE colis ADD CONSTRAINT FK_470BDFF9576EF81E FOREIGN KEY (expedition_id) REFERENCES expedition (id)');
        $this->addSql('ALTER TABLE historique_colis ADD CONSTRAINT FK_98B058A4D268D70 FOREIGN KEY (colis_id) REFERENCES colis (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E4D268D70 FOREIGN KEY (colis_id) REFERENCES colis (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE colis DROP FOREIGN KEY FK_470BDFF919EB6921');
        $this->addSql('ALTER TABLE colis DROP FOREIGN KEY FK_470BDFF9A4F84F6E');
        $this->addSql('ALTER TABLE colis DROP FOREIGN KEY FK_470BDFF9576EF81E');
        $this->addSql('ALTER TABLE historique_colis DROP FOREIGN KEY FK_98B058A4D268D70');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E4D268D70');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE colis');
        $this->addSql('DROP TABLE destinataire');
        $this->addSql('DROP TABLE expedition');
        $this->addSql('DROP TABLE historique_colis');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
