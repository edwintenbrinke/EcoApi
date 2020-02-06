<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200206135521 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE offer (id INT AUTO_INCREMENT NOT NULL, store_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, buying TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, max_num_wanted INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_29D6873EB092A811 (store_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, external_id INT NOT NULL, username VARCHAR(255) NOT NULL, auth_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', time_seconds INT NOT NULL, item_type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE harvest (id INT AUTO_INCREMENT NOT NULL, external_id INT NOT NULL, username VARCHAR(255) NOT NULL, time_seconds INT NOT NULL, species_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sell (id INT AUTO_INCREMENT NOT NULL, external_id INT NOT NULL, username VARCHAR(255) NOT NULL, auth_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', time_seconds INT NOT NULL, amount INT NOT NULL, item_type VARCHAR(255) NOT NULL, world_object_type VARCHAR(255) NOT NULL, world_object_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE server (id INT AUTO_INCREMENT NOT NULL, external_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, export_last_process DATETIME DEFAULT NULL, version VARCHAR(255) DEFAULT NULL, time_left INT DEFAULT NULL, time_since_start INT DEFAULT NULL, online_players INT DEFAULT NULL, total_players INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, detailed_description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, external_id INT NOT NULL, slg_id VARCHAR(255) NOT NULL, steam_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, total_play_time INT DEFAULT NULL, last_online_time INT DEFAULT NULL, online TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE play (id INT AUTO_INCREMENT NOT NULL, external_id INT NOT NULL, username VARCHAR(255) NOT NULL, time_seconds INT NOT NULL, value DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE store (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, external_id INT NOT NULL, name VARCHAR(255) NOT NULL, currency_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_FF575877A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE craft (id INT AUTO_INCREMENT NOT NULL, external_id INT NOT NULL, username VARCHAR(255) NOT NULL, auth_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', time_seconds INT NOT NULL, world_object_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', item_type VARCHAR(255) NOT NULL, world_object_type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pickup (id INT AUTO_INCREMENT NOT NULL, external_id INT NOT NULL, username VARCHAR(255) NOT NULL, auth_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', time_seconds INT NOT NULL, item_type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE buy (id INT AUTO_INCREMENT NOT NULL, external_id INT NOT NULL, username VARCHAR(255) NOT NULL, auth_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', time_seconds INT NOT NULL, world_object_id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', item_type VARCHAR(255) NOT NULL, world_object_type VARCHAR(255) NOT NULL, amount INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873EB092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF575877A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF575877A76ED395');
        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873EB092A811');
        $this->addSql('DROP TABLE offer');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE harvest');
        $this->addSql('DROP TABLE sell');
        $this->addSql('DROP TABLE server');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE play');
        $this->addSql('DROP TABLE store');
        $this->addSql('DROP TABLE craft');
        $this->addSql('DROP TABLE pickup');
        $this->addSql('DROP TABLE buy');
    }
}
