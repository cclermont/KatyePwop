<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181010210349 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE message_message_institution_join (message_id INT NOT NULL, institution_id INT NOT NULL, INDEX IDX_9EB87EC7537A1329 (message_id), UNIQUE INDEX UNIQ_9EB87EC710405986 (institution_id), PRIMARY KEY(message_id, institution_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_profile (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, firstname VARCHAR(128) NOT NULL, lastname VARCHAR(128) NOT NULL, birthdate DATETIME DEFAULT NULL, gender VARCHAR(16) NOT NULL, UNIQUE INDEX UNIQ_D95AB4053DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution_institution (id INT AUTO_INCREMENT NOT NULL, place_id INT DEFAULT NULL, brand_id INT DEFAULT NULL, admin_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, type INT NOT NULL, enabled TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_5C7FD7DADA6A219 (place_id), UNIQUE INDEX UNIQ_5C7FD7DA44F5D008 (brand_id), INDEX IDX_5C7FD7DA642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution_institution_user_join (institution_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B62C068C10405986 (institution_id), UNIQUE INDEX UNIQ_B62C068CA76ED395 (user_id), PRIMARY KEY(institution_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE institution_image (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, format VARCHAR(8) NOT NULL, mime_type VARCHAR(128) NOT NULL, size INT NOT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_message_institution_join ADD CONSTRAINT FK_9EB87EC7537A1329 FOREIGN KEY (message_id) REFERENCES message_message (id)');
        $this->addSql('ALTER TABLE message_message_institution_join ADD CONSTRAINT FK_9EB87EC710405986 FOREIGN KEY (institution_id) REFERENCES institution_institution (id)');
        $this->addSql('ALTER TABLE user_profile ADD CONSTRAINT FK_D95AB4053DA5256D FOREIGN KEY (image_id) REFERENCES user_image (id)');
        $this->addSql('ALTER TABLE institution_institution ADD CONSTRAINT FK_5C7FD7DADA6A219 FOREIGN KEY (place_id) REFERENCES location_location (id)');
        $this->addSql('ALTER TABLE institution_institution ADD CONSTRAINT FK_5C7FD7DA44F5D008 FOREIGN KEY (brand_id) REFERENCES institution_image (id)');
        $this->addSql('ALTER TABLE institution_institution ADD CONSTRAINT FK_5C7FD7DA642B8210 FOREIGN KEY (admin_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE institution_institution_user_join ADD CONSTRAINT FK_B62C068C10405986 FOREIGN KEY (institution_id) REFERENCES institution_institution (id)');
        $this->addSql('ALTER TABLE institution_institution_user_join ADD CONSTRAINT FK_B62C068CA76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
        $this->addSql('DROP TABLE message_message_recivers_join');
        $this->addSql('ALTER TABLE message_message ADD broadcasted TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user_session_history ADD user_id INT DEFAULT NULL, ADD place_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_session_history ADD CONSTRAINT FK_27BE9E9EA76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE user_session_history ADD CONSTRAINT FK_27BE9E9EDA6A219 FOREIGN KEY (place_id) REFERENCES location_location (id)');
        $this->addSql('CREATE INDEX IDX_27BE9E9EA76ED395 ON user_session_history (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_27BE9E9EDA6A219 ON user_session_history (place_id)');
        $this->addSql('ALTER TABLE user_user ADD profile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80CCFA12B8 FOREIGN KEY (profile_id) REFERENCES user_profile (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F7129A80CCFA12B8 ON user_user (profile_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A80CCFA12B8');
        $this->addSql('ALTER TABLE message_message_institution_join DROP FOREIGN KEY FK_9EB87EC710405986');
        $this->addSql('ALTER TABLE institution_institution_user_join DROP FOREIGN KEY FK_B62C068C10405986');
        $this->addSql('ALTER TABLE institution_institution DROP FOREIGN KEY FK_5C7FD7DA44F5D008');
        $this->addSql('CREATE TABLE message_message_recivers_join (message_id INT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_3EDE0AFCA76ED395 (user_id), INDEX IDX_3EDE0AFC537A1329 (message_id), PRIMARY KEY(message_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_message_recivers_join ADD CONSTRAINT FK_3EDE0AFC537A1329 FOREIGN KEY (message_id) REFERENCES message_message (id)');
        $this->addSql('ALTER TABLE message_message_recivers_join ADD CONSTRAINT FK_3EDE0AFCA76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
        $this->addSql('DROP TABLE message_message_institution_join');
        $this->addSql('DROP TABLE user_profile');
        $this->addSql('DROP TABLE institution_institution');
        $this->addSql('DROP TABLE institution_institution_user_join');
        $this->addSql('DROP TABLE institution_image');
        $this->addSql('ALTER TABLE message_message DROP broadcasted');
        $this->addSql('ALTER TABLE user_session_history DROP FOREIGN KEY FK_27BE9E9EA76ED395');
        $this->addSql('ALTER TABLE user_session_history DROP FOREIGN KEY FK_27BE9E9EDA6A219');
        $this->addSql('DROP INDEX IDX_27BE9E9EA76ED395 ON user_session_history');
        $this->addSql('DROP INDEX UNIQ_27BE9E9EDA6A219 ON user_session_history');
        $this->addSql('ALTER TABLE user_session_history DROP user_id, DROP place_id');
        $this->addSql('DROP INDEX UNIQ_F7129A80CCFA12B8 ON user_user');
        $this->addSql('ALTER TABLE user_user DROP profile_id');
    }
}
