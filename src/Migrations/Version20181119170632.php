<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181119170632 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE message_message_location_join (message_id INT NOT NULL, location_id INT NOT NULL, INDEX IDX_49C7D981537A1329 (message_id), UNIQUE INDEX UNIQ_49C7D98164D218E (location_id), PRIMARY KEY(message_id, location_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_message_location_join ADD CONSTRAINT FK_49C7D981537A1329 FOREIGN KEY (message_id) REFERENCES message_message (id)');
        $this->addSql('ALTER TABLE message_message_location_join ADD CONSTRAINT FK_49C7D98164D218E FOREIGN KEY (location_id) REFERENCES location_location (id)');
        $this->addSql('DROP TABLE location_institution');
        $this->addSql('DROP TABLE location_message');
        $this->addSql('ALTER TABLE location_location ADD institution_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE location_location ADD CONSTRAINT FK_8FCBAB2910405986 FOREIGN KEY (institution_id) REFERENCES institution_institution (id)');
        $this->addSql('CREATE INDEX IDX_8FCBAB2910405986 ON location_location (institution_id)');
        $this->addSql('ALTER TABLE oauth2_access_token ADD CONSTRAINT FK_454D967319EB6921 FOREIGN KEY (client_id) REFERENCES oauth2_client (id)');
        $this->addSql('ALTER TABLE oauth2_access_token ADD CONSTRAINT FK_454D9673A76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE oauth2_refresh_token ADD CONSTRAINT FK_4DD9073219EB6921 FOREIGN KEY (client_id) REFERENCES oauth2_client (id)');
        $this->addSql('ALTER TABLE oauth2_refresh_token ADD CONSTRAINT FK_4DD90732A76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE oauth2_auth_code ADD CONSTRAINT FK_1D2905B519EB6921 FOREIGN KEY (client_id) REFERENCES oauth2_client (id)');
        $this->addSql('ALTER TABLE oauth2_auth_code ADD CONSTRAINT FK_1D2905B5A76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE location_institution (location_id INT NOT NULL, institution_id INT NOT NULL, INDEX IDX_2C4A7FA164D218E (location_id), INDEX IDX_2C4A7FA110405986 (institution_id), PRIMARY KEY(location_id, institution_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location_message (location_id INT NOT NULL, message_id INT NOT NULL, INDEX IDX_58F823DB64D218E (location_id), INDEX IDX_58F823DB537A1329 (message_id), PRIMARY KEY(location_id, message_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE location_institution ADD CONSTRAINT FK_2C4A7FA110405986 FOREIGN KEY (institution_id) REFERENCES institution_institution (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location_institution ADD CONSTRAINT FK_2C4A7FA164D218E FOREIGN KEY (location_id) REFERENCES location_location (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location_message ADD CONSTRAINT FK_58F823DB537A1329 FOREIGN KEY (message_id) REFERENCES message_message (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location_message ADD CONSTRAINT FK_58F823DB64D218E FOREIGN KEY (location_id) REFERENCES location_location (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE message_message_location_join');
        $this->addSql('ALTER TABLE location_location DROP FOREIGN KEY FK_8FCBAB2910405986');
        $this->addSql('DROP INDEX IDX_8FCBAB2910405986 ON location_location');
        $this->addSql('ALTER TABLE location_location DROP institution_id');
    }
}
