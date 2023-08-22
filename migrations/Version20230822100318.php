<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230822100318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE step ADD transport_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C9909C13F FOREIGN KEY (transport_id) REFERENCES transport (id)');
        $this->addSql('CREATE INDEX IDX_43B9FE3C9909C13F ON step (transport_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C9909C13F');
        $this->addSql('DROP INDEX IDX_43B9FE3C9909C13F ON step');
        $this->addSql('ALTER TABLE step DROP transport_id');
    }
}
