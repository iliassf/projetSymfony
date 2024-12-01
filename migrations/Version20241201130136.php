<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241201130136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wallet (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE credit_card ADD wallet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE credit_card ADD CONSTRAINT FK_11D627EE712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)');
        $this->addSql('CREATE INDEX IDX_11D627EE712520F3 ON credit_card (wallet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE credit_card DROP FOREIGN KEY FK_11D627EE712520F3');
        $this->addSql('DROP TABLE wallet');
        $this->addSql('DROP INDEX IDX_11D627EE712520F3 ON credit_card');
        $this->addSql('ALTER TABLE credit_card DROP wallet_id');
    }
}
