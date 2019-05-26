<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190524182135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE twitterer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE twitterer_twitterer (twitterer_source INT NOT NULL, twitterer_target INT NOT NULL, INDEX IDX_EA353321550C7DA (twitterer_source), INDEX IDX_EA35332CB59755 (twitterer_target), PRIMARY KEY(twitterer_source, twitterer_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, twitterer_id INT NOT NULL, message VARCHAR(255) NOT NULL, created DATETIME NOT NULL, INDEX IDX_5A8A6C8DB5A75A1D (twitterer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE twitterer_twitterer ADD CONSTRAINT FK_EA353321550C7DA FOREIGN KEY (twitterer_source) REFERENCES twitterer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE twitterer_twitterer ADD CONSTRAINT FK_EA35332CB59755 FOREIGN KEY (twitterer_target) REFERENCES twitterer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DB5A75A1D FOREIGN KEY (twitterer_id) REFERENCES twitterer (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE twitterer_twitterer DROP FOREIGN KEY FK_EA353321550C7DA');
        $this->addSql('ALTER TABLE twitterer_twitterer DROP FOREIGN KEY FK_EA35332CB59755');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DB5A75A1D');
        $this->addSql('DROP TABLE twitterer');
        $this->addSql('DROP TABLE twitterer_twitterer');
        $this->addSql('DROP TABLE post');
    }
}
