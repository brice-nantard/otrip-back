<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230824094235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_x DROP FOREIGN KEY FK_6C2FA454D60322AC');
        $this->addSql('DROP INDEX IDX_6C2FA454D60322AC ON user_x');
        $this->addSql('ALTER TABLE user_x ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', DROP role_id, CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6C2FA454E7927C74 ON user_x (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_6C2FA454E7927C74 ON user_x');
        $this->addSql('ALTER TABLE user_x ADD role_id INT NOT NULL, DROP roles, CHANGE email email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user_x ADD CONSTRAINT FK_6C2FA454D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('CREATE INDEX IDX_6C2FA454D60322AC ON user_x (role_id)');
    }
}
