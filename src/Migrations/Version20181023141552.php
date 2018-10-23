<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181023141552 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE beers ADD brew_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE beers ADD CONSTRAINT FK_B331E6381DB7C47A FOREIGN KEY (brew_id_id) REFERENCES brewers (id)');
        $this->addSql('CREATE INDEX IDX_B331E6381DB7C47A ON beers (brew_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE beers DROP FOREIGN KEY FK_B331E6381DB7C47A');
        $this->addSql('DROP INDEX IDX_B331E6381DB7C47A ON beers');
        $this->addSql('ALTER TABLE beers DROP brew_id_id');
    }
}
