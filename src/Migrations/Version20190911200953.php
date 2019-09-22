<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190911200953 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE message_message_repeat (id INT AUTO_INCREMENT NOT NULL, frequency VARCHAR(16) NOT NULL, every INT NOT NULL, week_days LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', month_days LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', year_months LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', created DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_message ADD repeat_id INT DEFAULT NULL, ADD posponed TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE message_message ADD CONSTRAINT FK_26350A73CD096AF4 FOREIGN KEY (repeat_id) REFERENCES message_message_repeat (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_26350A73CD096AF4 ON message_message (repeat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message_message DROP FOREIGN KEY FK_26350A73CD096AF4');
        $this->addSql('DROP TABLE message_message_repeat');
        $this->addSql('DROP INDEX UNIQ_26350A73CD096AF4 ON message_message');
        $this->addSql('ALTER TABLE message_message DROP repeat_id, DROP posponed');
    }
}
