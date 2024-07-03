<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240626134528 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agence_capacite (agence_id INT NOT NULL, capacite_id INT NOT NULL, INDEX IDX_8061EDA6D725330D (agence_id), INDEX IDX_8061EDA67C79189D (capacite_id), PRIMARY KEY(agence_id, capacite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE capacite (id INT AUTO_INCREMENT NOT NULL, capacite VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agence_capacite ADD CONSTRAINT FK_8061EDA6D725330D FOREIGN KEY (agence_id) REFERENCES agence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agence_capacite ADD CONSTRAINT FK_8061EDA67C79189D FOREIGN KEY (capacite_id) REFERENCES capacite (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agence_capacite DROP FOREIGN KEY FK_8061EDA6D725330D');
        $this->addSql('ALTER TABLE agence_capacite DROP FOREIGN KEY FK_8061EDA67C79189D');
        $this->addSql('DROP TABLE agence_capacite');
        $this->addSql('DROP TABLE capacite');
    }
}
