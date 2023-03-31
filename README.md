Scaricato il repo in locale, sarà sufficiente 
- generare il file .env (configurare un mailer, es mailtrap)
- lanciare i comandi
    composer install
    sail up
    sail artisan migrate --seed

Tutti gli utenti hanno password "password" (e quindi sono tutti ugualmente utilizzabili), in ogni caso ho creato due utenti test con email
    pm@example.com
    dev@example.com


todo
    permessi
    homepage
    grafica
    errori