# Autowired
With the new Autowired component you have now the possibility to easily load all your dependencies during construction of your main object.  

## There are so many other DIC solutions available why I should use this one?

The main idea of this component is to be stand alone and not depending of any other third party component in order to be ready for use.
Other components are as well great, and we used a lot of different components already but do you know how many other components are needed in order to run a normal DIC container and even you have to sometimes maintain several files in order to keep the overview.
The main purpose for this component is to keep your live simple and easy and don´t get headache and get lost in files or complex definitions.

## Required third party dependencies

### Runnable requirements:

In order to use this component in a production system you have to run at least PHP version 8.0.*

### Development requirements
As dev requirement, if you want to contribute, phpunit version 9.4.* is required.

## Features of Autowired component

- Easy dependency injection without define your constructor
- Specify if your required dependency can be a shared instance or create everytime a new instance of the dependency.
- Easy to mock autowired object for your test purpose.
- Dependency injection using an interface


## How to use it ?
```
class Example {
    
    #[Autowired]  // Cached object should be used
    private Foo $foo;

    #[Autowired(false)] // Cached object should not be used
    private DateTime $dateTime;   
}

$container = DependencyContainer::getInstance();

$example = $container->get(Example::class));
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

## How to inject a class but using an interface?

With version 0.0.4 we introduce a new parameter for the Autowired class: $concreteClass
Specify this parameter directly or full fill non mandatory parameters. Take a look to the example below.

```
class Bar
{
    #[Autowired(concreteClass: Foo::class)]
    private FooInterface $foo;

    #[Autowired(cachingAllowed: true, concreteClass: Foo::class)]
    private FooInterface $foo;

    #[Autowired(false, Foo::class)]
    private FooInterface $foo;
}
```

## How to autowire a class with a factory method?

With the version 0.0.5 we introduced a new parameter for the Autowired class: $staticFunction
Specify this parameter directly or fulfill none mandatory parameters. Take a look to the example

```
class Bar
{
    #[Autowired(staticFunction: "getInstance")]
    private Foo $foo;
    
    #[Autowired(concreteClass: Foo::class, staticFunction: "getInstance")]
    private FooInterface $fooWithInterface;

    public function getFoo(): Foo
    {
        return $this->foo;
    }

    public function getFooWithInterface(): FooInterface
    {
        return $this->fooWithInterface;
    }
}
```


## How to mock classes when they will be autowired?

Actually there are two possibilities.

1. Define your mocks and put them as an array as a second parameter when you call DependencyContainer::get(CLASSNAME, [MOCK1, MOCK2 ...]). The Autowired component will only try to load the related objects only when the property has his initial value (null). Please take a look to the example
   
```
class WithConstructor
{
    #[Autowired]
    private ?Foo $foo;

    #[Autowired]
    private ?Bar $bar;

    public function getFoo(): ?Foo
    {
        return $this->foo;
    }
}

Meanwhile in the test method do the following


private DependencyContainer $container;

protected function setUp(): void
{
    $this->container = DependencyContainer::getInstance();
    parent::setUp();
}

protected function tearDown(): void
{
    $this->container->flush();
    parent::tearDown();
}
    
public function autoloadWithMockedClassAndConstructor(): void
{
    $mockedClass = $this->getMockBuilder(Foo::class)
        ->getMock();

    $mainClassWithMockedObject = $this-container->get(WithConstructor::class,[$mockedClass]);

    static::assertNotEquals($mockedClass::class, $mainClassWithMockedObject->getFoo()::class);
}
```


2. The other way is to define your mock and call DependencyContainer::store() function in order to place the mock behind the original class name 

```
class WithNoConstructor
{
    #[Autowired]
    private Foo $foo;

    #[Autowired]
    private Bar $bar;

    public function getFoo(): Foo
    {
        return $this->foo;
    }

    public function getBar(): Bar
    {
        return $this->bar;
    }
}

Meanwhile in the test method to the following

public function autoloadWithMockedClassAndWithoutConstructor(): void
{
    $mockedClass = $this->getMockBuilder(Foo::class)
        ->getMock();

    $autowiredServiceCache = CachingService::getInstance();
    $autowiredServiceCache->store($mockedClass, Foo::class);
    $mainClassWithMockedObject = new WithNoConstructor();

    static::assertEquals($mockedClass::class, $mainClassWithMockedObject->getFoo()::class);
    static::assertNotEquals(Foo::class, $mainClassWithMockedObject->getFoo()::class);
    static::assertEquals(Bar::class, $mainClassWithMockedObject->getBar()::class);
    CachingService::getInstance()->flushCache();
}
```
