<?php

namespace AppBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190130190928 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE execute DROP FOREIGN KEY FK_FF6310DEAA334807');
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF33EA000B10');
        $this->addSql('ALTER TABLE execute DROP FOREIGN KEY FK_FF6310DECB944F1A');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EC54C8C93');
        $this->addSql('CREATE TABLE completed_tests (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, test_id INT NOT NULL, answers VARCHAR(255) NOT NULL, mark INT NOT NULL, INDEX IDX_3D6B022CA76ED395 (user_id), INDEX IDX_3D6B022C1E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classes (id INT AUTO_INCREMENT NOT NULL, class INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variant (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, description VARCHAR(255) NOT NULL, is_correct TINYINT(1) NOT NULL, INDEX IDX_F143BFAD1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, class_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, family_name VARCHAR(255) NOT NULL, patronymic VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, admin TINYINT(1) NOT NULL, date VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D649EA000B10 (class_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE completed_tests ADD CONSTRAINT FK_3D6B022CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE completed_tests ADD CONSTRAINT FK_3D6B022C1E5D0459 FOREIGN KEY (test_id) REFERENCES test (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variant ADD CONSTRAINT FK_F143BFAD1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649EA000B10 FOREIGN KEY (class_id) REFERENCES classes (id)');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE execute');
        $this->addSql('DROP TABLE school_class');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE type');
        $this->addSql('ALTER TABLE test ADD class_id INT DEFAULT NULL, ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0CEA000B10 FOREIGN KEY (class_id) REFERENCES classes (id)');
        $this->addSql('CREATE INDEX IDX_D87F7E0CEA000B10 ON test (class_id)');
        $this->addSql('DROP INDEX IDX_B6F7494EC54C8C93 ON question');
        $this->addSql('ALTER TABLE question CHANGE question description VARCHAR(255) DEFAULT NULL, CHANGE type_id type INT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0CEA000B10');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649EA000B10');
        $this->addSql('ALTER TABLE completed_tests DROP FOREIGN KEY FK_3D6B022CA76ED395');
        $this->addSql('CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, answer VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, is_correct TINYINT(1) NOT NULL, INDEX IDX_DADD4A251E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE execute (id INT AUTO_INCREMENT NOT NULL, question_id INT NOT NULL, answer_id INT DEFAULT NULL, student_id INT NOT NULL, value VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, INDEX IDX_FF6310DECB944F1A (student_id), INDEX IDX_FF6310DE1E27F6BF (question_id), INDEX IDX_FF6310DEAA334807 (answer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE school_class (id INT AUTO_INCREMENT NOT NULL, class INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, class_id INT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, family_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, patronymic VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, INDEX IDX_B723AF33EA000B10 (class_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE execute ADD CONSTRAINT FK_FF6310DE1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE execute ADD CONSTRAINT FK_FF6310DEAA334807 FOREIGN KEY (answer_id) REFERENCES answer (id)');
        $this->addSql('ALTER TABLE execute ADD CONSTRAINT FK_FF6310DECB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33EA000B10 FOREIGN KEY (class_id) REFERENCES school_class (id)');
        $this->addSql('DROP TABLE completed_tests');
        $this->addSql('DROP TABLE classes');
        $this->addSql('DROP TABLE variant');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE question CHANGE type type_id INT NOT NULL, CHANGE description question VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494EC54C8C93 ON question (type_id)');
        $this->addSql('DROP INDEX IDX_D87F7E0CEA000B10 ON test');
        $this->addSql('ALTER TABLE test DROP class_id, DROP active');
    }
}
