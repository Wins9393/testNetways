<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201004121302 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livres CHANGE date_edition date_edition VARCHAR(20) NOT NULL, CHANGE date_ajout date_ajout VARCHAR(20) DEFAULT \'CURRENT_TIMESTAMP\' NOT NULL, CHANGE date_modif date_modif VARCHAR(20) DEFAULT \'CURRENT_TIMESTAMP\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livres CHANGE date_edition date_edition DATETIME NOT NULL, CHANGE date_ajout date_ajout DATETIME NOT NULL, CHANGE date_modif date_modif DATETIME NOT NULL');
    }
}
