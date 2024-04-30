<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230829100014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer ADD content_two LONGTEXT DEFAULT NULL, ADD content_three LONGTEXT DEFAULT NULL, ADD content_four LONGTEXT DEFAULT NULL, ADD code_two LONGTEXT DEFAULT NULL, ADD code_three LONGTEXT DEFAULT NULL, ADD code_four LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD code_two LONGTEXT DEFAULT NULL, ADD code_three LONGTEXT DEFAULT NULL, ADD code_four LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP content_two, DROP content_three, DROP content_four, DROP code_two, DROP code_three, DROP code_four');
        $this->addSql('ALTER TABLE question DROP code_two, DROP code_three, DROP code_four');
    }
}
