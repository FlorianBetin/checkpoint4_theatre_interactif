<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201094300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nickname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acte ADD piece_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE acte ADD CONSTRAINT FK_9EC41326C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id)');
        $this->addSql('CREATE INDEX IDX_9EC41326C40FCFA8 ON acte (piece_id)');
        $this->addSql('ALTER TABLE piece ADD genre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE piece ADD CONSTRAINT FK_44CA0B234296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('CREATE INDEX IDX_44CA0B234296D31F ON piece (genre_id)');
        $this->addSql('ALTER TABLE sentence ADD acte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sentence ADD CONSTRAINT FK_9D664ED5A767B8C7 FOREIGN KEY (acte_id) REFERENCES acte (id)');
        $this->addSql('CREATE INDEX IDX_9D664ED5A767B8C7 ON sentence (acte_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE acte DROP FOREIGN KEY FK_9EC41326C40FCFA8');
        $this->addSql('DROP INDEX IDX_9EC41326C40FCFA8 ON acte');
        $this->addSql('ALTER TABLE acte DROP piece_id');
        $this->addSql('ALTER TABLE piece DROP FOREIGN KEY FK_44CA0B234296D31F');
        $this->addSql('DROP INDEX IDX_44CA0B234296D31F ON piece');
        $this->addSql('ALTER TABLE piece DROP genre_id');
        $this->addSql('ALTER TABLE sentence DROP FOREIGN KEY FK_9D664ED5A767B8C7');
        $this->addSql('DROP INDEX IDX_9D664ED5A767B8C7 ON sentence');
        $this->addSql('ALTER TABLE sentence DROP acte_id');
    }
}
