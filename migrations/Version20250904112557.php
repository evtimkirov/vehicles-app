<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250904112557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE followed_vehicles (user_id INT NOT NULL, vehicle_id INT NOT NULL, INDEX IDX_5CAFC851A76ED395 (user_id), INDEX IDX_5CAFC851545317D1 (vehicle_id), PRIMARY KEY(user_id, vehicle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE followed_vehicles ADD CONSTRAINT FK_5CAFC851A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE followed_vehicles ADD CONSTRAINT FK_5CAFC851545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vehicles ADD merchant_id INT NOT NULL');
        $this->addSql('ALTER TABLE vehicles ADD CONSTRAINT FK_1FCE69FA6796D554 FOREIGN KEY (merchant_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1FCE69FA6796D554 ON vehicles (merchant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE followed_vehicles DROP FOREIGN KEY FK_5CAFC851A76ED395');
        $this->addSql('ALTER TABLE followed_vehicles DROP FOREIGN KEY FK_5CAFC851545317D1');
        $this->addSql('DROP TABLE followed_vehicles');
        $this->addSql('ALTER TABLE vehicles DROP FOREIGN KEY FK_1FCE69FA6796D554');
        $this->addSql('DROP INDEX IDX_1FCE69FA6796D554 ON vehicles');
        $this->addSql('ALTER TABLE vehicles DROP merchant_id');
    }
}
