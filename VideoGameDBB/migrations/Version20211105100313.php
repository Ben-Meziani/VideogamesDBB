<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211105100313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_videogame (category_id INT NOT NULL, videogame_id INT NOT NULL, INDEX IDX_53B93F4212469DE2 (category_id), INDEX IDX_53B93F4225EB9E4B (videogame_id), PRIMARY KEY(category_id, videogame_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_user (category_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_608AC0E12469DE2 (category_id), INDEX IDX_608AC0EA76ED395 (user_id), PRIMARY KEY(category_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, name VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE videogame (id INT AUTO_INCREMENT NOT NULL, release_date DATETIME NOT NULL, name VARCHAR(100) NOT NULL, image_filename VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE videogame_user (videogame_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_E0C4CDB925EB9E4B (videogame_id), INDEX IDX_E0C4CDB9A76ED395 (user_id), PRIMARY KEY(videogame_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_videogame ADD CONSTRAINT FK_53B93F4212469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_videogame ADD CONSTRAINT FK_53B93F4225EB9E4B FOREIGN KEY (videogame_id) REFERENCES videogame (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_user ADD CONSTRAINT FK_608AC0E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_user ADD CONSTRAINT FK_608AC0EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE videogame_user ADD CONSTRAINT FK_E0C4CDB925EB9E4B FOREIGN KEY (videogame_id) REFERENCES videogame (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE videogame_user ADD CONSTRAINT FK_E0C4CDB9A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_videogame DROP FOREIGN KEY FK_53B93F4212469DE2');
        $this->addSql('ALTER TABLE category_user DROP FOREIGN KEY FK_608AC0E12469DE2');
        $this->addSql('ALTER TABLE category_user DROP FOREIGN KEY FK_608AC0EA76ED395');
        $this->addSql('ALTER TABLE videogame_user DROP FOREIGN KEY FK_E0C4CDB9A76ED395');
        $this->addSql('ALTER TABLE category_videogame DROP FOREIGN KEY FK_53B93F4225EB9E4B');
        $this->addSql('ALTER TABLE videogame_user DROP FOREIGN KEY FK_E0C4CDB925EB9E4B');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_videogame');
        $this->addSql('DROP TABLE category_user');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE videogame');
        $this->addSql('DROP TABLE videogame_user');
    }
}
