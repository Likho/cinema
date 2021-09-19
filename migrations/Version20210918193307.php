<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210918193307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking ADD reference_number VARCHAR(64) NOT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE7E7C9F15 FOREIGN KEY (movie_time_id) REFERENCES movie_times (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE7E7C9F15 ON booking (movie_time_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE7E7C9F15');
        $this->addSql('DROP INDEX IDX_E00CEDDE7E7C9F15 ON booking');
        $this->addSql('ALTER TABLE booking DROP reference_number');
    }
}
