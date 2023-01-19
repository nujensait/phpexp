# Course OTUS PHP_2022, DZ for Lesson No. 14: "Design Patterns"

## A task

### Target
A set of tasks for the implementation of the studied patterns.
You need to solve at least 5 problems.

### Description/step-by-step instructions for completing homework
Choose 5 of 12 patterns:
- Abstract Factory
- Adapter
- Decorator
- Dependency inversion
- Factory method
- Iterator
- Mapper
- Observer
- Proxy
- Prototype
- Strategy
- Visitor
- Request tasks from the teacher
- Implement the pattern based on the proposed code.

## Decision
We implement the following **6** patterns (2 patterns of each of 3 types), using the example of solving real problems:

We are developing a prototype of the kitchen of a fast food restaurant.

We will use the following patterns:
1. **Abstract factory** ~ preparing a meal
   Will be responsible for generating the basic prototype product: burger, sandwich or hot dog
2. **Decorator** ~ adds ingredients to the dish
   when cooking each type of product will add ingredients
   to the base product either by prescription or at the request of the client
   (lettuce, onion, pepper, etc.)
3. **Observer** ~ monitors the process and makes alerts
   Subscribes to the cooking status and sends alerts when
   that the cooking status of the product has changed.
4. **Proxy** ~ checks the product against the standard
   It is used for attaching BEFORE and AFTER events to the cooking process.
   For example, if a burger doesn't meet the standard, the AFTER event will dispose of it.
5. **Strategy** ~ decides what will be cooked
   will be responsible for what needs to be prepared.

(*) All entities should be generated through DI (~ Dependency Injection) to the maximum.

### Deployment / project launch
```
# make checkout
git clone https://github.com/otusteamedu/PHP_2022.git
cd PHP2022
git checkout Mikonnikov_hw14

# setup composer libs
cd code
composer install && composer update

# run docker
cd../
docker-compose build
docker-compose up -d

#go into container
docker exec -it app bash

# run App
php App.php Cook dish=Sandwich
```

### What/how can I cook?

Run example:
```
php App.php Cook dish=HotDog ingredient=Pepper ingredient=Onion
```

#### Launch parameters
**Parameter "dish"**: See ``code/src/Application/Factory/хххFactory.php`` for available dishes:
- Burger
- hot dog
- sandwich

**Parameter "ingredient"**: available ingredients: ```/code/src/Domain/Decorator/xxx.php```
-Onion
- Pepper
- Salad

**Parameter "recipe"**: name of the dish (company recipe)
- any text name without spaces
- for example: ``recipe=FrenchHotDog``

#### Acceptable dish states:
- **Burger**: New -> FryCutlet -> CutBun -> AddIngredients -> Done
- **Hotdog**: New -> BoilSausage -> AddSauces -> CutBun -> AddIngredients -> Done
- **Sandwich**: New -> AddIngredients -> Done

### Launch examples
**Example #1**
```
php App.php Cook dish=Sandwich

PreCookEventListener, event: PreCookEvent
Condition: Brand New Composite Sandwich
Observer: SandwichObserver, State: Adding Ingredients to Composite Sandwich
Condition: Adding Ingredients to the Composite Sandwich
Observer: SandwichObserver, State: Composite sandwich ready
Condition: Composite Sandwich Ready
PostCookEventListener, event: PostCookEvent

Composite Sandwich Cost: 250
```

**Example #2**
```
php App.php Cook dish=HotDog ingredient=Pepper ingredient=Onion

Proxy: Start Cooking Compound Hot Dog
PreCookEventListener, event: PreCookEvent
Condition: New Compound hot dog
Observer: HotDogObserver, State: Cooking a sausage into a Compound hot dog
Condition: Cooking a sausage in a Composite hot dog
Observer: HotDogObserver, State: Adding Sauces to Composite Hot Dog
Condition: Adding Sauces to the Composite Hot Dog
Observer: HotDogObserver, State: Bun mode in Composite hot dog
Condition: Muffin mode into Composite hot dog
Observer: HotDogObserver, State: Adding ingredients to Composite hot dog
Condition: Adding Ingredients to Composite Hot Dog
Observer: HotDogObserver, State: Composite hot dog ready
Condition: Composite hot dog is ready
PostCookEventListener, event: PostCookEvent

Cost of Compound Hot Dog Pepper Onion: 185
```

**Example #3**
```
php App.php Cook dish=Burger ingredient=Onion recipe=BavarianBurger

Proxy: Start cooking BavarianBurger
PreCookEventListener, event: PreCookEvent
Condition: New BavarianBurger
Observer: BurgerObserver, State: Frying a patty at BavarianBurger
Condition: Frying a patty at BavarianBurger
Observer: BurgerObserver, State: Bun mode at BavarianBurger
Condition: Bun Mode at BavarianBurger
Observer: BurgerObserver, State: Adding ingredients to BavarianBurger
Condition: Adding ingredients to BavarianBurger
Observer: BurgerObserver, State: BavarianBurger ready
Status: BavarianBurger ready
PostCookEventListener, event: PostCookEvent

Cost of Bavarian Burger: 350
```