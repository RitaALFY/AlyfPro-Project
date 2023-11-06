<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231106133335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_speciality (user_id INT NOT NULL, speciality_id INT NOT NULL, INDEX IDX_54B06662A76ED395 (user_id), INDEX IDX_54B066623B5A08D7 (speciality_id), PRIMARY KEY(user_id, speciality_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_speciality ADD CONSTRAINT FK_54B06662A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_speciality ADD CONSTRAINT FK_54B066623B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814ABA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D11814ABA76ED395 ON intervention (user_id)');
        $this->addSql('ALTER TABLE module ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C242628A76ED395 ON module (user_id)');
        $this->addSql('ALTER TABLE unavailability ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE unavailability ADD CONSTRAINT FK_F0016D1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F0016D1A76ED395 ON unavailability (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_speciality DROP FOREIGN KEY FK_54B06662A76ED395');
        $this->addSql('ALTER TABLE user_speciality DROP FOREIGN KEY FK_54B066623B5A08D7');
        $this->addSql('DROP TABLE user_speciality');
        $this->addSql('ALTER TABLE unavailability DROP FOREIGN KEY FK_F0016D1A76ED395');
        $this->addSql('DROP INDEX IDX_F0016D1A76ED395 ON unavailability');
        $this->addSql('ALTER TABLE unavailability DROP user_id');
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814ABA76ED395');
        $this->addSql('DROP INDEX IDX_D11814ABA76ED395 ON intervention');
        $this->addSql('ALTER TABLE intervention DROP user_id');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628A76ED395');
        $this->addSql('DROP INDEX IDX_C242628A76ED395 ON module');
        $this->addSql('ALTER TABLE module DROP user_id');
    }
}
