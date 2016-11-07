# PhongoDB

#### What am I ?
Hi, my name is PhongoDB and I'm an ORM with sidekick called ActiveRecord.
We were built for those who are tired of tools to manipulate MySQL databases and want something cool for MongoDB.

#### Installation
``` bash
    composer install --no-dev
```

#### Tests
``` bash
    phpunit tests/ --bootstrap vendor/autoload.php
```

#### How do I work ?
Well, it depends on how you want me to do my job.

##### Active Record
I can be a simple ActiveRecord with many ways to validate myself.
``` php
    class SimpleModel extends ActiveRecord {
        
        public $id;
        
        /**
         * @Column(string)
         * @MaxLength(150)
         */
        public $name;
        
        /**
         * @Type(int)
         * @MaxLength(100)
         */
        public $age;
        
    }
```

And this is how I work as a ActiveRecord.
``` php
    $model = new SimpleModel;
    $model->name = "PhongoDB";
    $model->age = 1;
    
    //Pass false through argument in case you don't wanna validate your model data
    $response = $model->save();
```
##### Repository
Here is a simple example of how I work as a Repository.
I can use both a class extended by an ActiveRecord and a Model class.
``` php
    $baseRepository = new BaseRepository(new SimpleModel);
    $arrayList = $baseRepository->findAll();
    
    $amountOfRegisters = $arrayList->length();
    foreach ($arrayList as $simpleModel) {
        //do something with model
    }
```
