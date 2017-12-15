LiformBundle
============

Bundle that integrates [Liform](https://github.com/Limenius/Liform) into Symfony. Liform is a library to serialize Symfony Forms into [JSON schema](http://json-schema.org/).
For use with [liform-react](https://github.com/Limenius/liform-react) or [json-editor](https://github.com/jdorn/json-editor), or any other form generator based on json-schema.

It is very annoying to maintain Symfony forms that match forms in a client technology, such as JavaScript. It is also annoying to maintain a documentation of such forms. And it's error prone, too.

LiformBundle generates a JSON schema representation, that serves as documentation and can be used to validate your data and, if you want, to generate forms using a generator.

## Installation

First and foremost, note that you have a complete example with React, Webpack and Symfony Standard Edition at [Limenius/symfony-react-sandbox](https://github.com/Limenius/symfony-react-sandbox) ready for you, which includes an example implementation of this bundle.

Feel free to clone it, run it, experiment, and copy the pieces you need to your project. Because this bundle focuses mainly on the frontend side of things, you are expected to have a compatible frontend setup.

### Step 1: Download the Bundle

Open a console, navigate to your project directory and execute the
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

## Usage

Serializing a form into JSON Schema:

```php
        $form = $this->createForm(CarType::class, $car, ['csrf_protection' => false]);
        $schema = json_encode($this->get('liform')->transform($form));
```

And `$schema` will contain a JSON Schema representation such as:

```js
{  
   "title":null,
   "properties":{  
      "name":{  
         "type":"string",
         "title":"Name",
         "propertyOrder":1
      },
      "color":{  
         "type":"string",
         "title":"Color",
         "attr":{  
            "placeholder":"444444"
         },
         "default":"444444",
         "description":"3 hexadecimal digits",
         "propertyOrder":2
      },
      "drivers":{  
         "type":"array",
         "title":"hola",
         "items":{  
            "title":"Drivers",
            "properties":{  
               "firstName":{  
                  "type":"string",
                  "propertyOrder":1
               },
               "familyName":{  
                  "type":"string",
                  "propertyOrder":2
               }
            },
            "required":[  
               "firstName",
               "familyName"
            ],
            "type":"object"
         },
         "propertyOrder":3
      }
   },
   "required":[  
      "name",
      "drivers"
   ]
}
```

## Information extracted to JSON-schema

The goal of Liform is to extract as much data as possible from the form in order to have a complete representation with validation and UI hints in the schema. The options currently supported are.

Check out [the Liform documentation](https://github.com/Limenius/Liform/blob/master/README.md#information-extracted-to-json-schema) for more details.

## Using your own transformers

Liform works by recursively inspecting the form, finding (resolving) the right transformer for every child and using that transformer to build the corresponding slice of the json-schema. So, if you want to modify the way a particular form type is transformed, you can add a transformer and configure it to to be applied for all children with a particular `block_prefix`.  
To achieve this, you should create a new service definition and add the `liform.transformer` tag. You need to specify for which form-types your transformer will be applied by setting the `form_type` property of the tag to the corresponding `block_prefix`.

In the following example we are reusing the StringTransformer class. By specifying the `widget` property of the tag we can scope the transformer to only work for types with that particular widget.  

```yaml
services:
    app.liform.file_type.transformer:
        class: "%liform.transformer.string.class%"
        parent: Limenius\Liform\Transformer\AbstractTransformer
        tags:
            - { name: liform.transformer, form_type: file, widget: file_widget }
```

You can of course use your very own Transformer class, just make sure to implement the required `Limenius\Liform\Transformer\TransformerInterface` when you do.

## Extending the default behaviour

In addition to adding your own transformers for customizing the serialization of a specific form-type Liform allows you to add extensions to customize the default behaviour of all types.  
In the following example we use an Extension to add a `submit_url` property to the schema representing the form's `action` parameter.

```php
<?php

use Limenius\Liform\Transformer\ExtensionInterface;
use Symfony\Component\Form\FormInterface;

class FormDataExtension implements ExtensionInterface
{
    /**
     * @param FormInterface $form
     * @param array         $schema
     *
     * @return array
     */
    public function apply(FormInterface $form, array $schema)
    {
        if (!$form->isRoot()) {
            return $schema;
        }

        if (!$form->getConfig()->hasOption('action')) {
            return $schema;
        }

        $schema['submit_url'] = $form->getConfig()->getOption('action');

        return $schema;
    }
}
```

Make sure your Extension class implements the required `Limenius\Liform\Transformer\ExtensionInterface`. To register your extension; create a new service definition and add the `liform.extension` tag to it.

```yaml
services:
    app.liform.form_data.extension:
        class: MyProject\Application\Liform\FormDataExtension
        tags:
            - { name: liform.extension }
```

## Serializing initial values

This bundle registers a normalizer to serialize a `FormView` class into an array of initial values that match your json-schema. The following example shows you how to use this feature in a controller action:

```php
$serializer = $this->get('serializer');
$initialValues = $serializer->normalize($form);
```

## Serializing errors


This bundle registers a normalizer to serialize forms with errors into an array. This part was shamelessly taken from [FOSRestBundle](https://github.com/FriendsOfSymfony/FOSRestBundle/blob/master/Serializer/Normalizer/FormErrorNormalizer.php). Copy the following statements to use this feature:

```php
$serializer = $this->get('serializer');
$errors = $serializer->normalize($form);
```

The format of the array containing the normalized form errors is compatible with the [liform-react](https://github.com/Limenius/liform-react) package. 

## License

This bundle was released under the MIT license. For the full copyright and license information, please view the LICENSE file that was distributed with this source code.

    LICENSE.md

## Acknowledgements

The technique for transforming forms using resolvers and reducers is inspired on [Symfony Console Form](https://github.com/matthiasnoback/symfony-console-form)
