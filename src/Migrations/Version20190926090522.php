<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190926090522 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE events (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, event_name VARCHAR(255) NOT NULL, event_type INT NOT NULL, event_way INT NOT NULL, event_address VARCHAR(255) NOT NULL, event_start_time DATETIME NOT NULL, event_end_time DATETIME NOT NULL, lector_id INT NOT NULL, event_photos VARCHAR(255) DEFAULT NULL, event_description LONGTEXT DEFAULT NULL, is_free TINYINT(1) DEFAULT NULL, price INT DEFAULT NULL, is_discount TINYINT(1) DEFAULT NULL, rule_point INT DEFAULT NULL, rule_sertificate TINYINT(1) DEFAULT NULL, event_main_img VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE events');
    }
}
