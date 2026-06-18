# Indium-Ptero-Addon

A Laravel package that brings an API interface to the Pterodactyl application API, enabling API token creation and SSO authentication for users.

## Features

- Generate API tokens for users via the application API
- Single Sign-On (SSO) authentication integration
- JWT token handling for secure authentication
- Secret key generation for SSO operations

## Installation

### Step 1: Install via Composer

```bash
composer require indium/pterodactyl-addon
```

### Step 2: Publish Configuration (Optional)

```bash
php vendor:publish --provider="Indium\PterodactylAddon\PterodactylApiAddonServiceProvider"
```

### Step 3: Generate Secret Key

```bash
php artisan indium:generate-secret-key
```

This will generate a secure secret key and add it to your `.env` file as `INDIUM_SSO_SECRET`.

### Step 4: Configure Environment

Add the following to your `.env` file:

```env
INDIUM_SSO_SECRET=your-secret-key-here
```

## Usage

### API Endpoints

Once installed, the following routes are available:

- `GET /api/application/indium/version` - Returns the addon version
- `GET /indium/authorize` - SSO authorization endpoint

### Creating API Tokens

Use the API token endpoint to generate tokens for users programmatically.

### SSO Authentication

Integrate with your SSO provider using the authorization endpoint.

## License

MIT License - see [LICENSE.md](LICENSE.md) for details.

## Author

**Aryan Dwivedi** - aryan@indicloud.xyz
