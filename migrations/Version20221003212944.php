<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221003212944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendez_vous ADD sexe VARCHAR(255) NOT NULL, ADD date_actuelle VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD sexe VARCHAR(255) NOT NULL, ADD date_actuelle VARCHAR(255) NOT NULL, CHANGE matricule matricule VARCHAR(255) NOT NULL, CHANGE numero_patient numero_patient VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rendez_vous DROP sexe, DROP date_actuelle');
        $this->addSql('ALTER TABLE user DROP sexe, DROP date_actuelle, CHANGE matricule matricule VARCHAR(255) DEFAULT NULL, CHANGE numero_patient numero_patient VARCHAR(255) DEFAULT NULL');
    }
}
