LiformBundle
============

Bundle to serialize Symfony Forms into [JSON schema](http://json-schema.org/). For use with [react-liform](https://github.com/Limenius/react-liform) or [json-editor](https://github.com/jdorn/json-editor), or any other form generator based in json-schema.

It is very annoying to maintain Symfony forms that match forms in a client technology, such as JavaScript. It is also annoying to maintain a documentation of such forms. And error prone.

LiformBundle generates a JSON schema representation, that serves as documentation and can be used to validate your data, and, perhaps more interestingly, to generate forms.

# Installation


First and foremost, note that you have a complete example with React, Webpack and Symfony Standard Edition at [Limenius/symfony-react-sandbox](https://github.com/Limenius/symfony-react-sandbox) ready for you. Feel free to clone it, run it, experiment, and copy the pieces you need to your project. Being this bundle a frontend-oriented bundle, you are expected to have a compatible frontend setup.

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

    $ composer require limenius/liform-bundle

This command requires you to have Composer installed globally, as explained
in the *installation chapter* of the Composer documentation.

### Step 2: Enable the Bundle

Then, enable the bundle by adding the following line in the `app/AppKernel.php`
file of your project:

```php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Limenius\LiformBundle\LimeniusLiformBundle(),
        );

        // ...
    }

    // ...
}
```

# Usage

Serializing a form into JSON Schema:

```php
        $form = $this->createForm(CarType::class, $car, ['csrf_protection' => false]);
        $schema = json_encode($this->get('liform')->transform($form));
```


# License

This bundle is under the MIT license. See the complete license in the bundle:

    LICENSE.md

Acknoledgements
===============

The technique for transforming forms using resolvers and reducers is inspired on [Symfony Console Form](https://github.com/matthiasnoback/symfony-console-form)
