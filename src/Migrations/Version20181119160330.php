<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181119160330 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE institution_institution_location_join (institution_id INT NOT NULL, location_id INT NOT NULL, INDEX IDX_8193960510405986 (institution_id), UNIQUE INDEX UNIQ_8193960564D218E (location_id), PRIMARY KEY(institution_id, location_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE institution_institution_location_join ADD CONSTRAINT FK_8193960510405986 FOREIGN KEY (institution_id) REFERENCES institution_institution (id)');
        $this->addSql('ALTER TABLE institution_institution_location_join ADD CONSTRAINT FK_8193960564D218E FOREIGN KEY (location_id) REFERENCES location_location (id)');
        $this->addSql('ALTER TABLE institution_institution DROP FOREIGN KEY FK_5C7FD7DA64D218E');
        $this->addSql('DROP INDEX IDX_5C7FD7DA64D218E ON institution_institution');
        $this->addSql('ALTER TABLE institution_institution DROP location_id');
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

        $this->addSql('DROP TABLE institution_institution_location_join');
        $this->addSql('ALTER TABLE institution_institution ADD location_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE institution_institution ADD CONSTRAINT FK_5C7FD7DA64D218E FOREIGN KEY (location_id) REFERENCES location_location (id)');
        $this->addSql('CREATE INDEX IDX_5C7FD7DA64D218E ON institution_institution (location_id)');
    }
}
