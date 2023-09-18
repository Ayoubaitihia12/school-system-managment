<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230918165006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE class_student (id INT AUTO_INCREMENT NOT NULL, class_id INT NOT NULL, student_id INT NOT NULL, INDEX IDX_7256C8CFEA000B10 (class_id), INDEX IDX_7256C8CFCB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE class_student ADD CONSTRAINT FK_7256C8CFEA000B10 FOREIGN KEY (class_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE class_student ADD CONSTRAINT FK_7256C8CFCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF338F5EA509');
        $this->addSql('DROP INDEX IDX_B723AF338F5EA509 ON student');
        $this->addSql('ALTER TABLE student DROP classe_id');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D53DA5256D FOREIGN KEY (image_id) REFERENCES media (id)');
        $this->addSql('CREATE INDEX IDX_B0F6A6D53DA5256D ON teacher (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE class_student DROP FOREIGN KEY FK_7256C8CFEA000B10');
        $this->addSql('ALTER TABLE class_student DROP FOREIGN KEY FK_7256C8CFCB944F1A');
        $this->addSql('DROP TABLE class_student');
        $this->addSql('ALTER TABLE student ADD classe_id INT NOT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF338F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('CREATE INDEX IDX_B723AF338F5EA509 ON student (classe_id)');
        $this->addSql('ALTER TABLE teacher DROP FOREIGN KEY FK_B0F6A6D53DA5256D');
        $this->addSql('DROP INDEX IDX_B0F6A6D53DA5256D ON teacher');
    }
}
