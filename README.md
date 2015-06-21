Dependencias
------------


1. Se requiere tener habilitada las extension de Text de twig
    # app/config/services.yml
    twig.extension.text:
        class: Twig_Extensions_Extension_Text
        tags:
            - { name: twig.extension }

    twig.extension.intl:
        class: Twig_Extensions_Extension_Intl
        tags:
            - { name: twig.extension }

2. Se requiere incluir la librería de Gedmo Extenstion para la creación delo slug, permalink, actualización de fechas:

    php composer.phar require gedmo/doctrine-extension ~2.2.0

    o

    php composer.phar require stof/doctrine-extension-bundle ~1.0

Debe habilitar las extensiones sluggable y timestamp

3. El bundle funciona con el bundle SyliusResourceBundle instlar la última version