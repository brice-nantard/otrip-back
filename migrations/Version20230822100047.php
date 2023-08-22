<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230822100047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3CFD70509C');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY step_ibfk_1');
        $this->addSql('DROP INDEX IDX_43B9FE3C9909C13F ON step');
        $this->addSql('DROP INDEX IDX_43B9FE3CFD70509C ON step');
        $this->addSql('ALTER TABLE step DROP transport_id, DROP accomodation_id');
        $this->addSql('ALTER TABLE trip ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7656F53BA76ED395 ON trip (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE step ADD transport_id INT NOT NULL, ADD accomodation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3CFD70509C FOREIGN KEY (accomodation_id) REFERENCES accomodation (id)');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT step_ibfk_1 FOREIGN KEY (transport_id) REFERENCES transport (id)');
        $this->addSql('CREATE INDEX IDX_43B9FE3C9909C13F ON step (transport_id)');
        $this->addSql('CREATE INDEX IDX_43B9FE3CFD70509C ON step (accomodation_id)');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53BA76ED395');
        $this->addSql('DROP INDEX IDX_7656F53BA76ED395 ON trip');
        $this->addSql('ALTER TABLE trip DROP user_id');
    }
}
