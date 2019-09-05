<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190904114924 extends AbstractMigration
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
        $this->addSql('DROP INDEX IDX_723705D15AF81F68 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D110335F61 ON transaction');
        $this->addSql('ALTER TABLE transaction ADD nom VARCHAR(255) NOT NULL, ADD prenom VARCHAR(255) NOT NULL, ADD telephone VARCHAR(255) NOT NULL, DROP expediteur_id, DROP beneficiaire_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649275ED078');
        $this->addSql('DROP INDEX IDX_8D93D649275ED078 ON user');
        $this->addSql('ALTER TABLE user ADD compte_id INT DEFAULT NULL, ADD image_name VARCHAR(255) NOT NULL, ADD updated_at DATETIME NOT NULL, DROP profil_id');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649F2C56620 ON user (compte_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE beneficiaire (id INT AUTO_INCREMENT NOT NULL, nombene VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prenombene VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, cni BIGINT NOT NULL, telbene VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE expediteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, telephone VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE transaction ADD expediteur_id INT DEFAULT NULL, ADD beneficiaire_id INT DEFAULT NULL, DROP nom, DROP prenom, DROP telephone');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D110335F61 FOREIGN KEY (expediteur_id) REFERENCES expediteur (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D15AF81F68 FOREIGN KEY (beneficiaire_id) REFERENCES beneficiaire (id)');
        $this->addSql('CREATE INDEX IDX_723705D15AF81F68 ON transaction (beneficiaire_id)');
        $this->addSql('CREATE INDEX IDX_723705D110335F61 ON transaction (expediteur_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F2C56620');
        $this->addSql('DROP INDEX IDX_8D93D649F2C56620 ON user');
        $this->addSql('ALTER TABLE user ADD profil_id INT NOT NULL, DROP compte_id, DROP image_name, DROP updated_at');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649275ED078 ON user (profil_id)');
    }
}
