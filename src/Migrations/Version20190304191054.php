<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190304191054 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE author author VARCHAR(255) DEFAULT NULL, CHANGE image_filename image_filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE article RENAME INDEX uniq_23a0e66fec530a9 TO UNIQ_23A0E66989D9B62');
        $this->addSql('ALTER TABLE quotes DROP add_link');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE author author VARCHAR(100) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE image_filename image_filename VARCHAR(100) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE article RENAME INDEX uniq_23a0e66989d9b62 TO UNIQ_23A0E66FEC530A9');
        $this->addSql('ALTER TABLE quotes ADD add_link VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
