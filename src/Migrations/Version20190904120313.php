<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190904120313 extends AbstractMigration
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
        $this->addSql('DROP INDEX IDX_8D93D649275ED078 ON user');
        $this->addSql('ALTER TABLE user ADD compte_id INT DEFAULT NULL, DROP profil_id');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649F2C56620 ON user (compte_id)');
        $this->addSql('ALTER TABLE prestataire CHANGE nompartenaire nom VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE beneficiaire (id INT AUTO_INCREMENT NOT NULL, nombene VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prenombene VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, cni BIGINT NOT NULL, telbene VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE expediteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, telephone VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, expediteur_id INT DEFAULT NULL, beneficiaire_id INT DEFAULT NULL, codetransaction BIGINT NOT NULL, montant BIGINT NOT NULL, comenvoi BIGINT NOT NULL, comretrait BIGINT NOT NULL, cometat BIGINT NOT NULL, comsystem BIGINT NOT NULL, frais BIGINT NOT NULL, type VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, datetransaction DATETIME NOT NULL, INDEX IDX_723705D1A76ED395 (user_id), INDEX IDX_723705D15AF81F68 (beneficiaire_id), INDEX IDX_723705D110335F61 (expediteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D110335F61 FOREIGN KEY (expediteur_id) REFERENCES expediteur (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D15AF81F68 FOREIGN KEY (beneficiaire_id) REFERENCES beneficiaire (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE prestataire CHANGE nom nompartenaire VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F2C56620');
        $this->addSql('DROP INDEX IDX_8D93D649F2C56620 ON user');
        $this->addSql('ALTER TABLE user ADD profil_id INT NOT NULL, DROP compte_id');
        $this->addSql('CREATE INDEX IDX_8D93D649275ED078 ON user (profil_id)');
    }
}
