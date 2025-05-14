# Mysql2i

A modern compatibility layer for mysql functions in newer PHP versions.

## Overview

This library provides a bridge between the deprecated mysql extension and the newer mysqli extension, allowing legacy applications to work with newer PHP versions without rewriting all database code.

The Mysql2i library:

- Implements all mysql_* functions using mysqli
- Uses clean object-oriented design with SOLID principles
- Is modular and easy to extend
- Provides a simple drop-in solution for legacy projects

## Installation

### Via Composer

```bash
composer require mysql2i/mysql2i:^1.0
```

The explicit version constraint is necessary until a stable release is published to Packagist.

### Manual Installation

1. Download or clone the repository
2. Include the bootstrap file after your application's autoloader:

```php
require_once 'path/to/mysql2i/src/bootstrap.php';
```

## Usage

Once installed and included, the library will automatically provide mysql_* function compatibility.

### Example

```php
// Connect to database using old mysql_* functions
$connection = mysql_connect('localhost', 'username', 'password');
mysql_select_db('database_name', $connection);

// Run a query
$result = mysql_query("SELECT * FROM users");

// Process results as usual
while ($row = mysql_fetch_assoc($result)) {
    echo $row['name'] . "<br>";
}

mysql_close($connection);
```

## Architecture

The library uses several design patterns:

1. **Adapter Pattern**: Adapts mysqli functionality to the mysql interface
2. **Facade Pattern**: Provides a simplified interface for the mysql functions
3. **Singleton Pattern**: Maintains a single connection manager instance
4. **Factory Pattern**: Creates and manages adapter instances

## Publishing to Packagist

If you want to publish this package to Packagist for easier installation via Composer:

1. Create a repository on GitHub or another Git hosting service
2. Push the code to the repository
3. Go to https://packagist.org/packages/submit
4. Submit your repository URL
5. Once approved, you can install it via Composer with `composer require mysql2i/mysql2i`

## Development

### Running Tests

```bash
php tests/Mysql2iTest.php
```

### Creating a Release

1. Update the version number in `composer.json`
2. Commit and push changes
3. Create a new release/tag in your Git repository
4. Packagist will automatically update the package information

## License

This library is released under the MIT License.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request. 