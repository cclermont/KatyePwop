<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181014051526 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE oauth2_access_token ADD CONSTRAINT FK_454D967319EB6921 FOREIGN KEY (client_id) REFERENCES oauth2_client (id)');
        $this->addSql('ALTER TABLE oauth2_access_token ADD CONSTRAINT FK_454D9673A76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE oauth2_refresh_token ADD CONSTRAINT FK_4DD9073219EB6921 FOREIGN KEY (client_id) REFERENCES oauth2_client (id)');
        $this->addSql('ALTER TABLE oauth2_refresh_token ADD CONSTRAINT FK_4DD90732A76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE oauth2_auth_code ADD CONSTRAINT FK_1D2905B519EB6921 FOREIGN KEY (client_id) REFERENCES oauth2_client (id)');
        $this->addSql('ALTER TABLE oauth2_auth_code ADD CONSTRAINT FK_1D2905B5A76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE message_video ADD info_name VARCHAR(255) DEFAULT NULL, ADD info_original_name VARCHAR(255) DEFAULT NULL, ADD info_mime_type VARCHAR(255) DEFAULT NULL, ADD info_size INT DEFAULT NULL, ADD info_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', DROP path, DROP format, DROP mime_type, DROP size');
        $this->addSql('ALTER TABLE message_image ADD info_name VARCHAR(255) DEFAULT NULL, ADD info_original_name VARCHAR(255) DEFAULT NULL, ADD info_mime_type VARCHAR(255) DEFAULT NULL, ADD info_size INT DEFAULT NULL, ADD info_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', DROP path, DROP format, DROP mime_type, DROP size');
        $this->addSql('ALTER TABLE user_image ADD info_name VARCHAR(255) DEFAULT NULL, ADD info_original_name VARCHAR(255) DEFAULT NULL, ADD info_mime_type VARCHAR(255) DEFAULT NULL, DROP path, DROP format, DROP mime_type, DROP size, DROP image_name, DROP image_original_name, DROP image_mime_type, CHANGE image_size info_size INT DEFAULT NULL, CHANGE image_dimensions info_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE institution_image ADD info_name VARCHAR(255) DEFAULT NULL, ADD info_original_name VARCHAR(255) DEFAULT NULL, ADD info_mime_type VARCHAR(255) DEFAULT NULL, ADD info_size INT DEFAULT NULL, ADD info_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', DROP path, DROP format, DROP mime_type, DROP size');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE institution_image ADD path VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD format VARCHAR(8) NOT NULL COLLATE utf8mb4_unicode_ci, ADD mime_type VARCHAR(128) NOT NULL COLLATE utf8mb4_unicode_ci, ADD size INT NOT NULL, DROP info_name, DROP info_original_name, DROP info_mime_type, DROP info_size, DROP info_dimensions');
        $this->addSql('ALTER TABLE message_image ADD path VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD format VARCHAR(8) NOT NULL COLLATE utf8mb4_unicode_ci, ADD mime_type VARCHAR(128) NOT NULL COLLATE utf8mb4_unicode_ci, ADD size INT NOT NULL, DROP info_name, DROP info_original_name, DROP info_mime_type, DROP info_size, DROP info_dimensions');
        $this->addSql('ALTER TABLE message_video ADD path VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD format VARCHAR(8) NOT NULL COLLATE utf8mb4_unicode_ci, ADD mime_type VARCHAR(128) NOT NULL COLLATE utf8mb4_unicode_ci, ADD size INT NOT NULL, DROP info_name, DROP info_original_name, DROP info_mime_type, DROP info_size, DROP info_dimensions');
        $this->addSql('ALTER TABLE user_image ADD path VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD format VARCHAR(8) NOT NULL COLLATE utf8mb4_unicode_ci, ADD mime_type VARCHAR(128) NOT NULL COLLATE utf8mb4_unicode_ci, ADD size INT NOT NULL, ADD image_name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD image_original_name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD image_mime_type VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP info_name, DROP info_original_name, DROP info_mime_type, CHANGE info_size image_size INT DEFAULT NULL, CHANGE info_dimensions image_dimensions LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:simple_array)\'');
    }
}
