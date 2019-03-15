<?php

namespace AppBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190212062319 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE progress ADD image LONGTEXT NOT NULL, DROP path_image');
        $this->addSql('ALTER TABLE question CHANGE image image LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD active TINYINT(1) NOT NULL, ADD photo LONGTEXT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE progress ADD path_image VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP image');
        $this->addSql('ALTER TABLE question CHANGE image image VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE user DROP active, DROP photo');
    }
}
