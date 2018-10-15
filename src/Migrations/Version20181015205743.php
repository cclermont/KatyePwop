<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181015205743 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message_message DROP INDEX UNIQ_26350A7364D218E, ADD INDEX IDX_26350A7364D218E (location_id)');
        $this->addSql('ALTER TABLE institution_institution DROP INDEX UNIQ_5C7FD7DA64D218E, ADD INDEX IDX_5C7FD7DA64D218E (location_id)');
        $this->addSql('ALTER TABLE oauth2_access_token ADD CONSTRAINT FK_454D967319EB6921 FOREIGN KEY (client_id) REFERENCES oauth2_client (id)');
        $this->addSql('ALTER TABLE oauth2_access_token ADD CONSTRAINT FK_454D9673A76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE oauth2_refresh_token ADD CONSTRAINT FK_4DD9073219EB6921 FOREIGN KEY (client_id) REFERENCES oauth2_client (id)');
        $this->addSql('ALTER TABLE oauth2_refresh_token ADD CONSTRAINT FK_4DD90732A76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE oauth2_auth_code ADD CONSTRAINT FK_1D2905B519EB6921 FOREIGN KEY (client_id) REFERENCES oauth2_client (id)');
        $this->addSql('ALTER TABLE oauth2_auth_code ADD CONSTRAINT FK_1D2905B5A76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE user_profile DROP INDEX UNIQ_D95AB40564D218E, ADD INDEX IDX_D95AB40564D218E (location_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE institution_institution DROP INDEX IDX_5C7FD7DA64D218E, ADD UNIQUE INDEX UNIQ_5C7FD7DA64D218E (location_id)');
        $this->addSql('ALTER TABLE message_message DROP INDEX IDX_26350A7364D218E, ADD UNIQUE INDEX UNIQ_26350A7364D218E (location_id)');
        $this->addSql('ALTER TABLE user_profile DROP INDEX IDX_D95AB40564D218E, ADD UNIQUE INDEX UNIQ_D95AB40564D218E (location_id)');
    }
}
