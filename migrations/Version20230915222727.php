<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230915222727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE teacher (id INT AUTO_INCREMENT NOT NULL, subject_id INT NOT NULL, class_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date_of_birth DATE NOT NULL, joining_date DATE NOT NULL, admission_id INT NOT NULL, adress LONGTEXT NOT NULL, phone INT NOT NULL, INDEX IDX_B0F6A6D523EDC87 (subject_id), INDEX IDX_B0F6A6D5EA000B10 (class_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D523EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D5EA000B10 FOREIGN KEY (class_id) REFERENCES classe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE teacher DROP FOREIGN KEY FK_B0F6A6D523EDC87');
        $this->addSql('ALTER TABLE teacher DROP FOREIGN KEY FK_B0F6A6D5EA000B10');
        $this->addSql('DROP TABLE teacher');
    }
}
