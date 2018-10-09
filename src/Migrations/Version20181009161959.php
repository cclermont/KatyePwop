<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181009161959 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message_video ADD message_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message_video ADD CONSTRAINT FK_836125C7537A1329 FOREIGN KEY (message_id) REFERENCES message_message (id)');
        $this->addSql('CREATE INDEX IDX_836125C7537A1329 ON message_video (message_id)');
        $this->addSql('ALTER TABLE message_message ADD place_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message_message ADD CONSTRAINT FK_26350A73DA6A219 FOREIGN KEY (place_id) REFERENCES location_location (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_26350A73DA6A219 ON message_message (place_id)');
        $this->addSql('ALTER TABLE message_image ADD message_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message_image ADD CONSTRAINT FK_3A9BFBB4537A1329 FOREIGN KEY (message_id) REFERENCES message_message (id)');
        $this->addSql('CREATE INDEX IDX_3A9BFBB4537A1329 ON message_image (message_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message_image DROP FOREIGN KEY FK_3A9BFBB4537A1329');
        $this->addSql('DROP INDEX IDX_3A9BFBB4537A1329 ON message_image');
        $this->addSql('ALTER TABLE message_image DROP message_id');
        $this->addSql('ALTER TABLE message_message DROP FOREIGN KEY FK_26350A73DA6A219');
        $this->addSql('DROP INDEX UNIQ_26350A73DA6A219 ON message_message');
        $this->addSql('ALTER TABLE message_message DROP place_id');
        $this->addSql('ALTER TABLE message_video DROP FOREIGN KEY FK_836125C7537A1329');
        $this->addSql('DROP INDEX IDX_836125C7537A1329 ON message_video');
        $this->addSql('ALTER TABLE message_video DROP message_id');
    }
}
