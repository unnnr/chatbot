
# Documentation
## Preface
Currently, the library is in the starting stages of development, 
so big architectural changes are unavoidable, 
and the first one of them is already coming. 
In the next update, dialog system will be fully rewritten 
to fully async tasks using ReactPHP Promises.


## Booting kernel
To boot an app, you must first define your kernel, as shown below

```php
class Kernel extends \ChatBot\Framework\Kernel
{
    public function getAppClass(): string
    {
        return \Bot\BotApp::class;
    }   

    public function getAppDependencies(): array
    {
        return [
            \Shared\Dependencies\DoctrineDependency::class,
            \Example\Infrastructure\RouterDependency::class,
            \Example\Infrastructure\ClientDependency::class,
            \Example\Infrastructure\ChannelDependency::class,
            \Example\Infrastructure\MatcherDependency::class,
        ];
    }
}
```

and then initialize it in some *index.php* file.

```php
require_once __DIR__.'/vendor/autoload.php';

(new ChatBot\Example\App\Core\Kernel(__DIR__))
  ->boot();
```

## Dependencies

### Creating new dependency
Dependency classes are the place where all the registration needed by your app lies.
Each dependency should extend the `Dependency` class.

The main work is done in `process()` method. 
During container compilation `procces()` is called with the symfony `ContainerBuilder` class
where you can assign all need definitions.

```php
use ChatBot\Framework\DI\Dependency;

class ExampleDependency extends Dependency
{
    public function process(ContainerBuilder $container)
    {
        $container->register(Storage::class, InMemmoryStorage::class)
            ->setPublic(true);
    }
}
```
### Registering dependencies
All dependencies must be returned from the `getAppDependencies` method 
of your `Kernel` as an array of classes.

## Config
By default, config is loaded by the `Kernel` from **config/app.yaml** file.
All defined properties can be accessed from the container `ParameterBag` object.

## Env
Your **.env** file, as usual, must be placed at root directory.
All defined env values can be accessed via the global var `$_ENV` or in the configuration file (thanks to Symfony compiler)

```yaml
app:
  devmode: '%env(DEV_MODE)%'
```

## Routing
Your routes must be placed in an instance of the `RouterDescriptor` class registered as dependency.
`describe()` method defines commands matching to dialog instances.

```php
use ChatBot\Bot\Routing\RouterDescriptor;
use ChatBot\Bot\Routing\RouteMatcher;

class Router implements RouterDescriptor
{
    public function describe(RouteMatcher $matcher): void
    {
        $matcher->on('register', new RegisterUserDialog);
    }
}
```

## Dialogs
**Dialog** is a handler of your bot conversation.
Some type of Controller, roughly speaking.
Each **dialog** has **steps** that hold the logic of your app.
**Steps** are divided into **groups**. 
All **groups** start by waiting for a user request and only then proceeding.

### Descriptor
`DialogDescriptor` defines **step** order and **fallbacks**.
Usually it has some 'shortcuts' for quick setup,
such as validation, or message sender (depending on the descriptor type)

For now, only `AttributeDescriptor` and `BuilderDescriptor` are available.

### Fallbacks
Your descriptor can have a fallback for every **group** and entire **dialog**.