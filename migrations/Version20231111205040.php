<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231111205040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appros (id INT AUTO_INCREMENT NOT NULL, nom_fornisseur_id INT NOT NULL, nom_produit_id INT NOT NULL, quantite INT NOT NULL, prix INT NOT NULL, date_appros DATE DEFAULT NULL, INDEX IDX_9C9BD6DF20383B4E (nom_fornisseur_id), INDEX IDX_9C9BD6DFE7BFE8C (nom_produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commandes (id INT AUTO_INCREMENT NOT NULL, non_client_id INT NOT NULL, nom_produit_id INT NOT NULL, date_commande DATE NOT NULL, quantite INT NOT NULL, INDEX IDX_35D4282C14F87E61 (non_client_id), INDEX IDX_35D4282CE7BFE8C (nom_produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ventes (id INT AUTO_INCREMENT NOT NULL, nom_produit_id INT NOT NULL, nom_client_id INT DEFAULT NULL, quantite INT NOT NULL, prix INT NOT NULL, date_vente DATE NOT NULL, INDEX IDX_64EC489AE7BFE8C (nom_produit_id), INDEX IDX_64EC489A8D1A1860 (nom_client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appros ADD CONSTRAINT FK_9C9BD6DF20383B4E FOREIGN KEY (nom_fornisseur_id) REFERENCES fournisseurs (id)');
        $this->addSql('ALTER TABLE appros ADD CONSTRAINT FK_9C9BD6DFE7BFE8C FOREIGN KEY (nom_produit_id) REFERENCES produits (id)');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282C14F87E61 FOREIGN KEY (non_client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282CE7BFE8C FOREIGN KEY (nom_produit_id) REFERENCES produits (id)');
        $this->addSql('ALTER TABLE ventes ADD CONSTRAINT FK_64EC489AE7BFE8C FOREIGN KEY (nom_produit_id) REFERENCES produits (id)');
        $this->addSql('ALTER TABLE ventes ADD CONSTRAINT FK_64EC489A8D1A1860 FOREIGN KEY (nom_client_id) REFERENCES clients (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appros DROP FOREIGN KEY FK_9C9BD6DF20383B4E');
        $this->addSql('ALTER TABLE appros DROP FOREIGN KEY FK_9C9BD6DFE7BFE8C');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282C14F87E61');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282CE7BFE8C');
        $this->addSql('ALTER TABLE ventes DROP FOREIGN KEY FK_64EC489AE7BFE8C');
        $this->addSql('ALTER TABLE ventes DROP FOREIGN KEY FK_64EC489A8D1A1860');
        $this->addSql('DROP TABLE appros');
        $this->addSql('DROP TABLE commandes');
        $this->addSql('DROP TABLE ventes');
    }
}
