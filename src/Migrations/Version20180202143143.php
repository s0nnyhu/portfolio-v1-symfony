<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180202143143 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E665BF954B9');
        $this->addSql('DROP TABLE front_article');
        $this->addSql('DROP INDEX UNIQ_23A0E665BF954B9 ON article');
        $this->addSql('ALTER TABLE article ADD front_description VARCHAR(255) NOT NULL, ADD front_url_img VARCHAR(255) NOT NULL, DROP front_article_id');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE front_article (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, description LONGTEXT NOT NULL COLLATE utf8_unicode_ci, url_img VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, is_public TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD front_article_id INT DEFAULT NULL, DROP front_description, DROP front_url_img');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E665BF954B9 FOREIGN KEY (front_article_id) REFERENCES front_article (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E665BF954B9 ON article (front_article_id)');
    }
}
