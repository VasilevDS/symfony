<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200618082501 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE event_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE freetime_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE lesson_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE student_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE teacher_theme_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE theme_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TYPE event_type AS ENUM(\'FREETIME\', \'LESSON\')');
        $this->addSql('CREATE TABLE event (id INT NOT NULL, date_from TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_to TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type event_type NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE freetime (id INT NOT NULL, teacher_id INT NOT NULL, event_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4F6A96DA41807E1D ON freetime (teacher_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4F6A96DA71F7E88B ON freetime (event_id)');
        $this->addSql('CREATE TABLE lesson (id INT NOT NULL, teacher_id INT NOT NULL, student_id INT NOT NULL, theme_id INT NOT NULL, event_id INT NOT NULL, freetime_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F87474F341807E1D ON lesson (teacher_id)');
        $this->addSql('CREATE INDEX IDX_F87474F3CB944F1A ON lesson (student_id)');
        $this->addSql('CREATE INDEX IDX_F87474F359027487 ON lesson (theme_id)');
        $this->addSql('CREATE INDEX IDX_F87474F371F7E88B ON lesson (event_id)');
        $this->addSql('CREATE INDEX IDX_F87474F36C23D043 ON lesson (freetime_id)');
        $this->addSql('CREATE TABLE student (id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B723AF339D86650F ON student (user_id)');
        $this->addSql('CREATE TABLE teacher_theme (teacher_id INT NOT NULL, theme_id INT NOT NULL)');
        $this->addSql('CREATE INDEX IDX_190BD0A75814C70C ON teacher_theme (teacher_id)');
        $this->addSql('CREATE INDEX IDX_190BD0A759027487 ON teacher_theme (theme_id)');
        $this->addSql('CREATE TABLE theme (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE freetime ADD CONSTRAINT FK_4F6A96DA41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE freetime ADD CONSTRAINT FK_4F6A96DA71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F341807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F359027487 FOREIGN KEY (theme_id) REFERENCES theme (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F371F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F36C23D043 FOREIGN KEY (freetime_id) REFERENCES freetime (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF339D86650F FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_theme ADD CONSTRAINT FK_190BD0A75814C70C FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_theme ADD CONSTRAINT FK_190BD0A759027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE freetime DROP CONSTRAINT FK_4F6A96DA71F7E88B');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT FK_F87474F371F7E88B');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT FK_F87474F36C23D043');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT FK_F87474F3CB944F1A');
        $this->addSql('ALTER TABLE teacher_theme DROP CONSTRAINT FK_190BD0A75814C70C');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT FK_F87474F359027487');
        $this->addSql('ALTER TABLE teacher_theme DROP CONSTRAINT FK_190BD0A759027487');
        $this->addSql('DROP SEQUENCE event_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE freetime_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE lesson_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE student_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE teacher_theme_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE theme_id_seq CASCADE');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE freetime');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE teacher_theme');
        $this->addSql('DROP TABLE theme');
    }
}
