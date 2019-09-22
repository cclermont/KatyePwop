<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190911205035 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message_message ADD custom_repeat_id INT DEFAULT NULL, ADD custom_repeated TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE message_message ADD CONSTRAINT FK_26350A7387331D52 FOREIGN KEY (custom_repeat_id) REFERENCES message_message_repeat (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_26350A7387331D52 ON message_message (custom_repeat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message_message DROP FOREIGN KEY FK_26350A7387331D52');
        $this->addSql('DROP INDEX UNIQ_26350A7387331D52 ON message_message');
        $this->addSql('ALTER TABLE message_message DROP custom_repeat_id, DROP custom_repeated');
    }
}
