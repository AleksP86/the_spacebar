<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190303121938 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article ADD author VARCHAR(255) DEFAULT NULL, ADD heart_count INT NOT NULL, ADD image_filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE article RENAME INDEX uniq_23a0e66fec530a9 TO UNIQ_23A0E66989D9B62');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP author, DROP heart_count, DROP image_filename');
        $this->addSql('ALTER TABLE article RENAME INDEX uniq_23a0e66989d9b62 TO UNIQ_23A0E66FEC530A9');
    }
}
