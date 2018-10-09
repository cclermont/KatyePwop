<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181009162510 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE message_message_recivers_join (message_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3EDE0AFC537A1329 (message_id), UNIQUE INDEX UNIQ_3EDE0AFCA76ED395 (user_id), PRIMARY KEY(message_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_message_recivers_join ADD CONSTRAINT FK_3EDE0AFC537A1329 FOREIGN KEY (message_id) REFERENCES message_message (id)');
        $this->addSql('ALTER TABLE message_message_recivers_join ADD CONSTRAINT FK_3EDE0AFCA76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id)');
        $this->addSql('ALTER TABLE message_message ADD sender_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message_message ADD CONSTRAINT FK_26350A73F624B39D FOREIGN KEY (sender_id) REFERENCES user_user (id)');
        $this->addSql('CREATE INDEX IDX_26350A73F624B39D ON message_message (sender_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE message_message_recivers_join');
        $this->addSql('ALTER TABLE message_message DROP FOREIGN KEY FK_26350A73F624B39D');
        $this->addSql('DROP INDEX IDX_26350A73F624B39D ON message_message');
        $this->addSql('ALTER TABLE message_message DROP sender_id');
    }
}
