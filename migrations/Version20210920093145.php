<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210920093145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bookings (id INT AUTO_INCREMENT NOT NULL, movie_time_id INT NOT NULL, user_id INT NOT NULL, number_of_tickets INT NOT NULL, reference_number VARCHAR(64) NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_7A853C35A76ED395 (user_id), INDEX IDX_7A853C357E7C9F15 (movie_time_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cinemas (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie_dates (id INT AUTO_INCREMENT NOT NULL, movie_id INT NOT NULL, date DATE NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D536D3828F93B6FC (movie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie_times (id INT AUTO_INCREMENT NOT NULL, theater_id INT NOT NULL, movie_date_id INT NOT NULL, time TIME NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', tickets_booked INT NOT NULL, INDEX IDX_6395F41098017445 (movie_date_id), INDEX IDX_6395F410D70E4479 (theater_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movies (id INT AUTO_INCREMENT NOT NULL, cinema_id INT NOT NULL, theater_id INT NOT NULL, title VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, age_restriction VARCHAR(16) NOT NULL, duration INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C61EED30B4CB84B6 (cinema_id), INDEX IDX_C61EED30D70E4479 (theater_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theaters (id INT AUTO_INCREMENT NOT NULL, cinema_id INT NOT NULL, name VARCHAR(64) NOT NULL, max_seats INT NOT NULL, INDEX IDX_774E8767B4CB84B6 (cinema_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT FK_7A853C35A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE bookings ADD CONSTRAINT FK_7A853C357E7C9F15 FOREIGN KEY (movie_time_id) REFERENCES movie_times (id)');
        $this->addSql('ALTER TABLE movie_dates ADD CONSTRAINT FK_D536D3828F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id)');
        $this->addSql('ALTER TABLE movie_times ADD CONSTRAINT FK_6395F41098017445 FOREIGN KEY (movie_date_id) REFERENCES movie_dates (id)');
        $this->addSql('ALTER TABLE movie_times ADD CONSTRAINT FK_6395F410D70E4479 FOREIGN KEY (theater_id) REFERENCES theaters (id)');
        $this->addSql('ALTER TABLE movies ADD CONSTRAINT FK_C61EED30B4CB84B6 FOREIGN KEY (cinema_id) REFERENCES cinemas (id)');
        $this->addSql('ALTER TABLE movies ADD CONSTRAINT FK_C61EED30D70E4479 FOREIGN KEY (theater_id) REFERENCES theaters (id)');
        $this->addSql('ALTER TABLE theaters ADD CONSTRAINT FK_774E8767B4CB84B6 FOREIGN KEY (cinema_id) REFERENCES cinemas (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movies DROP FOREIGN KEY FK_C61EED30B4CB84B6');
        $this->addSql('ALTER TABLE theaters DROP FOREIGN KEY FK_774E8767B4CB84B6');
        $this->addSql('ALTER TABLE movie_times DROP FOREIGN KEY FK_6395F41098017445');
        $this->addSql('ALTER TABLE bookings DROP FOREIGN KEY FK_7A853C357E7C9F15');
        $this->addSql('ALTER TABLE movie_dates DROP FOREIGN KEY FK_D536D3828F93B6FC');
        $this->addSql('ALTER TABLE movie_times DROP FOREIGN KEY FK_6395F410D70E4479');
        $this->addSql('ALTER TABLE movies DROP FOREIGN KEY FK_C61EED30D70E4479');
        $this->addSql('ALTER TABLE bookings DROP FOREIGN KEY FK_7A853C35A76ED395');
        $this->addSql('DROP TABLE bookings');
        $this->addSql('DROP TABLE cinemas');
        $this->addSql('DROP TABLE movie_dates');
        $this->addSql('DROP TABLE movie_times');
        $this->addSql('DROP TABLE movies');
        $this->addSql('DROP TABLE theaters');
        $this->addSql('DROP TABLE users');
    }
}
