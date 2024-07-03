<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240627145514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, prix INT NOT NULL, ville VARCHAR(200) NOT NULL, code_postal VARCHAR(6) NOT NULL, dpe VARCHAR(1) NOT NULL, surface INT NOT NULL, nbr_piece INT NOT NULL, is_exclusive TINYINT(1) NOT NULL, is_rental TINYINT(1) NOT NULL, date_publication DATE NOT NULL, INDEX IDX_F65593E5BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce_agence (annonce_id INT NOT NULL, agence_id INT NOT NULL, INDEX IDX_46699B78805AB2F (annonce_id), INDEX IDX_46699B7D725330D (agence_id), PRIMARY KEY(annonce_id, agence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce_equipement (annonce_id INT NOT NULL, equipement_id INT NOT NULL, INDEX IDX_A6C013708805AB2F (annonce_id), INDEX IDX_A6C01370806F0F5C (equipement_id), PRIMARY KEY(annonce_id, equipement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipement (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(200) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE annonce_agence ADD CONSTRAINT FK_46699B78805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce_agence ADD CONSTRAINT FK_46699B7D725330D FOREIGN KEY (agence_id) REFERENCES agence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce_equipement ADD CONSTRAINT FK_A6C013708805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce_equipement ADD CONSTRAINT FK_A6C01370806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5BCF5E72D');
        $this->addSql('ALTER TABLE annonce_agence DROP FOREIGN KEY FK_46699B78805AB2F');
        $this->addSql('ALTER TABLE annonce_agence DROP FOREIGN KEY FK_46699B7D725330D');
        $this->addSql('ALTER TABLE annonce_equipement DROP FOREIGN KEY FK_A6C013708805AB2F');
        $this->addSql('ALTER TABLE annonce_equipement DROP FOREIGN KEY FK_A6C01370806F0F5C');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE annonce_agence');
        $this->addSql('DROP TABLE annonce_equipement');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE equipement');
    }
}
