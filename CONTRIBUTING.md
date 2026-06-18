# Contributing to Indium Panel

Thank you for your interest in contributing to **Indium Panel**! We welcome contributions from everyone. Here's how you can help:

## How to Contribute

### Reporting Issues

1. **Search for duplicates**: Before creating a new issue, please check if a similar issue already exists.
2. **Create a new issue**: If no existing issue matches your report, feel free to create a new issue. Make sure to include detailed information such as:
    - A clear description of the issue
    - Steps to reproduce the problem
    - Expected vs. actual behavior
    - Relevant logs or screenshots, if applicable
3. **Bug Reports**: Clearly explain the problem and how to reproduce it. Include information about your environment (e.g., OS, PHP version, Pterodactyl version).

### Suggesting Features

We love new ideas! If you have a feature request, follow these steps:
1. **Search for similar suggestions**: Check our existing feature requests.
2. **Submit a new feature request**: If your idea is new, please create a new issue and describe the feature and explain its use case.

### Submitting Pull Requests

1. **Create a new branch**: Use a descriptive name for your branch. See [Branch Naming](#branch-naming) below.
2. **Make changes**: Add your code, following our coding standards:
    - Follow PSR-12 for PHP.
    - Write clear, concise code with comments where necessary.
    - Write tests for your code whenever possible.
3. **Commit your changes**: Write meaningful and descriptive commit messages. See [Commit Messages](#commit-messages) below.
4. **Push to your branch**: Push the changes from your local repository.
5. **Submit a pull request**: Make sure your PR targets the `main` branch.

## Branch Naming

Use the following naming conventions for your branches:

- `feature/<name>` — new functionality (e.g. `feature/add-payment-integration`)
- `bugfix/<name>` — bug fixes (e.g. `bugfix/fix-user-auth`)
- `hotfix/<name>` — urgent fixes for production issues
- `task-<id>-<name>` — tasks tracked in the issue tracker (e.g. `task-42-improve-logging`)

## Commit Messages

Write clear, descriptive commit messages in English. Focus on what the change does and why:

**Good examples:**
- `Add user balance notification on low funds`
- `Fix server suspension not triggered on expired subscription`
- `Refactor payment gateway to support multiple providers`

Avoid vague messages like `fix`, `update`, or `WIP`.

## Pull Request Process

1. **Target `main`** — all PRs should target the `main` branch.
2. **CI pipeline must pass** — the CI pipeline runs automatically on every PR. A PR with a failing pipeline will not be reviewed.
3. **Code review** — a maintainer will review your pull request. Be patient; we will provide feedback as soon as possible.
4. **Address all comments** — all review comments must be addressed before the PR can be merged.
5. **Resolve all threads** — all discussion threads must be marked as resolved before merge.
6. **Merge** — once approved and all checks pass, a maintainer will merge the PR.

## Setting Up Your Development Environment

Indium Panel uses Docker for local development. Make sure you have [Docker](https://docs.docker.com/get-docker/) and [Docker Compose](https://docs.docker.com/compose/install/) installed.

1. **Clone the repository**:
    ```bash
    git clone <repository-url>
    cd panel
    ```

2. **Configure environment**:
    ```bash
    cp .env.SAMPLE .env
    # Edit .env with your local settings
    ```

3. **Start the containers**:
    ```bash
    docker-compose up -d
    ```

4. **Run migrations**:
    ```bash
    docker exec -it indium_web_dev bin/console doctrine:migrations:migrate
    ```

5. **Start developing!**

> All Symfony and Composer commands must be executed inside the `indium_web_dev` container:
> ```bash
> docker exec -it indium_web_dev bin/console [symfony-command]
> docker exec -it indium_web_dev composer [composer-command]
> ```

## Helping with Translations

We want Indium Panel to be accessible to users all over the world. If you're interested in helping translate Indium Panel into more languages, you can contribute directly via a pull request.

**Important rules for translations:**

- When **adding new translation keys or editing existing ones**, update all language files located in `src/Core/Resources/translations/`.
- The English file (`messages.en.yaml`) is the reference — make sure the key exists there first, then add the translated value to each other language file.
- The CI pipeline checks for missing translation keys — your PR will fail if any language file is incomplete.

## Community Guidelines

- **Be respectful**: We value a welcoming, respectful, and inclusive community. Disrespectful or inappropriate behavior will not be tolerated.
- **Collaboration**: Help fellow contributors by reviewing pull requests and participating in discussions.

## License

By contributing to Indium Panel, you agree that your contributions will be licensed under the [MIT License](LICENSE).
