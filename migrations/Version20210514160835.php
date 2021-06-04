<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210514160835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expertise (id INT AUTO_INCREMENT NOT NULL, niveau VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lien_user_skill (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, skill_id INT DEFAULT NULL, expertise_id INT DEFAULT NULL, prefer TINYINT(1) NOT NULL, INDEX IDX_941F1769A76ED395 (user_id), INDEX IDX_941F17695585C142 (skill_id), INDEX IDX_941F17699D5B92F9 (expertise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lien_user_skill ADD CONSTRAINT FK_941F1769A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lien_user_skill ADD CONSTRAINT FK_941F17695585C142 FOREIGN KEY (skill_id) REFERENCES skill (id)');
        $this->addSql('ALTER TABLE lien_user_skill ADD CONSTRAINT FK_941F17699D5B92F9 FOREIGN KEY (expertise_id) REFERENCES expertise (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lien_user_skill DROP FOREIGN KEY FK_941F17699D5B92F9');
        $this->addSql('DROP TABLE expertise');
        $this->addSql('DROP TABLE lien_user_skill');
    }
}
