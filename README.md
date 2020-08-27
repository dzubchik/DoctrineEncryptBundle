# DoctrineEncryptBundle

![GitHub Workflow Status (branch)](https://img.shields.io/github/workflow/status/paycoreio/DoctrineEncryptBundle/PHP%20Composer/master?style=flat-square)

Bundle allows to create doctrine entities with fields that will be protected with 
help of some encryption algorithm in database and it will be clearly for developer, because bundle is uses doctrine life cycle events

This is an fork from the original bundle created by vmelnik-ukrain (Many thanks to him) which can be found here:
[vmelnik-ukraine/DoctrineEncryptBundle](https://github.com/vmelnik-ukraine/DoctrineEncryptBundle)

I improved several things, i make better use of the doctrine events. and it works with lazy loading (relationships)!
This will be an long term project we will be working on with long-term support and backward compatibility. We are using this bundle in all our own symfony2 project.
More about us can be found on our website. [paycore.io](https://paycore.io)

### What does it do exactly

It gives you the opportunity to add the @Encrypt annotation above each string property

```php
/**
 * @Encrypt
 */
protected $username;
```

The bundle uses doctrine his life cycle events to encrypt the data when inserted into the database and decrypt the data when loaded into your entity manager.
It is only able to encrypt string values at the moment, numbers and other fields will be added later on in development.

### Advantages and disadvantaged of an encrypted database

#### Advantages
- Information is stored safely
- Not worrying about saving backups at other locations
- Unreadable for employees managing the database

#### Disadvantages
- Can't use ORDER BY on encrypted data
- In SELECT WHERE statements the where values also have to be encrypted
- When you lose your key you lose your data (Make a backup of the key on a safe location)

### Documentation

This bundle is responsible for encryption/decryption of the data in your database.
All encryption/decryption work on the server side.

The following documents are available:

* [Installation](https://github.com/paymaxi/DoctrineEncryptBundle/blob/master/Resources/doc/installation.md)
* [Configuration](https://github.com/paymaxi/DoctrineEncryptBundle/blob/master/Resources/doc/configuration.md)
* [Usage](https://github.com/paymaxi/DoctrineEncryptBundle/blob/master/Resources/doc/usage.md)
* [Console commands](https://github.com/paymaxi/DoctrineEncryptBundle/blob/master/Resources/doc/commands.md)
* [Custom encryption class](https://github.com/paymaxi/DoctrineEncryptBundle/blob/master/Resources/doc/custom_encryptor.md)

### License

This bundle is under the MIT license. See the complete license in the bundle

### Versions

I'm using Semantic Versioning like described [here](http://semver.org)
