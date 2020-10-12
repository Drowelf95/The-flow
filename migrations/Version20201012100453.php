<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201012100453 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE segments (id INT AUTO_INCREMENT NOT NULL, part INT NOT NULL, title1 VARCHAR(255) NOT NULL, message1 LONGTEXT NOT NULL, link1 LONGTEXT NOT NULL, title2 VARCHAR(255) NOT NULL, message2 LONGTEXT NOT NULL, link2 LONGTEXT DEFAULT NULL, link_s1 LONGTEXT DEFAULT NULL, link_s2 LONGTEXT DEFAULT NULL, link_s3 LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE segments');
    }
}
