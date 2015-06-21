Instalación
===========

Este bundle requiere de varios otros bundles y librerías para trabajar apropiadamente,
siempre mire la configuración de todas las librerías instaladas por si tiene algún error de configuración

Instalación
-----------

Retrieve the bundle with composer:

    php composer.phar require positibe/news-bundle ~0.0

Las librerías instaladas son pueden ser vistas en el archivos composer.json de la instalación de la librería e incluye:

1. gedmo/doctrine-extensions
2. sylius/resource-bundle
3. egeloen/ckeditor-bundle
4. sonata-project/media-bundle
5. positibe/classification-bundle

Agregando los bundle a AppKernel
--------------------------------

Es necesario agregar estos bundles a la configuración

    public function registerBundles()
    {
        $bundles = array(
            // Tus bundles
            // ...
            new Positibe\Bundle\ClassificationBundle\PositibeClassificationBundle(),
            new Positibe\Bundle\NewsBundle\PositibeNewsBundle(),
            new Application\Sonata\MediaBundle\ApplicationSonataMediaBundle(),

            new FOS\RestBundle\FOSRestBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle($this),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new Genemu\Bundle\FormBundle\GenemuFormBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\IntlBundle\SonataIntlBundle(),
            new Sonata\MediaBundle\SonataMediaBundle(),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new Sylius\Bundle\ResourceBundle\SyliusResourceBundle(),
            //...
            )
    }

Configuración
-------------

### DoctrineExtension ###

La librería DoctrineExtension es usada para crear el slug y para manejar las fechas. Por lo que necesita habilitar
estas extensiones:

    # app/config/services.yml
    services:
        # ...
        gedmo.listener.timestampable:
            class: Gedmo\Timestampable\TimestampableListener
            tags:
                - { name: doctrine.event_subscriber, connection: default }
            calls:
                - [ setAnnotationReader, [ @annotation_reader ] ]

        gedmo.listener.sluggable:
            class: Gedmo\Sluggable\SluggableListener
            tags:
                - { name: doctrine.event_subscriber, connection: default }
            calls:
                - [ setAnnotationReader, [ @annotation_reader ] ]

> También puede agregar stof/doctrine-extension-bundle para manejar la configuración de esta librería.


### SyliusResourceBundle ###

El bundle SyliusResourceBundle es usado para varias funciones en el bundle: Mapeo de objetos,
Creación de servicios para el manejo de los modelos:

Este bundle permite redefinir y sobreescribir las clases fundamentales usadas por el bundle mediante configuración.


### Ckeditor ###

El editor que usa el bundle es CKeditor, El budnle IvoryCkeditorBundle permite varias configuraciones. Las
configuración básica es:

    # app/config/config.yml
    # ...
    ivory_ck_editor:
        configs:
            basic:
                toolbar: basic
            standard:
                toolbar: standard


### Imagenes ###

El bundle permite agregarle una imágen destacada a las noticias. Estas son manejadas por el bundle SonataMediaBundle.
 La configuración de este bundle así como las posibilidades que permiten son muchos más grandes que las que se
 muestran aquí. Remítase a la documentación de este bundle para sacarle el mayor provecho.

    # app/config/config.yml
    sonata_media:
        default_context: default
        db_driver: doctrine_orm # or doctrine_mongodb, doctrine_phpcr
        contexts:
            default:  # the default context is mandatory
                providers:
                    - sonata.media.provider.dailymotion
                    - sonata.media.provider.youtube
                    - sonata.media.provider.image
                    - sonata.media.provider.file

                formats:
                    small: { width: 100 , quality: 70}
                    big:   { width: 500 , quality: 70}
            news:
                providers:
                    - sonata.media.provider.youtube
                    - sonata.media.provider.image

                formats:
                    small: { width: 200 , quality: 95}
                    big:   { width: 500 , quality: 90}
        cdn:
            server:
                path: /uploads/media # http://media.sonata-project.org/

        filesystem:
            local:
                directory:  %kernel.root_dir%/../web/uploads/media
                create:     false
    # ...
    fos_rest:
        routing_loader:
            default_format: json
    # ...
    doctrine:
        dbal:
            # ...
            types:
                json: Sonata\Doctrine\Types\JsonType

SonataMediaBundle necesita crear las entidades con las que trabaja el sistema. Para esto solo tiene que ejecutar el
siguiente comando:

    php app/console sonata:easy-extends:generate --dest=src SonataMediaBundle


### PositibeNewsBundle ###

El bundle incluye una plantilla que personaliza el campo de imagenes por defecto de sonata.

    # app/config/config.yml
    twig:
        #...
        form:
            resources:
                # other files
                - 'PositibeNewsBundle:Form:sonata_media_widgets.html.twig'

El bundle usa el PositibeClassificationBundle que provee un mecanismo bastante eficiente de etiquetas.
Del punto de vista visual es necesario agregar algunas librerías para que pueda lucir bien y ser realmente útil.
Estas deben agregarse manualmente en el documento base.html.twig de tu aplicación o en la pagina específica que desee
 agregar el mecanismo de tags. Las librerías dependentes se listan abajo en forma de uso.

    # app/Resources/views/base.html.twig
    <head>
        {# ... #}
        <link rel="stylesheet" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/libs/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/libs/jquery/plugins/chosen/chosen.min.css') }}">
        <link rel="stylesheet"
              href="{{ asset('assets/libs/bootstrap/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}">
        {# ... #}
    </head>
    <body>
        {# ... #}
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}" type="application/javascript"></script>
        <script src="{{ asset('assets/libs/jquery/jquery-migrate.min.js') }}" type="application/javascript"></script>
        <script src="{{ asset('assets/libs/jquery/plugins/chosen/chosen.jquery.min.js') }}"
                type="application/javascript"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.min.js') }}" type="application/javascript"></script>
        <script src="{{ asset('assets/libs/bootstrap/plugins/bootstrap-fileupload.js') }}"
                type="application/javascript"></script>
        <script src="{{ asset('assets/libs/bootstrap/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}"
                type="application/javascript"></script>
        {# ESTO SI ES NECESARIO PARA QUE FUNCIONE CORRECTAMENTE EL CHOSEN #}
        <script type="text/javascript">
            var config = {
                '.chosen-select': {},
                '.chosen-select-deselect': {allow_single_deselect: true},
                '.chosen-select-no-single': {disable_search_threshold: 10},
                '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                '.chosen-select-width': {width: "95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
        </script>
        {# ... #}
    </body>

> Note que al final las utilidades que usa son para Bootstrap, Font-Awesome, Jquery, Jquery-Chosen,
Bootstrap-fileupload y Boostrap-fileinput. Si posee otras formas de obtenerlas (e.j. vía google code) puede hacerlo
perfectamente.

Para poder formatear datos en la vistas que posee el bundle correctamente se usan funciones de Twig que deben
habilitarse. Si no las posee activas y usa las plantillas del bundle se recomienda agregarlo.

    # app/config/services.yml
    services:
        # ...
        twig.extension.text:
            class: Twig_Extensions_Extension_Text
            tags:
                - { name: twig.extension }

        twig.extension.intl:
            class: Twig_Extensions_Extension_Intl
            tags:
                - { name: twig.extension }

Otras acciones
--------------

Actualizar el esquema en base a los cambios realizados

    php app/console doctrine:schema:update --force

Actualice los assets de su aplicación:

    php app/console assets:install --symlink

Crear los directorios donde se alojarán las imagenes subidas:

    mkdir web/uploads
    mkdir web/uploads/media
    chmod -R 0777 web/uploads