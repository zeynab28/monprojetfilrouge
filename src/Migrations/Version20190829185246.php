<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190829185246 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D15AF81F68');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D110335F61');
        $this->addSql('DROP TABLE beneficiaire');
        $this->addSql('DROP TABLE expediteur');
        $this->addSql('DROP TABLE transaction');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE beneficiaire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, telephone VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE expediteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, telephone VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, expediteur_id INT DEFAULT NULL, beneficiaire_id INT DEFAULT NULL, agence VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, frais INT NOT NULL, datetransaction DATETIME NOT NULL, codetransaction VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, montant INT NOT NULL, INDEX IDX_723705D110335F61 (expediteur_id), INDEX IDX_723705D1A76ED395 (user_id), INDEX IDX_723705D15AF81F68 (beneficiaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D110335F61 FOREIGN KEY (expediteur_id) REFERENCES expediteur (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D15AF81F68 FOREIGN KEY (beneficiaire_id) REFERENCES beneficiaire (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }
}
