Usage
=====

El bundle provee de varias funcionalidades listas para usar.

Adminitración básica
--------------------

Para probarlo puede incluir la administración en su lista de rutas.

    # app/config/routing.yml
    positibe_news_admin:
        resource: "@PositibeNewsBundle/Resources/config/admin_routing.yml"
        prefix: /admin

Ahora pruebe entrando en la dirección `localhost:9090/admin/news/new` para crear una noticia nueva. Además posee otras:

Si debuguea las rutas de la aplicación verá todas las nuevas rutas que ahora posee

    ...
    positibe_news_admin_news_create   GET|POST ANY    ANY  /admin/news/new
    positibe_news_admin_news_show     GET      ANY    ANY  /admin/news/{slug}
    positibe_news_admin_news_update   GET|PUT  ANY    ANY  /admin/news/{slug}/edit
    positibe_news_admin_news_delete   DELETE   ANY    ANY  /admin/news/{slug}
    positibe_news_admin_news_index    GET      ANY    ANY  /admin/news/
    positibe_news_comment_create      GET|POST ANY    ANY  /admin/comments/new
    positibe_news_comment_show        GET      ANY    ANY  /admin/comments/{id}
    positibe_news_comment_update      GET|PUT  ANY    ANY  /admin/comments/{id}/edit
    positibe_news_comment_delete      DELETE   ANY    ANY  /admin/comments/{id}
    positibe_news_comment_index       GET      ANY    ANY  /admin/comments/
    ...

Frontend
--------

Posee además rutas especificadas en la presentación, frontend o vista de usuario final. Para tenerlas en tu
aplicación basta con agregar la ruta:

    # app/config/routing.yml
    positibe_news:
        resource: "@PositibeNewsBundle/Resources/config/news_routing.yml"

Si debuguea las rutas de la aplicación verá todas las nuevas rutas que ahora posee

    ...
    positibe_news_news_show           GET      ANY    ANY  /{slug}
    positibe_news_news_index          GET      ANY    ANY  /
    positibe_news_news_comment_create GET|POST ANY    ANY  /{slug}/comments/new
    ...
