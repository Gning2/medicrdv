<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221021211805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plage_horaire ADD hd VARCHAR(255) DEFAULT NULL, ADD hf VARCHAR(255) DEFAULT NULL, DROP hdlundi, DROP hflundi, DROP hdmardi, DROP hfmardi, DROP hdmercredi, DROP hfmercredi, DROP hdjeudi, DROP hfjeudi, DROP hdvendredi, DROP hfvendredi, DROP hdsamedi, DROP hfsamedi');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plage_horaire ADD hdlundi VARCHAR(255) DEFAULT NULL, ADD hflundi VARCHAR(255) DEFAULT NULL, ADD hdmardi VARCHAR(255) DEFAULT NULL, ADD hfmardi VARCHAR(255) DEFAULT NULL, ADD hdmercredi VARCHAR(255) DEFAULT NULL, ADD hfmercredi VARCHAR(255) DEFAULT NULL, ADD hdjeudi VARCHAR(255) DEFAULT NULL, ADD hfjeudi VARCHAR(255) DEFAULT NULL, ADD hdvendredi VARCHAR(255) DEFAULT NULL, ADD hfvendredi VARCHAR(255) DEFAULT NULL, ADD hdsamedi VARCHAR(255) DEFAULT NULL, ADD hfsamedi VARCHAR(255) DEFAULT NULL, DROP hd, DROP hf');
    }
}
