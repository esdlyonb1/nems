<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240222090847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nem ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nem ADD CONSTRAINT FK_9681BD3F3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9681BD3F3DA5256D ON nem (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE nem DROP CONSTRAINT FK_9681BD3F3DA5256D');
        $this->addSql('DROP INDEX UNIQ_9681BD3F3DA5256D');
        $this->addSql('ALTER TABLE nem DROP image_id');
    }
}
