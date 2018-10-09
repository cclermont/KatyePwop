<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181009155142 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE location_location (id INT AUTO_INCREMENT NOT NULL, city VARCHAR(128) NOT NULL, country VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_video (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, format VARCHAR(8) NOT NULL, mime_type VARCHAR(128) NOT NULL, size INT NOT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, length INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_message (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, status INT NOT NULL, created DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_image (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, format VARCHAR(8) NOT NULL, mime_type VARCHAR(128) NOT NULL, size INT NOT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_session_history (id INT AUTO_INCREMENT NOT NULL, ip VARCHAR(32) NOT NULL, context VARCHAR(64) NOT NULL, system VARCHAR(32) NOT NULL, device_name VARCHAR(64) NOT NULL, device_version VARCHAR(8) NOT NULL, opened DATETIME NOT NULL, closed DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(64) NOT NULL, blocked TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_image (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, format VARCHAR(8) NOT NULL, mime_type VARCHAR(128) NOT NULL, size INT NOT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(64) NOT NULL COLLATE utf8mb4_unicode_ci, blocked TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE location_location');
        $this->addSql('DROP TABLE message_video');
        $this->addSql('DROP TABLE message_message');
        $this->addSql('DROP TABLE message_image');
        $this->addSql('DROP TABLE user_session_history');
        $this->addSql('DROP TABLE user_user');
        $this->addSql('DROP TABLE user_image');
    }
}
