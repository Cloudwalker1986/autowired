# Autowired
With the new Autowired component you have now the possibility to easily load all your dependencies during construction of your main object.  

## Required third party dependencies

In order to use this component in a production system you have to run at least PHP version 8.0.*

As dev requirement, if you want to contribute, phpunit version 9.4.* is required.

## Features of Autowired component

- Easy dependency injection without define your constructor
- Specify if your required dependency can be a shared instance or create everytime a new instance of the dependency.

## How to use it ?
```
class Example {
    
    use AutowiredHandler;

    #[Autowired]  // Cached object should be used
    private Foo $foo;

    #[Autowired(false)] // Cached object should not be used
    private DateTime $dateTime;   
}

$example = new Example();
var_export($example);
```
Output
```
AutowiredTest\Cases\Autoload\Example::__set_state(array(
   'foo' => 
  Foo::__set_state(array(
  )),
   'dateTime' => 
  DateTime::__set_state(array(
     'date' => '2020-12-03 12:25:09.197889',
     'timezone_type' => 3,
     'timezone' => 'UTC',
  )),
))
```

## Workaround

Currently, the trait AutowiredHandler is overwriting the construct method of the class where you want to use the autowired component.
If you still need the original constructor due to pre operation before the instance got back assigned to your variable than you need to call first $this->autowired().

Take a look to the example:
```
class Example {
    
    use AutowiredHandler;

    #[Autowired]  // Cached object should be used
    private UserService $userService;   
    
    private array users;
    
    public function __construct() 
    {
        $this->autowired();
        $user = $this->userService->getAll();
    }
}
```