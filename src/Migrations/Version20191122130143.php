<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191122130143 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sites_info (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, site_info_name VARCHAR(255) NOT NULL, site_info_station VARCHAR(255) NOT NULL, site_info_worktime VARCHAR(255) NOT NULL, site_info_street VARCHAR(255) NOT NULL, site_info_about LONGTEXT NOT NULL, site_info_logo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sites (id INT AUTO_INCREMENT NOT NULL, site_url VARCHAR(255) NOT NULL, site_phone VARCHAR(255) NOT NULL, site_email VARCHAR(255) NOT NULL, site_banners JSON NOT NULL, site_map LONGTEXT NOT NULL, site_meta_title VARCHAR(255) DEFAULT NULL, site_meta_description VARCHAR(255) DEFAULT NULL, site_analitics_ya LONGTEXT DEFAULT NULL, site_analitics_ga LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sites_review (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, reviewer_name VARCHAR(255) NOT NULL, reviewer_worker_position VARCHAR(255) NOT NULL, reviewer_text LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE sites_info');
        $this->addSql('DROP TABLE sites');
        $this->addSql('DROP TABLE sites_review');
    }
}
