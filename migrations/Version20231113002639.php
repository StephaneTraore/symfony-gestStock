<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231113002639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stocks (id INT AUTO_INCREMENT NOT NULL, nom_produit_id INT NOT NULL, nom_fournisseur_id INT DEFAULT NULL, quantite INT NOT NULL, prix_unitaire INT NOT NULL, date_reception DATE DEFAULT NULL, INDEX IDX_56F79805E7BFE8C (nom_produit_id), INDEX IDX_56F7980570379586 (nom_fournisseur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stocks ADD CONSTRAINT FK_56F79805E7BFE8C FOREIGN KEY (nom_produit_id) REFERENCES produits (id)');
        $this->addSql('ALTER TABLE stocks ADD CONSTRAINT FK_56F7980570379586 FOREIGN KEY (nom_fournisseur_id) REFERENCES fournisseurs (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stocks DROP FOREIGN KEY FK_56F79805E7BFE8C');
        $this->addSql('ALTER TABLE stocks DROP FOREIGN KEY FK_56F7980570379586');
        $this->addSql('DROP TABLE stocks');
    }
}
