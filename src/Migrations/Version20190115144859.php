<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190115144859 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE accident (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT NOT NULL, details VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, deaths INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_8F31DB6F545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accident_user (accident_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A333737516D8554C (accident_id), INDEX IDX_A3337375A76ED395 (user_id), PRIMARY KEY(accident_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT NOT NULL, pumped_at DATETIME DEFAULT NULL, merter_reading NUMERIC(10, 2) DEFAULT NULL, qty_pumped NUMERIC(10, 2) DEFAULT NULL, price_per_gallon NUMERIC(10, 2) DEFAULT NULL, cost NUMERIC(10, 2) DEFAULT NULL, last_mileage NUMERIC(10, 2) DEFAULT NULL, driver_id INT DEFAULT NULL, INDEX IDX_31BD6FE9545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT NOT NULL, date DATETIME NOT NULL, supplier VARCHAR(255) NOT NULL, cost NUMERIC(10, 2) DEFAULT NULL, pay_ref VARCHAR(255) NOT NULL, remarks LONGTEXT NOT NULL, INDEX IDX_2F84F8E9545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repair (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT NOT NULL, date DATETIME NOT NULL, supplier VARCHAR(255) NOT NULL, payment_ref VARCHAR(255) DEFAULT NULL, cost NUMERIC(10, 2) DEFAULT NULL, remarks LONGTEXT NOT NULL, INDEX IDX_8EE43421545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, institution_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, reg_no VARCHAR(10) DEFAULT NULL, institution_id INT NOT NULL, reg_date DATE DEFAULT NULL, cost NUMERIC(13, 2) DEFAULT NULL, make VARCHAR(255) DEFAULT NULL, model VARCHAR(255) DEFAULT NULL, assigned_driver_id INT DEFAULT NULL, INDEX IDX_1B80E48612469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location_location (id INT AUTO_INCREMENT NOT NULL, institution_id INT DEFAULT NULL, fullname VARCHAR(255) DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, region VARCHAR(64) DEFAULT NULL, city VARCHAR(128) NOT NULL, state VARCHAR(64) DEFAULT NULL, country VARCHAR(64) NOT NULL, latitude VARCHAR(32) DEFAULT NULL, longitude VARCHAR(32) DEFAULT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, INDEX IDX_8FCBAB2910405986 (institution_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_message (id INT AUTO_INCREMENT NOT NULL, sender_id INT DEFAULT NULL, sender_institution_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, status INT NOT NULL, broadcasted TINYINT(1) NOT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, INDEX IDX_26350A73F624B39D (sender_id), INDEX IDX_26350A73C1ACA445 (sender_institution_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_message_location_join (message_id INT NOT NULL, location_id INT NOT NULL, INDEX IDX_49C7D981537A1329 (message_id), INDEX IDX_49C7D98164D218E (location_id), PRIMARY KEY(message_id, location_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_message_institution_join (message_id INT NOT NULL, institution_id INT NOT NULL, INDEX IDX_9EB87EC7537A1329 (message_id), UNIQUE INDEX UNIQ_9EB87EC710405986 (institution_id), PRIMARY KEY(message_id, institution_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_user (id INT AUTO_INCREMENT NOT NULL, profile_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', created DATETIME NOT NULL, modified DATETIME NOT NULL, UNIQUE INDEX UNIQ_F7129A8092FC23A8 (username_canonical), UNIQUE INDEX UNIQ_F7129A80A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_F7129A80C05FB297 (confirmation_token), UNIQUE INDEX UNIQ_F7129A80CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution_institution (id INT AUTO_INCREMENT NOT NULL, mayor_id INT DEFAULT NULL, address_id INT DEFAULT NULL, image_id INT DEFAULT NULL, admin_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, slogan VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, website VARCHAR(255) NOT NULL, type INT NOT NULL, enabled TINYINT(1) NOT NULL, all_location_access TINYINT(1) NOT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, UNIQUE INDEX UNIQ_5C7FD7DA6C74E5F2 (mayor_id), UNIQUE INDEX UNIQ_5C7FD7DAF5B7AF75 (address_id), UNIQUE INDEX UNIQ_5C7FD7DA3DA5256D (image_id), UNIQUE INDEX UNIQ_5C7FD7DA642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution_institution_user_join (institution_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B62C068C10405986 (institution_id), UNIQUE INDEX UNIQ_B62C068CA76ED395 (user_id), PRIMARY KEY(institution_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE oauth2_access_token (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_454D96735F37A13B (token), INDEX IDX_454D967319EB6921 (client_id), INDEX IDX_454D9673A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM');
        $this->addSql('CREATE TABLE oauth2_client (id INT AUTO_INCREMENT NOT NULL, random_id VARCHAR(255) NOT NULL, redirect_uris LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', secret VARCHAR(255) NOT NULL, allowed_grant_types LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM');
        $this->addSql('CREATE TABLE oauth2_refresh_token (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_4DD907325F37A13B (token), INDEX IDX_4DD9073219EB6921 (client_id), INDEX IDX_4DD90732A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM');
        $this->addSql('CREATE TABLE oauth2_auth_code (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, user_id INT DEFAULT NULL, token VARCHAR(255) NOT NULL, redirect_uri LONGTEXT NOT NULL, expires_at INT DEFAULT NULL, scope VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1D2905B55F37A13B (token), INDEX IDX_1D2905B519EB6921 (client_id), INDEX IDX_1D2905B5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = MyISAM');
        $this->addSql('CREATE TABLE message_video (id INT AUTO_INCREMENT NOT NULL, message_id INT DEFAULT NULL, length INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, info_name VARCHAR(255) DEFAULT NULL, info_original_name VARCHAR(255) DEFAULT NULL, info_mime_type VARCHAR(255) DEFAULT NULL, info_size INT DEFAULT NULL, info_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_836125C7537A1329 (message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_image (id INT AUTO_INCREMENT NOT NULL, message_id INT DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, info_name VARCHAR(255) DEFAULT NULL, info_original_name VARCHAR(255) DEFAULT NULL, info_mime_type VARCHAR(255) DEFAULT NULL, info_size INT DEFAULT NULL, info_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', INDEX IDX_3A9BFBB4537A1329 (message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_session_history (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, place_id INT DEFAULT NULL, ip VARCHAR(32) NOT NULL, context VARCHAR(64) NOT NULL, system VARCHAR(32) NOT NULL, device_name VARCHAR(64) NOT NULL, device_version VARCHAR(8) NOT NULL, opened DATETIME NOT NULL, closed DATETIME DEFAULT NULL, INDEX IDX_27BE9E9EA76ED395 (user_id), UNIQUE INDEX UNIQ_27BE9E9EDA6A219 (place_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_profile (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, notification_id INT DEFAULT NULL, location_id INT DEFAULT NULL, firstname VARCHAR(128) DEFAULT NULL, lastname VARCHAR(128) DEFAULT NULL, gender VARCHAR(16) DEFAULT NULL, birthdate DATE DEFAULT NULL, phone VARCHAR(32) DEFAULT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, UNIQUE INDEX UNIQ_D95AB4053DA5256D (image_id), UNIQUE INDEX UNIQ_D95AB405EF1A9D84 (notification_id), INDEX IDX_D95AB40564D218E (location_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_notification (id INT AUTO_INCREMENT NOT NULL, firebase_android_token VARCHAR(255) DEFAULT NULL, firebase_ios_token VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_image (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, info_name VARCHAR(255) DEFAULT NULL, info_original_name VARCHAR(255) DEFAULT NULL, info_mime_type VARCHAR(255) DEFAULT NULL, info_size INT DEFAULT NULL, info_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution_person (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(128) NOT NULL, lastname VARCHAR(128) NOT NULL, phone VARCHAR(32) DEFAULT NULL, email VARCHAR(64) DEFAULT NULL, bio LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution_image (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, info_name VARCHAR(255) DEFAULT NULL, info_original_name VARCHAR(255) DEFAULT NULL, info_mime_type VARCHAR(255) DEFAULT NULL, info_size INT DEFAULT NULL, info_dimensions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accident ADD CONSTRAINT FK_8F31DB6F545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE accident_user ADD CONSTRAINT FK_A333737516D8554C FOREIGN KEY (accident_id) REFERENCES accident (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE accident_user ADD CONSTRAINT FK_A3337375A76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fuel ADD CONSTRAINT FK_31BD6FE9545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E9545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE repair ADD CONSTRAINT FK_8EE43421545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E48612469DE2 FOREIGN KEY (category_id) REFERENCES vehicle_category (id)');
        $this->addSql('ALTER TABLE location_location ADD CONSTRAINT FK_8FCBAB2910405986 FOREIGN KEY (institution_id) REFERENCES institution_institution (id)');
        $this->addSql('ALTER TABLE message_message ADD CONSTRAINT FK_26350A73F624B39D FOREIGN KEY (sender_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE message_message ADD CONSTRAINT FK_26350A73C1ACA445 FOREIGN KEY (sender_institution_id) REFERENCES institution_institution (id)');
        $this->addSql('ALTER TABLE message_message_location_join ADD CONSTRAINT FK_49C7D981537A1329 FOREIGN KEY (message_id) REFERENCES message_message (id)');
        $this->addSql('ALTER TABLE message_message_location_join ADD CONSTRAINT FK_49C7D98164D218E FOREIGN KEY (location_id) REFERENCES location_location (id)');
        $this->addSql('ALTER TABLE message_message_institution_join ADD CONSTRAINT FK_9EB87EC7537A1329 FOREIGN KEY (message_id) REFERENCES message_message (id)');
        $this->addSql('ALTER TABLE message_message_institution_join ADD CONSTRAINT FK_9EB87EC710405986 FOREIGN KEY (institution_id) REFERENCES institution_institution (id)');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80CCFA12B8 FOREIGN KEY (profile_id) REFERENCES user_profile (id)');
        $this->addSql('ALTER TABLE institution_institution ADD CONSTRAINT FK_5C7FD7DA6C74E5F2 FOREIGN KEY (mayor_id) REFERENCES institution_person (id)');
        $this->addSql('ALTER TABLE institution_institution ADD CONSTRAINT FK_5C7FD7DAF5B7AF75 FOREIGN KEY (address_id) REFERENCES location_location (id)');
        $this->addSql('ALTER TABLE institution_institution ADD CONSTRAINT FK_5C7FD7DA3DA5256D FOREIGN KEY (image_id) REFERENCES institution_image (id)');
        $this->addSql('ALTER TABLE institution_institution ADD CONSTRAINT FK_5C7FD7DA642B8210 FOREIGN KEY (admin_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE institution_institution_user_join ADD CONSTRAINT FK_B62C068C10405986 FOREIGN KEY (institution_id) REFERENCES institution_institution (id)');
        $this->addSql('ALTER TABLE institution_institution_user_join ADD CONSTRAINT FK_B62C068CA76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE oauth2_access_token ADD CONSTRAINT FK_454D967319EB6921 FOREIGN KEY (client_id) REFERENCES oauth2_client (id)');
        $this->addSql('ALTER TABLE oauth2_access_token ADD CONSTRAINT FK_454D9673A76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE oauth2_refresh_token ADD CONSTRAINT FK_4DD9073219EB6921 FOREIGN KEY (client_id) REFERENCES oauth2_client (id)');
        $this->addSql('ALTER TABLE oauth2_refresh_token ADD CONSTRAINT FK_4DD90732A76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE oauth2_auth_code ADD CONSTRAINT FK_1D2905B519EB6921 FOREIGN KEY (client_id) REFERENCES oauth2_client (id)');
        $this->addSql('ALTER TABLE oauth2_auth_code ADD CONSTRAINT FK_1D2905B5A76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE message_video ADD CONSTRAINT FK_836125C7537A1329 FOREIGN KEY (message_id) REFERENCES message_message (id)');
        $this->addSql('ALTER TABLE message_image ADD CONSTRAINT FK_3A9BFBB4537A1329 FOREIGN KEY (message_id) REFERENCES message_message (id)');
        $this->addSql('ALTER TABLE user_session_history ADD CONSTRAINT FK_27BE9E9EA76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE user_session_history ADD CONSTRAINT FK_27BE9E9EDA6A219 FOREIGN KEY (place_id) REFERENCES location_location (id)');
        $this->addSql('ALTER TABLE user_profile ADD CONSTRAINT FK_D95AB4053DA5256D FOREIGN KEY (image_id) REFERENCES user_image (id)');
        $this->addSql('ALTER TABLE user_profile ADD CONSTRAINT FK_D95AB405EF1A9D84 FOREIGN KEY (notification_id) REFERENCES user_notification (id)');
        $this->addSql('ALTER TABLE user_profile ADD CONSTRAINT FK_D95AB40564D218E FOREIGN KEY (location_id) REFERENCES location_location (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE accident_user DROP FOREIGN KEY FK_A333737516D8554C');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E48612469DE2');
        $this->addSql('ALTER TABLE accident DROP FOREIGN KEY FK_8F31DB6F545317D1');
        $this->addSql('ALTER TABLE fuel DROP FOREIGN KEY FK_31BD6FE9545317D1');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E9545317D1');
        $this->addSql('ALTER TABLE repair DROP FOREIGN KEY FK_8EE43421545317D1');
        $this->addSql('ALTER TABLE message_message_location_join DROP FOREIGN KEY FK_49C7D98164D218E');
        $this->addSql('ALTER TABLE institution_institution DROP FOREIGN KEY FK_5C7FD7DAF5B7AF75');
        $this->addSql('ALTER TABLE user_session_history DROP FOREIGN KEY FK_27BE9E9EDA6A219');
        $this->addSql('ALTER TABLE user_profile DROP FOREIGN KEY FK_D95AB40564D218E');
        $this->addSql('ALTER TABLE message_message_location_join DROP FOREIGN KEY FK_49C7D981537A1329');
        $this->addSql('ALTER TABLE message_message_institution_join DROP FOREIGN KEY FK_9EB87EC7537A1329');
        $this->addSql('ALTER TABLE message_video DROP FOREIGN KEY FK_836125C7537A1329');
        $this->addSql('ALTER TABLE message_image DROP FOREIGN KEY FK_3A9BFBB4537A1329');
        $this->addSql('ALTER TABLE accident_user DROP FOREIGN KEY FK_A3337375A76ED395');
        $this->addSql('ALTER TABLE message_message DROP FOREIGN KEY FK_26350A73F624B39D');
        $this->addSql('ALTER TABLE institution_institution DROP FOREIGN KEY FK_5C7FD7DA642B8210');
        $this->addSql('ALTER TABLE institution_institution_user_join DROP FOREIGN KEY FK_B62C068CA76ED395');
        $this->addSql('ALTER TABLE oauth2_access_token DROP FOREIGN KEY FK_454D9673A76ED395');
        $this->addSql('ALTER TABLE oauth2_refresh_token DROP FOREIGN KEY FK_4DD90732A76ED395');
        $this->addSql('ALTER TABLE oauth2_auth_code DROP FOREIGN KEY FK_1D2905B5A76ED395');
        $this->addSql('ALTER TABLE user_session_history DROP FOREIGN KEY FK_27BE9E9EA76ED395');
        $this->addSql('ALTER TABLE location_location DROP FOREIGN KEY FK_8FCBAB2910405986');
        $this->addSql('ALTER TABLE message_message DROP FOREIGN KEY FK_26350A73C1ACA445');
        $this->addSql('ALTER TABLE message_message_institution_join DROP FOREIGN KEY FK_9EB87EC710405986');
        $this->addSql('ALTER TABLE institution_institution_user_join DROP FOREIGN KEY FK_B62C068C10405986');
        $this->addSql('ALTER TABLE oauth2_access_token DROP FOREIGN KEY FK_454D967319EB6921');
        $this->addSql('ALTER TABLE oauth2_refresh_token DROP FOREIGN KEY FK_4DD9073219EB6921');
        $this->addSql('ALTER TABLE oauth2_auth_code DROP FOREIGN KEY FK_1D2905B519EB6921');
        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A80CCFA12B8');
        $this->addSql('ALTER TABLE user_profile DROP FOREIGN KEY FK_D95AB405EF1A9D84');
        $this->addSql('ALTER TABLE user_profile DROP FOREIGN KEY FK_D95AB4053DA5256D');
        $this->addSql('ALTER TABLE institution_institution DROP FOREIGN KEY FK_5C7FD7DA6C74E5F2');
        $this->addSql('ALTER TABLE institution_institution DROP FOREIGN KEY FK_5C7FD7DA3DA5256D');
        $this->addSql('DROP TABLE accident');
        $this->addSql('DROP TABLE accident_user');
        $this->addSql('DROP TABLE fuel');
        $this->addSql('DROP TABLE maintenance');
        $this->addSql('DROP TABLE repair');
        $this->addSql('DROP TABLE vehicle_category');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE location_location');
        $this->addSql('DROP TABLE message_message');
        $this->addSql('DROP TABLE message_message_location_join');
        $this->addSql('DROP TABLE message_message_institution_join');
        $this->addSql('DROP TABLE user_user');
        $this->addSql('DROP TABLE institution_institution');
        $this->addSql('DROP TABLE institution_institution_user_join');
        $this->addSql('DROP TABLE oauth2_access_token');
        $this->addSql('DROP TABLE oauth2_client');
        $this->addSql('DROP TABLE oauth2_refresh_token');
        $this->addSql('DROP TABLE oauth2_auth_code');
        $this->addSql('DROP TABLE message_video');
        $this->addSql('DROP TABLE message_image');
        $this->addSql('DROP TABLE user_session_history');
        $this->addSql('DROP TABLE user_profile');
        $this->addSql('DROP TABLE user_notification');
        $this->addSql('DROP TABLE user_image');
        $this->addSql('DROP TABLE institution_person');
        $this->addSql('DROP TABLE institution_image');
    }
}
