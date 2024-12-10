<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241210102549 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contribution (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, projet_id INT DEFAULT NULL, montant NUMERIC(10, 2) NOT NULL, date DATETIME NOT NULL, INDEX IDX_EA351E15FB88E14F (utilisateur_id), INDEX IDX_EA351E15C18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contribution ADD CONSTRAINT FK_EA351E15FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE contribution ADD CONSTRAINT FK_EA351E15C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contribution DROP FOREIGN KEY FK_EA351E15FB88E14F');
        $this->addSql('ALTER TABLE contribution DROP FOREIGN KEY FK_EA351E15C18272');
        $this->addSql('DROP TABLE contribution');
    }
}
