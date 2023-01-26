<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230125171213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formula (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formula_dish (formula_id INT NOT NULL, dish_id INT NOT NULL, INDEX IDX_4572300BA50A6386 (formula_id), INDEX IDX_4572300B148EB0CB (dish_id), PRIMARY KEY(formula_id, dish_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_formula (menu_id INT NOT NULL, formula_id INT NOT NULL, INDEX IDX_EFEA453FCCD7E912 (menu_id), INDEX IDX_EFEA453FA50A6386 (formula_id), PRIMARY KEY(menu_id, formula_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formula_dish ADD CONSTRAINT FK_4572300BA50A6386 FOREIGN KEY (formula_id) REFERENCES formula (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formula_dish ADD CONSTRAINT FK_4572300B148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_formula ADD CONSTRAINT FK_EFEA453FCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_formula ADD CONSTRAINT FK_EFEA453FA50A6386 FOREIGN KEY (formula_id) REFERENCES formula (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formula_dish DROP FOREIGN KEY FK_4572300BA50A6386');
        $this->addSql('ALTER TABLE formula_dish DROP FOREIGN KEY FK_4572300B148EB0CB');
        $this->addSql('ALTER TABLE menu_formula DROP FOREIGN KEY FK_EFEA453FCCD7E912');
        $this->addSql('ALTER TABLE menu_formula DROP FOREIGN KEY FK_EFEA453FA50A6386');
        $this->addSql('DROP TABLE formula');
        $this->addSql('DROP TABLE formula_dish');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_formula');
    }
}
