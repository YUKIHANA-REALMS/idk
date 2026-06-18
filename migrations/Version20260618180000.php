<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260618180000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create landing_page_section table for landing page editor';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE landing_page_section (
                id INT AUTO_INCREMENT NOT NULL,
                section_type VARCHAR(50) NOT NULL,
                title VARCHAR(255) NOT NULL,
                sort_order INT NOT NULL DEFAULT 0,
                is_enabled TINYINT(1) NOT NULL DEFAULT 1,
                content LONGTEXT NOT NULL COMMENT '(DC2Type:json)',
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                UNIQUE INDEX UNIQ_LPS_SECTION_TYPE (section_type),
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ");

        // Seed default sections
        $now = date('Y-m-d H:i:s');

        $this->addSql("INSERT INTO landing_page_section (section_type, title, sort_order, is_enabled, content, created_at, updated_at) VALUES
        ('general', 'General Settings', 0, 1, '{\"site_title\":\"Indium Panel\",\"site_description\":\"Game servers, served cold. Open-source panel that runs where you tell it to.\",\"logo_url\":\"\",\"favicon_url\":\"\"}', '$now', '$now'),
        ('navbar', 'Navigation Bar', 1, 1, '{\"background_color\":\"#000000\",\"text_color\":\"#ffffff\",\"links\":[{\"text\":\"Home\",\"url\":\"/\",\"is_active\":true},{\"text\":\"Store\",\"url\":\"/store\",\"is_active\":true},{\"text\":\"Login\",\"url\":\"/login\",\"is_active\":true},{\"text\":\"Register\",\"url\":\"/register\",\"is_active\":true}],\"button_color\":\"#4287f5\",\"button_text_color\":\"#ffffff\"}', '$now', '$now'),
        ('hero', 'Hero Section', 2, 1, '{\"title\":\"Indium Panel\",\"subtitle\":\"Game servers, served cold. Open-source panel that runs where you tell it to. No vendor lock, no surprises.\",\"background_type\":\"color\",\"background_color\":\"#000000\",\"background_image\":\"\",\"background_video\":\"\",\"text_color\":\"#ffffff\",\"buttons\":[{\"text\":\"Get Started\",\"url\":\"/register\",\"color\":\"#4287f5\",\"text_color\":\"#ffffff\",\"style\":\"filled\"},{\"text\":\"Documentation\",\"url\":\"#\",\"color\":\"transparent\",\"text_color\":\"#ffffff\",\"style\":\"outlined\"}]}', '$now', '$now'),
        ('features', 'Features Section', 3, 1, '{\"title\":\"Why Choose Indium?\",\"subtitle\":\"Built for performance, designed for simplicity.\",\"background_color\":\"#0a0a0a\",\"text_color\":\"#ffffff\",\"items\":[{\"title\":\"Open Source\",\"description\":\"Fully open source with no vendor lock-in.\",\"icon\":\"fa-code\",\"color\":\"#4287f5\"},{\"title\":\"Fast & Reliable\",\"description\":\"Optimized for speed and uptime.\",\"icon\":\"fa-bolt\",\"color\":\"#22c55e\"},{\"title\":\"Easy Setup\",\"description\":\"Deploy in minutes, not hours.\",\"icon\":\"fa-rocket\",\"color\":\"#f59e0b\"}]}', '$now', '$now'),
        ('products', 'Products Section', 4, 1, '{\"title\":\"Our Products\",\"subtitle\":\"Choose the perfect plan for your game server.\",\"background_color\":\"#000000\",\"text_color\":\"#ffffff\",\"card_style\":\"rounded\",\"card_border_radius\":\"16px\",\"card_shadow\":true,\"card_shadow_color\":\"rgba(66,135,245,0.15)\",\"card_shadow_blur\":\"20px\",\"card_background\":\"#0a0a0a\",\"card_border_color\":\"#222222\",\"card_hover\":true,\"card_hover_scale\":1.02,\"button_text\":\"Order Now\",\"button_color\":\"#4287f5\",\"button_text_color\":\"#ffffff\",\"layout\":\"grid\"}', '$now', '$now'),
        ('cta', 'Call to Action', 5, 1, '{\"title\":\"Ready to Get Started?\",\"subtitle\":\"Deploy your game server in seconds.\",\"background_color\":\"#0a0a0a\",\"text_color\":\"#ffffff\",\"buttons\":[{\"text\":\"Get Started\",\"url\":\"/register\",\"color\":\"#4287f5\",\"text_color\":\"#ffffff\",\"style\":\"filled\"}]}', '$now', '$now'),
        ('footer', 'Footer', 6, 1, '{\"background_color\":\"#000000\",\"text_color\":\"#888888\",\"links\":[{\"text\":\"Terms\",\"url\":\"/terms\"},{\"text\":\"Privacy\",\"url\":\"/privacy\"},{\"text\":\"Support\",\"url\":\"/support\"}],\"copyright_text\":\"All rights reserved.\",\"social_links\":[],\"show_logo\":true}'  , '$now', '$now')
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE landing_page_section');
    }
}
