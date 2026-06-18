# Indium Panel

**Professional Client Area & Billing Panel for Pterodactyl Hosting**

Transform your Pterodactyl hosting into a complete SaaS business with automated billing, server provisioning, and a powerful plugin ecosystem.

- **Version:** 1.0.0
- **License:** MIT
- **Developer:** Aryan Dwivedi

## Core Features

### Advanced Billing System
- **Flexible Pricing Models** - Time-based (hourly, monthly, yearly), usage-based (per-slot), and multi-period pricing with different rates for different durations
- **Automated Billing Cycles** - Automatic server suspension for non-payment, renewal reminders, and grace periods
- **Voucher System** - Balance top-up and discount codes with email verification
- **Payment Processing** - Stripe (built-in), PayPal (plugin), and extensible payment provider system

### Complete Server Management
- **Automated Provisioning** - Instant server creation via Pterodactyl API with customizable configurations and egg-based product templates
- **Real-Time Control Panel** - Live console access, server statistics (CPU, RAM, disk, network), and power controls
- **Advanced Features** - Database management, backup creation and restoration, port allocation, subuser management with permissions, schedule/task management, and startup variable configuration

### Plugin Ecosystem
- **Developer-Friendly** - Full Symfony integration with PSR-4 autoloading, Doctrine ORM support, and EasyAdmin CRUD generation
- **Security & Quality** - Automated security scanning, plugin health monitoring, dependency management, and capability-based permissions

### Internationalization
- **14 Languages** - English, German, French, Spanish, Italian, Portuguese, Dutch, Polish, Russian, Ukrainian, Chinese, Hindi, Indonesian, Swiss German

### Enterprise Security
- **Permission-Based Access Control** - 40+ granular permissions with role-based management and plugin-specific permissions
- **Security Features** - CSRF protection, XSS prevention, SQL injection safeguards, and trusted proxy support

### Theming & Customization
- **Built-in Theme System** - Default responsive theme with dark/light mode support and custom CSS/JS injection
- **Extensible Templates** - Twig-based engine with view overrides and widget extension points

## Quick Start

### Installation Options

#### Docker Compose (Recommended)
```bash
git clone <repository-url> indium-panel
cd indium-panel
docker-compose up -d
```

#### Manual Installation
For custom environments or advanced configurations.

### Requirements

| Component | Requirement |
|-----------|-------------|
| **PHP** | 8.2+ with extensions: `cli`, `ctype`, `iconv`, `mysql`, `pdo`, `mbstring`, `tokenizer`, `bcmath`, `xml`, `curl`, `zip`, `intl`, `fpm` (NGINX) |
| **Database** | MySQL 5.7.22+ (MySQL 8 recommended) or MariaDB 10.2+ |
| **Web Server** | NGINX or Apache |
| **Pterodactyl** | v1.11+ (compatible with latest versions) |
| **Tools** | Git, Composer 2, cURL, tar, unzip |

### Next Steps

After installation, configure your instance:

1. Run the setup wizard at `https://your-domain.com/first-configuration` or use `php bin/console indium:system:configure`
2. Configure Pterodactyl API connection
3. Set up your first payment provider
4. Create product categories and offerings

## Plugin System

**Plugins are first-class citizens in Indium Panel** — not extensions bolted onto the core, but a foundational architecture designed for extensibility from day one.

Extend Indium Panel with custom functionality through the comprehensive plugin system.

### Plugin Capabilities

| Capability | Use Cases |
|------------|-----------|
| **Routes** | Payment providers, custom pages, webhooks |
| **Entities** | Store plugin data, extend user profiles |
| **Widgets** | Dashboard widgets, admin panels, custom UI |
| **Events** | Webhook integrations, automation, custom logic |
| **Console** | Maintenance tasks, data migration, automation |
| **Cron** | Scheduled tasks, periodic cleanups, reports |

## Community & Support

- **Website:** [https://indium.indicloud.xyz/](https://indium.indicloud.xyz/)
- **Panel:** [https://indium.indicloud.xyz/indium-panel/](https://indium.indicloud.xyz/indium-panel/)

## License

Indium Panel is open-source software licensed under the [MIT License](LICENSE).

**TL;DR:** Free to use, modify, and distribute, even commercially. See [LICENSE](LICENSE) for full terms.

## Acknowledgments

- Built on the excellent [Pterodactyl Panel](https://pterodactyl.io/)
- Powered by [Symfony Framework](https://symfony.com/)
- Admin interface by [EasyAdmin Bundle](https://github.com/EasyCorp/EasyAdminBundle)
